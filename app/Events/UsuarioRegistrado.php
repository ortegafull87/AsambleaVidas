<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 28/11/2016
 * Time: 10:19 PM
 */

namespace App\Events;

use App\User;

class UsuarioRegistrado extends Event
{
    public $usuario;

    public function __construct(User $usuario)
    {
        $this->usuario = $usuario;
    }
}