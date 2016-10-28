<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 11/10/2016
 * Time: 06:54 AM
 */

namespace App\Dao;


use App\Beans\BasicRequest;
use App\Models\Track;
use Mockery\CountValidator\Exception;
use Log;
use DB;

class TrackDaoImpl implements TrackDao
{

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
        LOG::info(TrackDaoImpl::class);

        try {

            $tracks = DB::table('tracks')
                ->join('authors', 'tracks.author_id', '=', 'authors.id')
                ->join('albumes', 'tracks.albume_id', '=', 'albumes.id')
                ->select(
                    'tracks.id',
                    'tracks.title',
                    'tracks.duration',
                    'tracks.created_at',
                    'tracks.updated_at',
                    'tracks.file',
                    'authors.id as idAuthor',
                    'authors.firstName',
                    'authors.lastName',
                    'albumes.id as idAlbume',
                    'albumes.title as titleAlbume',
                    'albumes.folder');
            if ($request->getId() > 0) {
                $tracks->where('tracks.id', '=', $request->getId());
            }
            if ($request->getPage() > 0) {
                return $tracks->paginate($request->getPage());
            } else {
                return $tracks->get();
            }

        } catch (\Exception $e) {
            LOG::error($e->getMessage());
            throw new Exception($e);
        }

    }

    /**
     * Actualiza uno o varios elementos
     * @param  BasicRequest $request
     * @return boolean
     */
    public function update(BasicRequest $request)
    {
        LOG::info(TrackDaoImpl::class);
        try {
            Track::where('id', $request->getId())->update($request->getData());
        } catch (\Exception $e) {
            LOG::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Elimina uno o varios elementos
     * @param  BasicRequest $request
     * @return boolean
     */
    public function delete(BasicRequest $request)
    {
        LOG::info(TrackDaoImpl::class);
        try {
            return Track::where('id', $request->getId())->delete();
        } catch (\Exception $e) {
            LOG::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function deleteTracks($ids)
    {
        LOG::info(TrackDaoImpl::class);
        try {
            return DB::table('tracks')->whereIn('id', $ids)->delete();
        } catch (\Exception $e) {
            LOG::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function getTrackByDelete($id)
    {
        LOG::info(TrackDaoImpl::class);
        LOG::info($id);
        try {
            return DB::table('tracks')
                ->join('authors', 'tracks.author_id', '=', 'authors.id')
                ->join('albumes', 'tracks.albume_id', '=', 'albumes.id')
                ->select(
                    'tracks.file',
                    'albumes.folder')
                ->where('tracks.id', $id)
                ->get();
        } catch (\Exception $e) {
            throw new Exception($e);
        }
    }

    public function deleteTrackById($id)
    {
        LOG::info(TrackDaoImpl::class);
        LOG::info('deleteTrackById');
        LOG::info($id);
        try {
            return Track::find($id)->delete();
        } catch (\Exception $e) {
            throw new Exception($e);
        }
    }
}