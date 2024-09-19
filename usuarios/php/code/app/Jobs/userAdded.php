<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Queue;

class userAdded implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo 'event userAdded [Usuarios] Send routingKey: user.added';
        print_r($this->user);

        Queue::connection('rabbitmq')->pushRaw(json_encode($this->user), '', [
            'exchange' => 'usuariosExchange',
            'routing_key' => 'user.added'
        ]);

        // $userData = [
        //     'id' => $user->id,
        //     'name' => $user->name,
        //     'event' => 'user.added',
        // ];

        // // Enviar el trabajo a la cola
        // Queue::push(new ProcessUserAdded($userData));
    }
}
