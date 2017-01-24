<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 11/10/2016
 * Time: 06:53 AM
 */

namespace App\Dao;


use App\Beans\BasicRequest;
use App\Contracts\CRUD;

interface TrackDao extends CRUD
{
    public function deleteTracks($ids);
    public function getTrackByDelete($id);
    public function deleteTrackById($id);

    /**
     * Obtiene todos los audios para los usuarios logeados
     * @param BasicRequest $request
     * @return mixed
     */
    public function getAllAudioForUser(BasicRequest $request);

    /**
     * Obtiene todos los audios para los visitantes
     * @param BasicRequest $request
     * @return mixed
     */
    public function getAllAudioForVisitants(BasicRequest $request);

    /**
     * Activa o desactiva el estado favorito
     * de un track
     * @param BasicRequest $request
     * @return mixed
     */
    public function toggleFavoriteTrack(BasicRequest $request);

    /**
     * Busca si un audio es favorito para un usuario
     * @param BasicRequest $request
     * @return mixed
     */
    public function isFavorite(BasicRequest $request);

    /**
     * Asigna por primera vez favorito.
     * @param BasicRequest $request
     * @return mixed
     */
    public function setFavorit(BasicRequest $request);

    /**
     * Califica un track del 1 al 5
     * @param BasicRequest $request
     * @return mixed
     */
    public function setRate(BasicRequest $request);

    /**
     * Verifica si el solicitante ya calificado
     * el track
     * @return mixed
     */
    public function isRateBefore(BasicRequest $request);

    /**
     * Modifica un calificaion
     * @param BasicRequest $request
     * @return mixed
     */
    public function modifyRate(BasicRequest $request);
}