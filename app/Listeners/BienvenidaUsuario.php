<?php

/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 28/11/2016
 * Time: 10:21 PM
 */
namespace App\Listeners;

use App\Events\UsuarioRegistrado;
use App\User;
use Illuminate\Support\Facades\Mail;
use Log;
class BienvenidaUsuario
{
    public function __construct()
    {

    }

    public function handle(UsuarioRegistrado $event)
    {
        // Aqui podemos acceder al usuario mediante $event->usuario;
        // Creamos la lógica para enviar un mensaje de bienvenida
        LOG::info("Usuario creado");
        LOG::info($event->usuario->name);


        Mail::raw('Message text', function($message) {
            $message->from('info@vivelatorah.org', 'Confirma tu cuenta');
            $message->to('ortegafull87@gmail.com')->cc('ortegafull87@outlook.es');
        });
    }
}