<?php
namespace App\Interfaces;

interface SendMessageInterface
{
    /**
     * Envía un mensaje a la cola.
     *
     * @param array $message
     * @return void
     */
    public function sendMessage(array $message, string $job, string $routingKey): void;
}
