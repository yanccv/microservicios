<?php
namespace App\Services;

use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Support\Facades\Queue;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQProducer
{

    protected $connection;
    protected $channel;

    public function __construct()
    {
        // Crear una conexión AMQP con los detalles de RabbitMQ (host, port, user, password)
        $this->connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST', config('queue.connections.rabbitmq.host')),
            env('RABBITMQ_PORT', config('queue.connections.rabbitmq.port')),
            env('RABBITMQ_USER', config('queue.connections.rabbitmq.username')),
            env('RABBITMQ_PASSWORD', config('queue.connections.rabbitmq.password'))
        );

        // Crear un canal desde la conexión
        $this->channel = $this->connection->channel();
    }


    public function publishUserAdded($data, $exchange = '', $routingKey = '')
    {
        // Obtener el canal de RabbitMQ desde la conexión de Laravel
        // Crear el mensaje AMQP
        $message = json_encode($data);
        // $message = $data;
        // $message = new AMQPMessage($messageBody, [
        //     'content_type' => 'application/json',
        //     'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        // ]);
        $message = new AMQPMessage($message);



        // Publicar el mensaje en el exchange y con la routing key apropiada
        $exchange = empty($exchange) ? 'usuariosExchange' : $exchange;  // Ajustar según tu configuración
        $routingKey = empty($routingKey) ? 'user.added' : $routingKey;
        $queue_name = 'usuariosQueue';

        // $this->channel->queue_declare($queue_name, false, true, false, false);
        // $this->channel->exchange_declare(
        //     $exchange,    // Nombre del exchange
        //     'direct',     // Tipo de exchange (puede ser 'direct', 'topic', 'fanout', 'headers')
        //     false,        // No pasivo, para crearlo si no existe
        //     true,         // Durable, para que persista aunque RabbitMQ se reinicie
        //     false         // No auto-delete
        // );

        // echo 'Mensaje a Enviar: '.$message;
        try {
            $this->channel->basic_publish($message, $exchange, $routingKey);
        } catch (\Throwable $th) {
            echo "Error al enviar el mensaje: " . $th->getMessage() . "\n";
            throw new \Exception("Fallo envio ", 1);

        }
    }

    public function __destruct()
    {
        // Cerrar el canal y la conexión cuando se destruya la clase
        // $this->channel->close();
        // $this->connection->close();
    }
}
