<?php

namespace App\Console\Commands;

use App\Jobs\userAdded;
use App\Jobs\userDeleted;
use App\Jobs\userUpdated;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Illuminate\Support\Facades\App;

class RabbitMQConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:consumes';
    protected $description = 'Consume messages from RabbitMQ';

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

    public function getDataFromQueue()
    {
        // Logic to retrieve data from the queue
        $data = $this->channel->basic_get('usuariosQueue');
        // Process the data and return it
        return $data;
    }

    public function handle()
    {
        echo 'handler RabbitMQConsumer';
        // Declarar la cola que se va a consumir
        $queue = 'usuariosQueue'; // Nombre de la cola que estás usando
        $exchange_name ="usuariosExchange";
        // $this->channel->exchange_declare($exchange_name, 'direct', true, false, false);
        $this->channel->queue_declare($queue, false, true, false, false, false, []);

        // Definir la función de callback para manejar los mensajes
        $callback = function ($msg) {
            // Obtener el contenido del mensaje
            $data = (object) json_decode($msg->body, true);
            // $jobExecute =
            // print_r($data);
            // Despachar el Job para procesar el mensaje
            // userAdded->handle($data);
            echo PHP_EOL.'job:'.$data->job;
            echo PHP_EOL.'ini:'.strrpos('\\', $data->job);
            echo PHP_EOL.'word:'.$data->job, strrpos('\\', $data->job);

            print_r(substr($data->job, strrpos('/', $data->job)));
            switch (substr($data->job, strrpos('/', $data->job))) {

                case 'userAdded':
                    $userAdded = new userAdded($data->data);
                    $userAdded->handle();
                break;
                case 'userUpdated':
                    $userUpdated = new userUpdated($data->data);
                    $userUpdated->handle();
                break;
                case 'userDeleted':
                    $userDeleted = new userDeleted($data->data['id']);
                    $userDeleted->handle();
                break;

                default:
                    # code...
                    break;
            }
            // if ($msg->getJobId() == 'App\Jobs\userAdded') {
            // } else {
            //     echo PHP_EOL.'JobId: '.$msg->getJobId();
            // }
            // userAdded::dispatch($data);
            // App::bindMethod(userAdded::class, fn($obj) => $obj->handle());
            // App::bindMethod(userUpdated::class, fn($obj) => $obj->handle());
            // App::bindMethod(userDeleted::class, fn($obj) => $obj->handle());

            // Confirmar el mensaje como procesado
            $msg->ack();
        };

        // Escuchar la cola
        $this->channel->basic_qos(null, 1, null);
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
