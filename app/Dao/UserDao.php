<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 01/10/2016
 * Time: 10:43 AM
 */

namespace App\Dao;
use App\Contracts\CRUD;
interface UserDao extends CRUD
{
    /**
     * Da de baja un usuario del sistema.
     * @param $id
     * @return mixed
     */
    public function setBajaUsuario($id);

    /**
     * Activa un usuario del sistema.
     * @param $id
     * @return mixed
     */
    public function setAltaUsuario($id);

    /**
     * @param $id
     * @return mixed
     */
    public function getUserById($id);
    
}