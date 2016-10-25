<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 01/10/2016
 * Time: 09:28 AM
 */

namespace App\Dao;

use App\Contracts\CRUD;

interface AlbumeDao extends CRUD
{
    public function getAlbumeById($id);
}