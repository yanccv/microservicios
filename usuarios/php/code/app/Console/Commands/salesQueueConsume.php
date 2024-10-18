<?php

namespace App\Console\Commands;

use App\Jobs\saleAdded;
use Illuminate\Console\Command;

// use App\Jobs\salesAdded;
use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Clase encargada de consumir la cola de los sales o ventas
 */
class salesQueueConsume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:salesQueueConsume';
    protected $description = 'Consume messages from SalesQueue';

    protected $connection;
    protected $channel;

    public function __construct()
    {
        parent::__construct();

        // Establecer conexión con RabbitMQ
        $this->connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST', config('queue.connections.rabbitmq.host')),
            env('RABBITMQ_PORT', config('queue.connections.rabbitmq.port')),
            env('RABBITMQ_USER', config('queue.connections.rabbitmq.username')),
            env('RABBITMQ_PASSWORD', config('queue.connections.rabbitmq.password'))
        );

        $this->channel = $this->connection->channel();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        echo 'handler salesQueueCommand';
        $queue = 'userBySale'; // Nombre de la cola que estás usando
        $this->channel->queue_declare($queue, false, true, false, false, false, []);

        // Definir la función de callback para manejar los mensajes
        $callback = function ($msg) {
            $data = (object) json_decode($msg->body, true);
            print_r($data->data);
            switch (substr($data->job, strrpos('/', $data->job))) {
                case 'saleAdded':
                    $saleAdded = new saleAdded($data->data);
                    $saleAdded->handle();
                break;
                default:
                    # code...
                    break;
            }
            // Confirmar el mensaje como procesado
            $msg->ack();
        };

        // Escuchar la cola
        $this->channel->basic_consume($queue, '', false, false, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
        return Command::SUCCESS;
    }

    public function __destruct()
    {
        // Cerrar el canal y la conexión
        $this->channel->close();
        $this->connection->close();
    }
}
