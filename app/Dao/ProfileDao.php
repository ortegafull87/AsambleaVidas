<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 20/03/2017
 * Time: 07:17 AM
 */

namespace App\Dao;


use App\Beans\BasicRequest;

interface ProfileDao
{
    /**
     * Obtiene el perfil de usurio logueado.
     * @param BasicRequest $request
     * @return mixed
     */
    public function getProfile(BasicRequest $request);

    /**
     * Obtiene las notas
     * @param BasicRequest $request
     * @return mixed
     */
    public function getNotes(BasicRequest $request);

    /**
     * Obtiene la cantidad de material
     * agregado a la lista de favoritos
     * @param BasicRequest $request
     * @return mixed
     */
    public function countFavorite(BasicRequest $request);

    /**
     * Obtiene la cantidad de material aportado
     * por un usuario.
     * @param BasicRequest $request
     * @return mixed
     */
    public function countContributions(BasicRequest $request);

    /**
     * Obtiene la cantidad de commentarios
     * por usuario.
     * @param BasicRequest $request
     * @return mixed
     */
    public function countComments(BasicRequest $request);

    /**
     * Actualiza los datos de un perfil
     * ecepto la contraseña y la imagen
     * @param BasicRequest $request
     * @return mixed
     */
    public function updateProfile(BasicRequest $request);
    
}