<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 01/10/2016
 * Time: 09:26 AM
 */

namespace App\Dao;

use App\Beans\BasicRequest;
use App\Models\Albume;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;

class AlbumeDaoImpl implements AlbumeDao
{

    /**
     * Crea un o varios nuevos elementos
     * @param  BasicRequest $request
     * @return boolean
     */
    public function create(BasicRequest $request)
    {
        $params = $request->getData();
        try {
            $albume = new Albume;
            $albume->title = $params['albumeTitle'];
            $albume->genre = $params['albumGenre'];
            $albume->description = $params['description'];
            $albume->folder = $params['folder'];
            $albume->picture = $params['picture'];
            $albume->save();

            return true;

        } catch (\Exception $e) {
            LOG::error($e->getMessage());
            throw new Exception($e->getMessage());
        }

    }

    /**
     * obtiene un o varios elementos
     * @param  BasicRequest $request
     * @return BasicRequest
     */
    public function Read(BasicRequest $request)
    {
        $rows = $request->getRows();
        return ['albumes' => DB::table('albumes')->paginate($rows)];
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
        
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAlbumeById($id)
    {
        LOG::info(AlbumeDaoImpl::class);
        try {
            return Albume::where('id', $id)->get();
        } catch (\Exception $e) {
            LOG::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}