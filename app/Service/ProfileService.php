<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 20/03/2017
 * Time: 07:15 AM
 */

namespace App\Service;


use App\Beans\BasicRequest;

interface ProfileService
{
    /**
     * Obtiene el perfil de usurio logueado.
     * @param BasicRequest $request
     * @return mixed
     */
    public function getProfile(BasicRequest $request);

    /**
     * Obtiene las cantidades de comentarios, favoritos, y aportes.
     * 
     * @param BasicRequest $request
     * @return mixed
     */
    public function getScores(BasicRequest $request);

    /**
     * Obtiene las notas
     * @param BasicRequest $request
     * @return mixed
     */
    public function getNotes(BasicRequest $request);

    /**
     * Actualiza los datos de un perfil
     * ecepto la contraseña y la imagen
     * @param BasicRequest $request
     * @return mixed
     */
    public function updateProfile(BasicRequest $request);

    /**
     * Asigna un avatar como imagen de perfil
     * @param BasicRequest $request
     * @return mixed
     */
    public function setAvatarAsProfileImage(BasicRequest $request);

    /**
     * Asigna una imagen desde una pc como imagen de perfil
     * @param BasicRequest $request
     * @return mixed
     */
    public function setFileBrowsAsProfileImage(BasicRequest $request);

    /**
     * @param BasicRequest $request
     * @return mixed
     */
    public function cancelSetFileBrowsAsProfileImage(BasicRequest $request);

    /**
     * @param BasicRequest $request
     * @return mixed
     */
    public function ConfirmSetFileBrowsAsProfileImage(BasicRequest $request);

    /**
     * Actualiza el password de un usuario
     * @param BasicRequest $request
     * @return mixed
     */
    public function updatePassword(BasicRequest $request);
}