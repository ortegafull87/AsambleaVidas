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
use App\Library\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;
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

            $basicRequest = new BasicRequest();
            $basicRequest->setData(array
                (
                    'albumeTitle' => $albumeTitle,
                    'albumGenre' => $albumGenre,
                    'folder' => $folder,
                    'description' => $description
                )
            );

            DB::beginTransaction();

            if ($this->albumeDao->create($basicRequest)) {
                if (!is_dir($pahtAudioFiles. '/' . $folder)) {
                    mkdir($pahtAudioFiles. '/' . $folder, 0777, true);
                    DB::commit();
                } else {
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
        // TODO: Implement update() method.
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