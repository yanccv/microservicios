<?php

namespace App\Repositories;

use App\Interfaces\SendMessagesInterface;
use Illuminate\Support\Facades\Queue;

class SendMessagesQueue implements SendMessagesInterface
{
    protected $queue;

    public function __construct()
    {
        $this->queue = 'salesQueue';
    }


    /**
     * Envia mensajes a la cola definida
     * @param mixed array $message a enviar a la cola
     * @param string $job nombre del job a ejecutar en donde se procese la cola
     * @param string $routingKey de la cola
     *
     * @return void
     */
    public function sendMessage(array | int | string $message, string $queueName, string $job, string $routingKey): void
    {
        Queue::pushOn($queueName, $job, $message, $routingKey);
    }
}
