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

    /**
     * Modifica el comentario de un post
     * @param BasicRequest $request
     * @return mixed
     */
    public function updatePostTrack(BasicRequest $request);

    /**
     * Obtiene una lista de tracks por estado
     * @param BasicRequest $request
     * @return mixed
     */
    public function getListTracksByState(BasicRequest $request);
    
    /**
     * Cabia de estado un track
     * @param BasicRequest $request
     * @return mixed
     */
    public function updateStatusTrack(BasicRequest $request);

    /**
     * Obtiene los datos de un track para su respectiva
     * actualizacion y revision.
     * @param BasicRequest $request
     * @return mixed
     */
    public function getTrackForReview(BasicRequest $request);

    /**
     * Actualiza la información de un track
     * como titulo, skect, description y lo pones
     * en estatus para revisión.
     * @param BasicRequest $request
     * @return mixed
     */
    public function updateTrackInReview(BasicRequest $request);

    /**
     * Autoriza un track para su publicacion definitiva en al app
     * @param BasicRequest $request
     * @return mixed
     */
    public function autorizeTrackInReview(BasicRequest $request);

    /**
     * Funcion inteligente para buscar track
     * por las siguientes concidencias:
     * Titulo, Autor, Fecha, Albume, Genero
     * @param BasicRequest $request
     * @return mixed
     */
    public function findTracks(BasicRequest $request);

    /**
     * Funcion que ontiene información de un track para
     * la revista.
     * @param BasicRequest $request
     * @return mixed
     */
    public function getTrackById(BasicRequest $request);
}