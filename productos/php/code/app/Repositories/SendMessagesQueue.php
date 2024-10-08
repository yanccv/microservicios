<?php
namespace App\Repositories;

use App\Interfaces\SendMessageInterface;

class SendMessagesQueue implements SendMessageInterface
{
    protected $queue;

    public function __construct()
    {
        // Configura la cola de productos
        $this->queue = 'productosQueue';
    }

    public function sendMessage(array $message, string $job, string $routingKey): void
    {
        // Lógica para enviar el mensaje a la cola de productos
        // Aquí podrías usar RabbitMQ o cualquier otro sistema de mensajería que estés utilizando.
        // \Amqp::publish($this->queue, json_encode($message)); // RabbitMQ ejemplo
        Queue::pushOn('productosQueue', $job, $message, $routingKey);
    }
}
