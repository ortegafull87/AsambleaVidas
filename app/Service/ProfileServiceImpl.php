<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 20/03/2017
 * Time: 07:16 AM
 */

namespace App\Service;

use App\Beans\BasicRequest;
use App\Dao\ProfileDaoImpl as ProfileDao;
use App\Exceptions\DAOException;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Log;

class ProfileServiceImpl implements ProfileService
{
    /**
     * @var ProfileDao
     */
    protected $profileDao;

    /**
     * ProfileServiceImpl constructor.
     */
    public function __construct(ProfileDao $profileDao)
    {
        $this->profileDao = $profileDao;
    }

    /**
     * Obtiene el perfil de usurio logueado.
     * @param BasicRequest $request
     * @return mixed
     */
    public function getProfile(BasicRequest $request)
    {
        Log::debug('Iniciando getProfile desde: ' . ProfileServiceImpl::class);
        try {
            return $this->profileDao->getProfile($request);
        } catch (DAOException $e) {
            Log::error($e);
            throw new ServiceException($e->getMessage());
        } catch (\Exception $e) {
            throw new ServiceException($e);
        }
    }

    /**
     * Obtiene las cantidades de comentarios, favoritos, y aportes.
     *
     * @param BasicRequest $request
     * @return mixed
     */
    public function getScores(BasicRequest $request)
    {
        Log::debug('Iniciando getScores desde: ' . ProfileServiceImpl::class);
        try {
            $favorites = $this->profileDao->countFavorite($request);
            $comments = $this->profileDao->countComments($request);
            $contributions = $this->profileDao->countContributions($request);

            return [
                'favorites' => $favorites,
                'comments' => $comments,
                'contributions' => $contributions
            ];

        } catch (DAOException $e) {
            Log::error($e);
            throw new ServiceException($e->getMessage());
        } catch (\Exception $e) {
            throw new ServiceException($e->getMessage(), $e);
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
        Log::debug('Iniciando updateProfile desde: ' . ProfileServiceImpl::class);
        try {
            return $this->profileDao->updateProfile($request);
        } catch (DAOException $e) {
            Log::error($e);
            throw new ServiceException($e->getMessage());
        } catch (\Exception $e) {
            throw new ServiceException($e->getMessage(), $e);
        }
    }

    /**
     * Asigna un avatar como imagen de perfil
     * @param BasicRequest $request
     * @return mixed
     */
    public function setAvatarAsProfileImage(BasicRequest $request)
    {
        Log::debug('Iniciando setAvatarAsProfileImage desde: ' . ProfileServiceImpl::class);
        try {
            return $this->profileDao->updateProfile($request);
        } catch (DAOException $e) {
            Log::error($e);
            throw new ServiceException($e->getMessage());
        } catch (\Exception $e) {
            throw new ServiceException($e->getMessage(), $e);
        }
    }

    /**
     * Asigna una imagen desde una pc como imagen de perfil
     * @param BasicRequest $request
     * @return mixed
     */
    public function setFileBrowsAsProfileImage(BasicRequest $request)
    {
        Log::debug('Iniciando setFileBrowsAsProfileImage desde: ' . ProfileServiceImpl::class);
        try {
            $imageBrows = $request->getRequest()->hasFile('ImageBrows');
            Log::info("::::");
            Log::info($imageBrows);
            $path = env('URL_BASE_IMGS') . 'users/';
            $extension = $request->getRequest()->file('ImageBrows')->getClientOriginalExtension();
            $isCopy = $request
                ->getRequest()
                ->file('ImageBrows')
                ->move($path, env('BASE_NAME_IMG_PROFILE') . $request->getId() . '.' . $extension);
            if($isCopy){
             return   $path . env('BASE_NAME_IMG_PROFILE') . $request->getId() . '.' . $extension;
            }
        } catch (DAOException $e) {
            Log::error($e);
            throw new ServiceException($e->getMessage());
        } catch (\Exception $e) {
            throw new ServiceException($e->getMessage(), $e);
        }
    }
}