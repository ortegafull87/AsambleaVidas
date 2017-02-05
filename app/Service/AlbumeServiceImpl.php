<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 01/10/2016
 * Time: 09:40 AM
 */

namespace App\Service;

use App\Beans\BasicRequest;
use App\Dao\AlbumeDaoImpl as AlbumeDao;
use App\Exceptions\DAOException;
use App\Exceptions\ServiceException;
use App\Library\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;
use App\Library\Util;
use App;

class AlbumeServiceImpl implements AlbumeService
{
    protected $albumeDao;

    /**
     * AlbumeServiceImpl constructor.
     * @param AlbumeDao $albumeDao
     */
    public function __construct(AlbumeDao $albumeDao)
    {
        $this->albumeDao = $albumeDao;
    }

    /**
     * Crea un o varios nuevos elementos
     * @param  BasicRequest $request
     * @return boolean
     */
    public function create(BasicRequest $request)
    {
        LOG::info('Preparing data to create new albume');

        try {
            $pahtAudioFiles = env('URL_BASE_AUDIOFILES');
            $albumeTitle = $request->getRequest()->input("title");
            $albumGenre = $request->getRequest()->input("genre");
            $description = $request->getRequest()->input("description");

            $folder = sha1($albumeTitle . '_' . $albumGenre);

            $file = $request->getRequest()->hasFile('picture');

            $pictureName = ($file) ? $albumeTitle . '.' . $request->getRequest()->file('picture')->getClientOriginalExtension() : '';

            $basicRequest = new BasicRequest();
            $basicRequest->setData(array
                (
                    'albumeTitle' => $albumeTitle,
                    'albumGenre' => $albumGenre,
                    'folder' => $folder,
                    'description' => $description,
                    'picture' => $pictureName,
                )
            );

            DB::beginTransaction();

            if ($this->albumeDao->create($basicRequest)) {
                if (!is_dir($pahtAudioFiles . '/' . $folder)) {
                    mkdir($pahtAudioFiles . '/' . $folder, 0777, true);
                    if ($file) {
                        $request->getRequest()->file('picture')->move('img/app/albumes/', $pictureName);
                    }
                    DB::commit();
                } else {
                    if ($file) {
                        $request->getRequest()->file('picture')->move('img/app/albumes/', $pictureName);
                    }
                    DB::commit();
                }
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        } catch (\Exception $e) {
            LOG::error($e->getMessage());
            DB::rollBack();
            throw new Exception(Message::SUCCESS_ALBUMES_UPDATED);
        }

    }

    /**
     * obtiene un o varios elementos
     * @param  BasicRequest $request
     * @return BasicRequest
     */
    public function Read(BasicRequest $request)
    {
        LOG::info(env('URL_BASE_AUDIOFILES'));
        return $this->albumeDao->Read($request);
    }

    /**
     * Actualiza uno o varios elementos
     * @param  BasicRequest $request
     * @return boolean
     */
    public function update(BasicRequest $request)
    {
        LOG::info('Preparando datos para actualizar albume desde: ' . AlbumeServiceImpl::class);
        try {
            $albumePahtStore = env('URL_BASE_ALBUMES');
            $albumeTitle = $request->getRequest()->input("title");
            $albumGenre = $request->getRequest()->input("genre");
            $description = $request->getRequest()->input("description");
            $file = $request->getRequest()->hasFile('picture');

            $pictureName = ($file)
                ? $albumeTitle . '.' . $request->getRequest()->file('picture')->getClientOriginalExtension()
                : '';

            //creamos el array de los nuevos datos
            $data = array
            (
                'title' => $albumeTitle,
                'genre' => $albumGenre,
                'description' => $description,
            );

            //Iniciamos la transacción.
            DB::beginTransaction();

            if ($file) {//Si se detecta una actualización de imagen

                Log::debug('Actualización con imagen');

                //Obtenemos los datos actuales del albume
                $albume = $this->albumeDao->getAlbumeById($request->getId());

                //Seteamos el nombre de la nueva imagen
                //$data[] = ['picture' => $pictureName];
                $data = Array('picture' => $pictureName) + $data;
                $request->setData($data);

                if (!empty($albume[0]->picture)) {//Si es un remplazo

                    Log::debug('Remplazo de imagen');
                    //Actualizamos los datos en BD
                    $isUpdated = $this->albumeDao->update($request);

                    //Borramos la imagen actual
                    unlink($albumePahtStore . $albume[0]->picture);

                } else {//Si no
                    //solo actualizamos las datos en DB
                    $isUpdated = $this->albumeDao->update($request);
                }

                // y copiamos la nueva imagen
                $request->getRequest()->file('picture')->move($albumePahtStore, $pictureName);

            } else {//Si no
                Log::debug('Actualización sin imagen');

                //Obtenemos los datos actuales del albume
                $albume = $this->albumeDao->getAlbumeById($request->getId());

                //verificamos si actualmente tiene una imagen
                if (!empty($albume[0]->picture)) {

                    Log::debug('Se detecta imagen existente');

                    //Se obtiene extención de la imagen actual
                    $extension = explode('.',$albume[0]->picture)[1];

                    $data = Array('picture' => $albumeTitle .'.'. $extension) + $data;

                    //Se actualizan los datos en DB
                    $request->setData($data);
                    $isUpdated = $this->albumeDao->update($request);

                    //Se actualiza el nombre de la imagen actual
                    rename($albumePahtStore . $albume[0]->picture, $albumePahtStore . $albumeTitle .'.'. $extension);

                }else{

                    //Solo se actualizan los datos en DB
                    $request->setData($data);
                    $isUpdated = $this->albumeDao->update($request);
                }

            }

            DB::commit();
            return $isUpdated;
        } catch (DAOException $ex) {
            Log::error($ex);
            DB::rollBack();
        } catch (\Exception $ex) {
            DB::rollBack();
            throw  new ServiceException($ex);
        }
    }

    /**
     * Elimina uno o varios elementos
     * @param  BasicRequest $request
     * @return boolean
     */
    public function delete(BasicRequest $request)
    {
        // TODO: Implement delete() method.
    }
}