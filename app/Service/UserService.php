<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 01/10/2016
 * Time: 10:48 AM
 */

namespace App\Service;
use App\Contracts\CRUD;
interface UserService extends CRUD

{
    /**
     * Funcion para confirmar una nueva cuenta
     * @param $id
     * @param $token
     * @return mixed
     */
    public function confirm($id, $token);
}