<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 11/10/2016
 * Time: 06:55 AM
 */

namespace App\Service;


use App\Beans\BasicRequest;
use App\Contracts\CRUD;

interface TrackService extends CRUD
{
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
     * Califica un track del 1 al 5
     * @param BasicRequest $request
     * @return mixed
     */
    public function setRate(BasicRequest $request);

    /**
     * Ingresa un registro en la tabal listenes
     * para contavilizar las reproducciones.
     * @param BasicRequest $request
     * @return mixed
     */
    public function setListened(BasicRequest $request);

    /**
     * Ontiene los comentarios de un track
     * @param BasicRequest $request
     * @return mixed
     */
    public function getPostsTrack(BasicRequest $request);

    /**
     * Obtiene el ultimo post insertado
     * @return mixed
     */
    public function getLastPostTrack($id);
    
    /**
     * Da de alta un nuevo comentario
     * @param BasicRequest $request
     * @return mixed
     */
    public function setPostTrack(BasicRequest $request);
}