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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Library\Util;

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
            throw new ServiceException($e->getMessage());
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
            throw new ServiceException($e->getMessage());
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
            if ($this->profileDao->updateProfile($request)) {
                return true;
            } else {
                return 0;
            }
        } catch (DAOException $e) {
            Log::error($e);
            throw new ServiceException($e->getMessage());
        } catch (\Exception $e) {
            throw new ServiceException($e->getMessage());
        }
    }

    /**
     * Actualiza solo la imagen del perfil.
     * @param BasicRequest $request
     * @return int
     * @throws ServiceException
     */
    public function updateImageProfile(BasicRequest $request)
    {
        Log::debug('Iniciando updateProfile desde: ' . ProfileServiceImpl::class);
        try {
            if ($this->profileDao->updateProfile($request)) {
                return $request->getData()['image'];
            } else {
                return 0;
            }
        } catch (DAOException $e) {
            Log::error($e);
            throw new ServiceException($e->getMessage());
        } catch (\Exception $e) {
            throw new ServiceException($e->getMessage());
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
            throw new ServiceException($e->getMessage());
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
                ->move($path, 'temp-' . env('BASE_NAME_IMG_PROFILE') . $request->getId() . '.' . $extension);
            if ($isCopy) {
                return $path . 'temp-' . env('BASE_NAME_IMG_PROFILE') . $request->getId() . '.' . $extension;
            }
        } catch (DAOException $e) {
            Log::error($e);
            throw new ServiceException($e->getMessage());
        } catch (\Exception $e) {
            throw new ServiceException($e->getMessage());
        }
    }

    /**
     * @param BasicRequest $request
     * @return mixed
     */
    public function cancelSetFileBrowsAsProfileImage(BasicRequest $request)
    {
        // TODO: Implement cancelSetFileBrowsAsProfileImage() method.
    }

    /**
     * @param BasicRequest $request
     * @return mixed
     */
    public function ConfirmSetFileBrowsAsProfileImage(BasicRequest $request)
    {
        Log::debug('Iniciando ConfirmSetFileBrowsAsProfileImage desde: ' . ProfileServiceImpl::class);
        try {
            $patter = env('URL_BASE_IMGS') . 'users/temp*.*';
            $tempImage = $request->getData()['confirm_image'];
            $image = str_replace('temp-', '', $tempImage);
            Log::debug('image: ' . $image);
            $rename = rename(env('URL_BASE_IMGS') . $tempImage, env('URL_BASE_IMGS') . $image);
            if ($rename) {
                $request->setData(['image' => $image]);
                if ($this->profileDao->updateProfile($request)) {
                    Util::findAndSuprFiles($patter);
                    return env('URL_BASE_IMGS') . $image;
                }
            }
        } catch (DAOException $e) {
            Log::error($e);
            throw new ServiceException($e->getMessage());
        } catch (\Exception $e) {
            throw new ServiceException($e->getMessage(), $e);
        }
    }

    /**
     * Actualiza el password de un usuario
     * @param BasicRequest $request
     * @return mixed
     */
    public function updatePassword(BasicRequest $request)
    {
        Log::debug('Iniciando updatePassword desde: ' . ProfileServiceImpl::class);
        try {
            $user = $this->profileDao->getProfile($request);
            $current_pass = $request->getData()['current_password'];
            if (Hash::check($current_pass,$user[0]->password)) {
                $request->setData(
                    ['password' => Hash::make($request->getData()['new_password'])]
                );
                return $this->profileDao->updateProfile($request);
            } else {
                return false;
            }
        } catch (DAOException $e) {
            Log::error($e);
            throw new ServiceException($e->getMessage());
        } catch (\Exception $e) {
            throw new ServiceException($e->getMessage(), $e);
        }
    }

    /**
     * Obtiene las notas
     * @param BasicRequest $request
     * @return mixed
     */
    public function getNotes(BasicRequest $request)
    {
        Log::debug('Iniciando getNotes desde: ' . ProfileServiceImpl::class);
        try {
            return $this->profileDao->getNotes($request);
        } catch (DAOException $e) {
            Log::error($e);
            throw new ServiceException($e->getMessage());
        } catch (\Exception $e) {
            throw new ServiceException($e->getMessage(), $e);
        }
    }
}