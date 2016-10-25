<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 11/10/2016
 * Time: 06:56 AM
 */

namespace App\Service;

use App\Beans\ServiceResponse;
use App\Dao\TrackDaoImpl as TrackDao;
use App\Beans\BasicRequest;
use App\Dao\AlbumeDaoImpl as AlbumeDao;
use Illuminate\Support\Arr;
use DB;
use Log;
use Mockery\CountValidator\Exception;


class TrackServiceImpl implements AlbumeService
{
    protected $trackDao;
    protected $albumeDao;

    public function __construct(TrackDao $trackDao, AlbumeDao $albumeDao)
    {
        $this->trackDao = $trackDao;
        $this->albumeDao = $albumeDao;
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
                        }else{
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
                if ($track[0]->tile != $data['title']) {

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
        try {
            DB::beginTransaction();

            if ($request->getId() == -1) {
                $allTracks = Track::all();
                foreach ($allTracks as $row) {
                    if (unlink($row->file)) {
                        $row->delete();
                    }
                }

            } else {
                
                foreach ($request->getData() as $idTable) {
                    $track = Track::find($idTable);
                    if (unlink($track->file)) {
                        $track->delete();
                    }
                }
            }
            DB::commit();
            return 'OK';

        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }
}