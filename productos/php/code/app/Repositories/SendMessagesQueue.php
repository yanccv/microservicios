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

    public function sendMessage(array | int | string $message, string $job, string $routingKey): void
    {
        // \Amqp::publish($this->queue, json_encode($message)); // RabbitMQ ejemplo
        Queue::pushOn('productosQueue', $job, $message, $routingKey);
    }
}
