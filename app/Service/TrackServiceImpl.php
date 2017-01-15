<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 11/10/2016
 * Time: 06:56 AM
 */

namespace App\Service;

use App\Beans\HttpResponse;
use App\Beans\ServiceResponse;
use App\Dao\TrackDaoImpl as TrackDao;
use App\Beans\BasicRequest;
use App\Dao\AlbumeDaoImpl as AlbumeDao;
use App\Exceptions\DAOException;
use App\Library\Constantes;
use DB;
use App\Exceptions\ServiceException;
use Log;
use Mockery\CountValidator\Exception;


class TrackServiceImpl implements TrackService
{
    protected $trackDao;
    protected $albumeDao;
    private $URL_BASE_AUDIOFILES;

    public function __construct(TrackDao $trackDao, AlbumeDao $albumeDao)
    {
        $this->trackDao = $trackDao;
        $this->albumeDao = $albumeDao;
        $this->URL_BASE_AUDIOFILES = env('URL_BASE_AUDIOFILES') . '/';
    }

    /**
     * Crea un o varios nuevos elementos
     * @param  BasicRequest $request
     * @return boolean
     */
    public function create(BasicRequest $request)
    {
        // TODO: Implement create() method.
    }

    /**
     * obtiene un o varios elementos
     * @param  BasicRequest $request
     * @return BasicRequest
     */
    public function Read(BasicRequest $request)
    {
        // TODO: Implement Read() method.
    }

    /**
     * Actualiza uno o varios elementos
     * @param  BasicRequest $request
     * @return boolean
     */
    public function update(BasicRequest $request)
    {
        LOG::info(TrackServiceImpl::class);
        $URL_BASE_AUDIOFILES = env('URL_BASE_AUDIOFILES');
        $serviceResponse = new ServiceResponse();
        try {

            DB::beginTransaction();

            $data = $request->getData();
            $httpRequest = $request->getRequest();
            $track = $this->trackDao->Read($request);
            $upDateTrack = Array();

            if ($httpRequest->hasFile('file')) {//Actualización con archivo
                LOG::info('Actualización con archivo');
                LOG::info('Contruyendo array de cambios');

                if ($track[0]->title != $data['title']) {
                    $upDateTrack = Array('title' => $data['title'], 'file' => $data['title'] . '.mp3');
                }
                if ($track[0]->idAuthor != $data['author_id']) {
                    $upDateTrack = Array('author_id' => $data['author_id']) + $upDateTrack;
                }
                if ($track[0]->idAlbume != $data['albume_id']) {
                    $upDateTrack = Array('albume_id' => $data['albume_id']) + $upDateTrack;
                }

                LOG::info('Actualizando archivo cargado');
                //Actualizamos el registro segun lo enviado.
                $daoBasicRequest = new BasicRequest();
                $daoBasicRequest->setId($request->getId());
                $daoBasicRequest->setData($upDateTrack);
                $this->trackDao->update($daoBasicRequest);

                //Verificamos si el archivo existe.
                $carpeta = $URL_BASE_AUDIOFILES . '/' . $track[0]->folder . '/';
                $file = $carpeta . $track[0]->file;
                LOG::info($file);
                if (is_file($file)) {
                    if (unlink($file)) {
                        if ($track[0]->idAlbume != $data['albume_id']) {// si la actualización implica un cambio de albume
                            $albume = $this->albumeDao->getAlbumeById($data['albume_id']);
                            $httpRequest->file('file')->move($URL_BASE_AUDIOFILES . '/' . $albume[0]->folder . '/', $data['title'] . '.mp3');
                        } else {
                            $httpRequest->file('file')->move($carpeta, $data['title'] . '.mp3');
                        }

                        $serviceResponse->setStatus(true);
                        $serviceResponse->setMessage('Pista actualizada');
                        DB::commit();
                        return $serviceResponse;
                    } else {
                        $serviceResponse->setStatus(false);
                        $serviceResponse->setMessage('Pista no actualizada, hubo un problema cargando el archivo');
                        DB::rollBack();
                        return $serviceResponse;
                    }

                } else {
                    $serviceResponse->setStatus(false);
                    $serviceResponse->setMessage('El archivo ' . $track[0]->file . 'no existe o ha sido borrado.');
                    DB::rollBack();
                    return $serviceResponse;
                }


            } else {//Actualización si archivo
                LOG::info('Actualización sin archivo');
                LOG::info('Construyendo array de cambios.');
                if ($track[0]->title != $data['title']) {
                    $upDateTrack = Array('title' => $data['title'], 'file' => $data['title'] . '.mp3');
                }
                if ($track[0]->idAuthor != $data['author_id']) {
                    $upDateTrack = Array('author_id' => $data['author_id']) + $upDateTrack;
                }
                if ($track[0]->idAlbume != $data['albume_id']) {
                    $upDateTrack = Array('albume_id' => $data['albume_id']) + $upDateTrack;
                }

                //Actualizamos el registro segun lo enviado.
                $daoBasicRequest = new BasicRequest();
                $daoBasicRequest->setId($request->getId());
                $daoBasicRequest->setData($upDateTrack);
                $this->trackDao->update($daoBasicRequest);

                //Si hay un cambio en el nombre de la pista
                if ($track[0]->title != $data['title']) {

                    $carpeta = $URL_BASE_AUDIOFILES . '/' . $track[0]->folder . '/';
                    LOG::info($carpeta . $track[0]->file);

                    //Verificamos si el archivo existe.
                    if (is_file($carpeta . $track[0]->file)) {

                        // Actualización del archivo
                        $renameFile = rename($carpeta . $track[0]->file, $carpeta . $data['title'] . '.mp3');

                        if ($renameFile) {
                            $serviceResponse->setStatus(true);
                            $serviceResponse->setMessage('Pista actualizada');
                            DB::commit();
                            return $serviceResponse;
                        } else {
                            $serviceResponse->setStatus(false);
                            $serviceResponse->setMessage('Pista no actualizada');
                            DB::rollBack();
                            return $serviceResponse;
                        }

                    } else {
                        $serviceResponse->setStatus(false);
                        $serviceResponse->setMessage('El archivo ' . $track[0]->file . 'no existe o ha sido borrado.');
                        DB::rollBack();
                        return $serviceResponse;
                    }

                } else {
                    DB::commit();
                    $serviceResponse->setStatus(true);
                    $serviceResponse->setMessage('Pista actualizada');
                    return $serviceResponse;
                }
            }

        } catch (\Exception $e) {
            DB::rollBack();
            LOG::error($e->getMessage());
            $serviceResponse->setStatus(false);
            $serviceResponse->setMessage($e->getMessage());
            return $serviceResponse;
        }
    }

    /**
     * Elimina uno o varios elementos
     * @param  BasicRequest $request
     * @return boolean
     */
    public function delete(BasicRequest $request)
    {
        LOG::info(TrackServiceImpl::class);
        $serviceResponse = new ServiceResponse();
        $array_deleted = array();
        try {
            DB::beginTransaction();
            //throw new \Exception("Proceso interrumpido");
            if ($request->getId() == -1) {// Se eliminan todas las pistas registradas.
                $allTracks = $this->trackDao->Read(new BasicRequest());
                foreach ($allTracks as $dataTrack) {
                    if ($this->URL_BASE_AUDIOFILES . $dataTrack->folder . '/' . $dataTrack->file) {
                        if ($this->trackDao->deleteTrackById($dataTrack->id)) {
                            $array_deleted[] = $dataTrack->id;
                        } else {
                            throw new Exception("La pista: " . $dataTrack->tracks . id . " no se eliminó");
                        }
                    }
                }

            } else {// se eliminan las pistas seleccionadas.
                foreach ($request->getData() as $idTrack) {
                    $dataTrack = $this->trackDao->getTrackByDelete($idTrack);
                    if ($this->trackDao->deleteTrackById($idTrack)) {
                        if (unlink($this->URL_BASE_AUDIOFILES . $dataTrack[0]->folder . '/' . $dataTrack[0]->file)) {
                            $array_deleted[] = $idTrack;
                        } else {
                            throw new Exception("La pista: " . $idTrack . " no se eliminó");
                        }
                    }
                }
            }

            $serviceResponse->getStatus(true);
            $serviceResponse->setMessage("Pista eliminada");
            $serviceResponse->setData($array_deleted);
            DB::commit();
            return $serviceResponse;

        } catch (\Exception $e) {
            LOG::error(TrackServiceImpl::class);
            LOG::error($e->getMessage());
            $serviceResponse->getStatus(false);
            $serviceResponse->setMessage($e->getMessage());
            DB::rollBack();
            return $serviceResponse;
        }
    }

    /**
     * Obtiene todos los audios para los usuarios logeados
     * @param BasicRequest $request
     * @return mixed
     */
    public function getAllAudioForUser(BasicRequest $request)
    {
        Log::info('Obteniendo todo los audios desde  getAllAudioForUser en: ' . TrackServiceImpl::class);
        try {
            return $this->trackDao->getAllAudioForUser($request);
        } catch (DAOException $dex) {
            Log::error($dex);
            throw DAOException($dex->getMessage());
        } catch (Exception $ex) {
            Log::error($ex);
            throw ServiceException($ex->getMessage());
        }
    }

    /**
     * Obtiene todos los audios para los visitantes
     * @param BasicRequest $request
     * @return mixed
     */
    public function getAllAudioForVisitants(BasicRequest $request)
    {
        Log::info('Obteniendo todo los audios desde getAllAudioForVisitants en: ' . TrackServiceImpl::class);
        try {
            return $this->trackDao->getAllAudioForVisitants($request);
        } catch (DAOException $dex) {
            Log::error($dex);
            throw DAOException($dex->getMessage());
        } catch (Exception $ex) {
            Log::error($ex);
            throw ServiceException($ex->getMessage());
        }
    }

    /**
     * Activa o desactiva el estado favorito
     * de un track
     * @param BasicRequest $request
     * @return mixed
     */
    public function toggleFavoriteTrack(BasicRequest $request)
    {
        Log::info('Inicia toggleFavoriteTrack desde: ' . TrackServiceImpl::class);
        try {
            $idUser = $request->getData()['idUser'];
            $isFavorite = $this->trackDao->isFavorite($request);
            if (count($isFavorite) > 0) {
                Log::info(count($isFavorite));
                if ($isFavorite[0]->status_id == Constantes::STATUS_INACTIVE) {
                    $request->setData(['idStatus' => Constantes::STATUS_ACTIVE, 'idUser' => $idUser]);
                    $this->trackDao->toggleFavoriteTrack($request);
                    return Constantes::STATUS_ACTIVE;
                } else {
                    $request->setData(['idStatus' => Constantes::STATUS_INACTIVE, 'idUser' => $idUser]);
                    $this->trackDao->toggleFavoriteTrack($request);
                    return Constantes::STATUS_INACTIVE;
                }
            } else {
                $request->setData(['idUser' => $idUser]);
                $this->trackDao->setFavorit($request);
                return Constantes::STATUS_ACTIVE;
            }
        } catch (DAOException $dao) {
            Log::error("Error desde DAO");
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            Log::error("Error desde Service");
            throw new ServiceException($ex);
        }
    }
}