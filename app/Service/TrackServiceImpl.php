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
use App\Dao\TrackDaoImpl;
use App\Exceptions\DAOException;
use App\Library\Constantes;
use App\Library\SendMail;
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
        Log::debug(TrackServiceImpl::class);
        $URL_BASE_AUDIOFILES = env('URL_BASE_AUDIOFILES');
        $serviceResponse = new ServiceResponse();
        try {

            DB::beginTransaction();

            $data = $request->getData();
            $httpRequest = $request->getRequest();
            $track = $this->trackDao->Read($request);
            $upDateTrack = Array();

            if ($httpRequest->hasFile('file')) {//Actualización con archivo
                Log::debug('Actualización con archivo');
                Log::debug('Contruyendo array de cambios');

                if ($track[0]->title != $data['title']) {
                    $upDateTrack = Array('title' => $data['title'], 'file' => $data['title'] . '.mp3');
                }
                if ($track[0]->idAuthor != $data['author_id']) {
                    $upDateTrack = Array('author_id' => $data['author_id']) + $upDateTrack;
                }
                if ($track[0]->idAlbume != $data['albume_id']) {
                    $upDateTrack = Array('albume_id' => $data['albume_id']) + $upDateTrack;
                }
                if ($track[0]->sketch != $data['sketch']) {
                    $upDateTrack = Array('sketch' => $data['sketch']) + $upDateTrack;
                }
                if ($track[0]->remote_repository != $data['remote_repository']) {
                    $upDateTrack = Array('remote_repository' => $data['remote_repository']) + $upDateTrack;
                }

                Log::debug('Actualizando archivo cargado');
                //Actualizamos el registro segun lo enviado.
                $daoBasicRequest = new BasicRequest();
                $daoBasicRequest->setId($request->getId());
                $daoBasicRequest->setData($upDateTrack);
                $this->trackDao->update($daoBasicRequest);

                //Verificamos si el archivo existe.
                $carpeta = $URL_BASE_AUDIOFILES . '/' . $track[0]->folder . '/';
                $file = $carpeta . $track[0]->file;
                Log::debug($file);
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
                Log::debug('Actualización sin archivo');
                Log::debug('Construyendo array de cambios.');
                if ($track[0]->title != $data['title']) {
                    $upDateTrack = Array('title' => $data['title'], 'file' => $data['title'] . '.mp3');
                }
                if ($track[0]->idAuthor != $data['author_id']) {
                    $upDateTrack = Array('author_id' => $data['author_id']) + $upDateTrack;
                }
                if ($track[0]->idAlbume != $data['albume_id']) {
                    $upDateTrack = Array('albume_id' => $data['albume_id']) + $upDateTrack;
                }
                if ($track[0]->sketch != $data['sketch']) {
                    $upDateTrack = Array('sketch' => $data['sketch']) + $upDateTrack;
                }
                if ($track[0]->remote_repository != $data['remote_repository']) {
                    $upDateTrack = Array('remote_repository' => $data['remote_repository']) + $upDateTrack;
                }

                //Actualizamos el registro segun lo enviado.
                $daoBasicRequest = new BasicRequest();
                $daoBasicRequest->setId($request->getId());
                $daoBasicRequest->setData($upDateTrack);
                $this->trackDao->update($daoBasicRequest);

                //Si hay un cambio en el nombre de la pista
                if ($track[0]->title != $data['title']) {

                    $carpeta = $URL_BASE_AUDIOFILES . '/' . $track[0]->folder . '/';
                    Log::debug($carpeta . $track[0]->file);

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
        Log::debug(TrackServiceImpl::class);
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
        Log::debug('Obteniendo todo los audios desde  getAllAudioForUser en: ' . TrackServiceImpl::class);
        try {
            return $this->trackDao->getAllAudioForUser($request);
        } catch (DAOException $dex) {
            Log::error("Error desde: " . TrackDaoImpl::class);
            throw ServiceException($dex->getMessage());
        } catch (Exception $ex) {
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
        Log::debug('Obteniendo todo los audios desde getAllAudioForVisitants en: ' . TrackServiceImpl::class);
        try {
            return $this->trackDao->getAllAudioForVisitants($request);
        } catch (DAOException $dex) {
            Log::error("Error desde: " . TrackDaoImpl::class);
            throw ServiceException($dex->getMessage());
        } catch (Exception $ex) {
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
        Log::debug('Inicia toggleFavoriteTrack desde: ' . TrackServiceImpl::class);
        try {
            $idUser = $request->getData()['idUser'];
            $isFavorite = $this->trackDao->isFavorite($request);
            if (count($isFavorite) > 0) {
                Log::debug(count($isFavorite));
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
            Log::error("Error desde: " . TrackDaoImpl::class);
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * Califica un track del 1 al 5
     * @param BasicRequest $request
     * @return mixed
     */
    public function setRate(BasicRequest $request)
    {
        Log::debug('Inicia setRate desde: ' . TrackServiceImpl::class);
        try {
            if (count($this->trackDao->isRateBefore($request)) > 0) {
                return $this->trackDao->modifyRate($request);
            } else {
                return $this->trackDao->setRate($request);
            }
        } catch (DAOException $dao) {
            Log::error("Error desde: " . TrackDaoImpl::class);
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * Ingresa un registro en la tabal listenes
     * para contavilizar las reproducciones.
     * @param BasicRequest $request
     * @return mixed
     */
    public function setListened(BasicRequest $request)
    {
        Log::debug('Inicia setListened desde: ' . TrackServiceImpl::class);
        try {
            return $this->trackDao->setListened($request);
        } catch (DAOException $dao) {
            Log::error("Error desde: " . TrackDaoImpl::class);
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * Ontiene los comentarios de un track
     * @param BasicRequest $request
     * @return mixed
     */
    public function getPostsTrack(BasicRequest $request)
    {
        Log::debug('Inicia getPostsTrack desde: ' . TrackServiceImpl::class);
        try {
            return $this->trackDao->getPostsTrack($request);
        } catch (DAOException $dao) {
            Log::error("Error desde: " . TrackDaoImpl::class);
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * Obtiene el ultimo post insertado
     * @return mixed
     */
    public function getLastPostTrack($id)
    {
        Log::debug('Inicia getLastPostTrack desde: ' . TrackServiceImpl::class);
        try {
            return $this->trackDao->getLastPostTrack($id);
        } catch (DAOException $dao) {
            Log::error("Error desde: " . TrackDaoImpl::class);
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * Da de alta un nuevo comentario
     * @param BasicRequest $request
     * @return mixed
     */
    public function setPostTrack(BasicRequest $request)
    {
        Log::debug('Inicia setPostTrack desde: ' . TrackServiceImpl::class);
        try {
            return $this->trackDao->setPostTrack($request);
        } catch (DAOException $dao) {
            Log::error("Error desde: " . TrackDaoImpl::class);
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * Modifica el comentario de un post
     * @param BasicRequest $request
     * @return mixed
     */
    public function updatePostTrack(BasicRequest $request)
    {
        Log::debug('Inicia updatePostTrack desde: ' . TrackServiceImpl::class);
        try {
            return $this->trackDao->updatePostTrack($request);
        } catch (DAOException $dao) {
            Log::error("Error desde: " . TrackDaoImpl::class);
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * Obtiene el conteo de los diferentes estados de un track
     * dado un array de estados.
     * @param BasicRequest $request
     * @return mixed
     */
    public function getCountTracksFilters(Array $data)
    {
        Log::debug('Inicia getCountTracksFilters desde: ' . TrackServiceImpl::class);
        try {
            foreach ($data as $index => $filter) {
                Log::debug($filter['genre']);
                $data[$index]['count'] = $this->trackDao->getCountTracks($filter['id']);
            }
            return $data;
        } catch (DAOException $dao) {
            Log::error("Error desde: " . TrackDaoImpl::class);
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * Cabia de estado un track
     * @param BasicRequest $request
     * @return mixed
     */
    public function updateStatusTrack(BasicRequest $request)
    {
        Log::debug('Inicia updateStatusTrack desde: ' . TrackServiceImpl::class);
        try {
            $updated = $this->trackDao->updateStatusTrack($request);
            if ($updated) {
                if (Constantes::STATUS_VALID == $request->getData()['statusId']) {
                    SendMail::notificationReview(env('ID_USER_REVIEW'), ['status_id' => Constantes::STATUS_VALID]);
                } else if (Constantes::STATUS_AUDITED == $request->getData()['statusId']) {
                    SendMail::notificationReview(env('ID_USER_REVIEW'), ['status_id' => Constantes::STATUS_AUDITED]);
                }
            }
            return $updated;
        } catch (DAOException $dao) {
            Log::error("Error desde: " . TrackDaoImpl::class);
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * Actualiza la información de un track
     * como titulo, skect, description y lo pones
     * en estatus para revisión.
     * @param BasicRequest $request
     * @return mixed
     */
    public function updateTrackInReview(BasicRequest $request)
    {
        Log::debug('Inicia updateTrackInReview desde: ' . TrackServiceImpl::class);
        try {
            $updated = $this->trackDao->updateTrackInReview($request);
            if ($updated) {
                SendMail::notificationReview(env('ID_USER_REVIEW'), ['status_id' => Constantes::STATUS_VALID]);
            }
            return $updated;
        } catch (DAOException $dao) {
            Log::error("Error desde: " . TrackDaoImpl::class);
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * Autoriza un track para su publicacion definitiva en al app
     * @param BasicRequest $request
     * @return mixed
     */
    public function autorizeTrackInReview(BasicRequest $request)
    {
        Log::debug('Inicia autorizeTrackInReview desde: ' . TrackServiceImpl::class);
        try {
            return $this->trackDao->autorizeTrackInReview($request);
        } catch (DAOException $dao) {
            Log::error("Error desde: " . TrackDaoImpl::class);
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            throw new ServiceException($ex);
        }
    }


    /**
     * Obtiene una lista de tracks por estado
     * @param BasicRequest $request
     * @return mixed
     */
    public function getListTracksByState(BasicRequest $request)
    {
        Log::debug('Inicia getListTracksByState desde: ' . TrackServiceImpl::class);
        try {
            return $this->trackDao->getListTracksByState($request);
        } catch (DAOException $dao) {
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * Obtiene los datos de un track para su respectiva
     * actualizacion y revision.
     * @param BasicRequest $request
     * @return mixed
     */
    public function getTrackForReview(BasicRequest $request)
    {
        Log::debug('Inicia getTrackForReview desde: ' . TrackServiceImpl::class);
        try {
            return $this->trackDao->getTrackForReview($request);
        } catch (DAOException $dao) {
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * Funcion inteligente para buscar track
     * por las siguientes concidencias:
     * Titulo, Autor, Fecha, Albume, Genero
     * @param BasicRequest $request
     * @return mixed
     */
    public function findTracks(BasicRequest $request)
    {
        Log::debug('Inicia findTracks desde: ' . TrackServiceImpl::class);
        try {
            return $this->trackDao->findTracks($request);
        } catch (DAOException $dao) {
            Log::error("Error desde: " . TrackDaoImpl::class);
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * Funcion que ontiene información de un track para
     * la revista.
     * @param BasicRequest $request
     * @return mixed
     */
    public function getTrackById(BasicRequest $request)
    {
        Log::debug('Inicia getTrackById desde: ' . TrackServiceImpl::class);
        try {
            return $this->trackDao->getTrackById($request);
        } catch (DAOException $dao) {
            Log::error("Error desde: " . TrackDaoImpl::class);
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * Obtiene los audios favoritos para mostrarlos en
     * un dropdown en forma de lista
     * @param BasicRequest $request
     * @return mixed
     */
    public function getFavoriteTracks(BasicRequest $request)
    {
        Log::debug('Inicia getFavoriteTracks desde: ' . TrackServiceImpl::class);
        try {
            return $this->trackDao->getFavoriteTracks($request);
        } catch (DAOException $dao) {
            Log::error("Error desde: " . TrackDaoImpl::class);
            throw new ServiceException($dao);
        } catch (\Exception $ex) {
            throw new ServiceException($ex);
        }
    }
}