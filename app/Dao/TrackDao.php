<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 11/10/2016
 * Time: 06:53 AM
 */

namespace App\Dao;


use App\Contracts\CRUD;

interface TrackDao extends CRUD
{
    public function deleteTracks($ids);
    public function getTrackByDelete($id);
    public function deleteTrackById($id);
}