<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 11/10/2016
 * Time: 06:54 AM
 */

namespace App\Dao;


use App\Beans\BasicRequest;
use App\Exceptions\DAOException;
use App\Library\Constantes;
use App\Models\Favorite;
use App\Models\Listened;
use App\Models\RatingTrack;
use App\Models\Track;
use Mockery\CountValidator\Exception;
use Log;
use DB;

class TrackDaoImpl implements TrackDao
{
    /**
     * Cantidad de registros por pagina
     * @var
     */
    private $ROWS_BY_PAGE;

    /**
     * @var string
     */
    private $FIELDS =
        "
        t.*,
        rt.rate,
        lt.listeneds,
        au.firstName as author_firstName, 
        au.lastName as author_lastName, 
        al.title as albume_title,
        al.folder as albume_folder,
        al.genre as albume_genre,
        al.picture as albume_picture,
        po.posted 
        ";
    /**
     * @var string
     */
    private $FAVORITE_FIELD_VISIT = ",4 as favorite";

    /**
     * @var string
     */
    private $FAVORITE_FIELD_USER = ",f.status_id as favorite";

    /**
     * @var string
     */
    private $TABLE_RATE = "(Select track_id, sum(rate)/count(rate) as rate from rating_track group by track_id) as rt";

    /**
     * @var string
     */
    private $TABLE_LISTENEDS = "(select track_id, count(track_id) as listeneds from listeneds group by track_id) as lt";

    /**
     * @var string
     */
    private $TABLE_POSTEDS = "(select track_id, count(track_id) as posted from post_track where status_id = %d group by track_id) as po";

    /**
     * IdUser usado para obtener los registros
     * de las actividades del  usuario.
     * @var
     */
    private $idUser;

    /**
     * TrackDaoImpl constructor.
     */
    function __construct()
    {
        $this->ROWS_BY_PAGE = env('APP_AUDIO_ROWS_BY_PAGE');
        $this->TABLE_POSTEDS = sprintf($this->TABLE_POSTEDS, Constantes::STATUS_ACTIVE);
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

    /**
     * Obtiene todos los audios para los usuarios logeados
     * @param BasicRequest $request
     * @return mixed
     */
    public function getAllAudioForUser(BasicRequest $request)
    {
        Log::info('Inicia getAllAudioForUser desde' . AudioDao::class);
        $this->idUser = $request->getData()['idUser'];
        try {
            return DB::table('tracks as t')
                ->select(DB::raw($this->FIELDS . $this->FAVORITE_FIELD_USER))
                ->join('authors as au', 't.author_id', '=', 'au.id')
                ->join('albumes as al', 't.albume_id', '=', 'al.id')
                ->leftjoin(DB::raw($this->TABLE_RATE), function ($join) {
                    $join->on('t.id', '=', 'rt.track_id');
                })
                ->leftjoin(DB::raw($this->TABLE_LISTENEDS), function ($join) {
                    $join->on('t.id', '=', 'lt.track_id');
                })
                ->leftjoin(DB::raw($this->TABLE_POSTEDS), function ($join) {
                    $join->on('t.id', '=', 'po.track_id');
                })
                ->leftjoin('favorites as f', function ($join) {
                    $join->on('t.id', '=', 'f.track_id');
                    $join->on('f.user_id', '=', DB::raw($this->idUser));
                })
                ->where('t.status_id', '=', 1)//Cambiar 1 por 3
                ->whereRaw('(t.id = ' . $request->getId() . ' or 0=' . $request->getId() . ')')
                ->paginate($this->ROWS_BY_PAGE);

        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            throw new DAOException($ex->getMessage());
        }
    }

    /**
     * Obtiene todos los audios para los visitantes
     * @param BasicRequest $request
     * @return mixed
     */
    public function getAllAudioForVisitants(BasicRequest $request)
    {
        Log::info('Inicia getAllAudioForVisitants desde' . AudioDao::class);
        try {
            return DB::table('tracks as t')
                ->select(DB::raw($this->FIELDS . $this->FAVORITE_FIELD_VISIT))
                ->join('authors as au', 't.author_id', '=', 'au.id')
                ->join('albumes as al', 't.albume_id', '=', 'al.id')
                ->leftjoin(DB::raw($this->TABLE_RATE), function ($join) {
                    $join->on('t.id', '=', 'rt.track_id');
                })
                ->leftjoin(DB::raw($this->TABLE_LISTENEDS), function ($join) {
                    $join->on('t.id', '=', 'lt.track_id');
                })
                ->leftjoin(DB::raw($this->TABLE_POSTEDS), function ($join) {
                    $join->on('t.id', '=', 'po.track_id');
                })
                ->where('t.status_id', '=', Constantes::USER_CREATED)//Cambiar 1 por 3
                ->whereRaw('(t.id = ' . $request->getId() . ' or 0=' . $request->getId() . ')')
                ->paginate($this->ROWS_BY_PAGE);

        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            throw new DAOException($ex->getMessage());
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
        Log::info('Inicia toggleFavoriteTrack desde: ' . TrackDaoImpl::class);
        try {
            return Favorite::where('track_id', $request->getId())
                ->where('user_id', $request->getData()['idUser'])
                ->update(['status_id' => $request->getData()['idStatus']]);
        } catch (\Exception $ex) {
            throw new DAOException($ex);
        }
    }

    /**
     * Busca si un audio es favorito para un usuario
     * @param BasicRequest $request
     * @return mixed
     */
    public function isFavorite(BasicRequest $request)
    {
        Log::info('Inicia isFavorite desde: ' . TrackDaoImpl::class);
        try {
            return Favorite::where('track_id', $request->getId())
                ->where('user_id', $request->getData()['idUser'])
                ->get();
        } catch (\Exception $ex) {
            throw new DAOException($ex);
        }
    }

    /**
     * Asigna por primera vez favorito.
     * @param BasicRequest $request
     * @return mixed
     */
    public function setFavorit(BasicRequest $request)
    {
        Log::info('Inicia setFavorit desde: ' . TrackDaoImpl::class);
        try {
            $favorito = new Favorite;
            $favorito->track_id = $request->getId();
            $favorito->user_id = $request->getData()['idUser'];
            $favorito->status_id = Constantes::STATUS_ACTIVE;
            $favorito->save();
        } catch (\Exception $ex) {
            throw new DAOException($ex);
        }
    }

    /**
     * Verifica si el solicitante ya calificado
     * el track
     * @return mixed
     */
    public function isRateBefore(BasicRequest $request)
    {
        Log::info('Inicia isRateBefore desde: ' . TrackDaoImpl::class);
        try {
            if ($request->getData()['idUser'] > 0) {
                return RatingTrack::where('user_id', $request->getData()['idUser'])
                    ->where('track_id', $request->getId())
                    ->get();
            } else {
                return RatingTrack::where('visitor_id', $request->getData()['idVisitor'])
                    ->where('track_id', $request->getId())
                    ->get();
            }
        } catch (\Exception $ex) {
            throw new DAOException($ex);
        }
    }

    /**
     * Califica un track del 1 al 5
     * @param BasicRequest $request
     * @return mixed
     */
    public function setRate(BasicRequest $request)
    {
        Log::info('Inicia setRate desde: ' . TrackDaoImpl::class);
        try {
            $ratingTrack = new RatingTrack;
            $ratingTrack->track_id = $request->getId();
            $ratingTrack->user_id = $request->getData()['idUser'];
            $ratingTrack->visitor_id = $request->getData()['idVisitor'];
            $ratingTrack->rate = $request->getData()['rate'];
            return $ratingTrack->save();
        } catch (\Exception $ex) {
            throw new DAOException($ex);
        }
    }

    /**
     * Modifica un calificaion
     * @param BasicRequest $request
     * @return mixed
     */
    public function modifyRate(BasicRequest $request)
    {
        Log::info('Inicia modifyRate desde: ' . TrackDaoImpl::class);
        try {
            if ($request->getData()['idUser'] > 0) {
                return RatingTrack::where('user_id', '=', $request->getData()['idUser'])
                    ->where('track_id', '=', $request->getId())
                    ->update(['rate' => $request->getData()['rate']]);
            } else {
                return RatingTrack::where('visitor_id', '=', $request->getData()['idVisitor'])
                    ->where('track_id', '=', $request->getId())
                    ->update(['rate' => $request->getData()['rate']]);
            }
        } catch (\Exception $ex) {
            throw new DAOException($ex);
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
        Log::info('Inicia setListened desde: ' . TrackDaoImpl::class);
        try {
            $listened = new Listened;
            $listened->track_id = $request->getId();
            $listened->user_id = $request->getData()['idUser'];
            $listened->visitor_id = $request->getData()['idVisitor'];
            return $listened->save();

        } catch (\Exception $ex) {
            throw new DAOException($ex);
        }
    }
}