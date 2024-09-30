<?php

namespace App\Console\Commands;

use App\Jobs\productAdded;
use App\Jobs\productDeleted;
use App\Jobs\productUpdated;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class productosQueueConsume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:productosQueueConsume';
    protected $description = 'Consume messages from ProductsQueue';

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
        echo 'handler productsQueueCommand';
        $queue = 'productosQueue'; // Nombre de la cola que estás usando
        // $exchange_name ="productosExchange";
        // $this->channel->exchange_declare($exchange_name, 'direct', true, false, false);
        $this->channel->queue_declare($queue, false, true, false, false, false, []);

        // Definir la función de callback para manejar los mensajes
        $callback = function ($msg) {
            $data = (object) json_decode($msg->body, true);
            // echo PHP_EOL.gettype($data->data);
            print_r($data->data);
            // var_dump($data->data);
            switch (substr($data->job, strrpos('/', $data->job))) {
                case 'productAdded':
                    $productAdded = new productAdded($data->data);
                    $productAdded->handle();
                break;
                case 'productUpdated':
                    $productUpdated = new productUpdated($data->data);
                    $productUpdated->handle();
                break;
                case 'productDeleted':
                    $productDeleted = new productDeleted($data->data['id']);
                    $productDeleted->handle();
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
    }

    public function __destruct()
    {
        // Cerrar el canal y la conexión
        $this->channel->close();
        $this->connection->close();
    }
}
