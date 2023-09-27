<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AfterUserRegistered
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */

    public function handle(Registered $event)
    {
        // Получите пользователя, который был зарегистрирован
        $user = $event->user;

        // Установите данные в сессию
        Session::put('key', 'value');

        // Перенаправление пользователя после успешной регистрации
        return redirect('/dashboard');
    }
}
