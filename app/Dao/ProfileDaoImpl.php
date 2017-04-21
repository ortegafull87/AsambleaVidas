<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 20/03/2017
 * Time: 07:17 AM
 */

namespace App\Dao;


use App\Beans\BasicRequest;
use App\Exceptions\DAOException;
use App\Models\Favorite;
use App\Models\Note;
use App\Models\PostTrack;
use App\User;
use Illuminate\Support\Facades\Log;

class ProfileDaoImpl implements ProfileDao
{

    /**
     * Obtiene el perfil de usurio logueado.
     * @param BasicRequest $request
     * @return mixed
     */
    public function getProfile(BasicRequest $request)
    {
        Log::debug('Inicia getProfile desde: ' . ProfileDaoImpl::class);
        try {
            return User::where('id', $request->getId())->get();
        } catch (\Exception $e) {
            throw new DAOException($e->getMessage(), $e);
        }
    }

    /**
     * Obtiene la cantidad de material
     * agregado a la lista de favoritos
     * @param BasicRequest $request
     * @return mixed
     */
    public function countFavorite(BasicRequest $request)
    {
        Log::debug('Inicia countFavorite desde: ' . ProfileDaoImpl::class);
        try {
            return Favorite::where('user_id', $request->getId())
                ->get()
                ->count();
        } catch (\Exception $e) {
            throw new DAOException($e->getMessage(), $e);
        }
    }

    /**
     * Obtiene la cantidad de material aportado
     * por un usuario.
     * @param BasicRequest $request
     * @return mixed
     */
    public function countContributions(BasicRequest $request)
    {
        Log::debug('Inicia countContributions desde: ' . ProfileDaoImpl::class);
        try {
            return 0;
        } catch (\Exception $e) {
            throw new DAOException($e->getMessage(), $e);
        }
    }

    /**
     * Obtiene la cantidad de commentarios
     * por usuario.
     * @param BasicRequest $request
     * @return mixed
     */
    public function countComments(BasicRequest $request)
    {
        Log::debug('Inicia countComments desde: ' . ProfileDaoImpl::class);
        try {
            return PostTrack::where('user_id', $request->getId())
                ->get()
                ->count();
        } catch (\Exception $e) {
            throw new DAOException($e->getMessage(), $e);
        }
    }

    /**
     * Actualiza los datos de un perfil
     * ecepto la contraseña y la imagen
     * @param BasicRequest $request
     * @return mixed
     */
    public function updateProfile(BasicRequest $request)
    {
        Log::debug('Inicia updateProfile desde: ' . ProfileDaoImpl::class);
        try {
            return User::where('id', $request->getId())
                ->update($request->getData());
        } catch (\Exception $e) {
            throw new DAOException($e->getMessage(), $e);
        }
    }

    /**
     * Obtiene las notas
     * @param BasicRequest $request
     * @return mixed
     */
    public function getNotes(BasicRequest $request)
    {
        Log::debug('Inicia getNotes desde: ' . ProfileDaoImpl::class);
        try {
            $rows = $request->getData()['rows'];
            if ($rows > 0) {
                return Note::where('id', $request->getId())->paginate($rows);
            } else {
                return Note::where('id', $request->getId())->get();
            }
        } catch (\Exception $e) {
            throw new DAOException($e->getMessage(), $e);
        }
    }
}