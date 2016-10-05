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
        // TODO: Implement create() method.
    }

    /**
     * obtiene un o varios elementos
     * @param  BasicRequest $request
     * @return BasicRequest
     */
    public function Read(BasicRequest $request)
    {
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