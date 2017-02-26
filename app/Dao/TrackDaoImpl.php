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
use App\Models\PostTrack;
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

    private $SELECT_TRACKS = null;

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
        Log::debug(TrackDaoImpl::class);

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
                    'tracks.sketch',
                    'tracks.remote_repository',
                    'authors.id as idAuthor',
                    'authors.firstName',
                    'authors.lastName',
                    'albumes.id as idAlbume',
                    'albumes.title as titleAlbume',
                    'albumes.folder',
                    'albumes.picture');
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
        Log::debug(TrackDaoImpl::class);
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
        Log::debug(TrackDaoImpl::class);
        try {
            return Track::where('id', $request->getId())->delete();
        } catch (\Exception $e) {
            LOG::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function deleteTracks($ids)
    {
        Log::debug(TrackDaoImpl::class);
        try {
            return DB::table('tracks')->whereIn('id', $ids)->delete();
        } catch (\Exception $e) {
            LOG::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function getTrackByDelete($id)
    {
        Log::debug(TrackDaoImpl::class);
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
        Log::debug(TrackDaoImpl::class);
        Log::debug('deleteTrackById');
        Log::debug($id);
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
        Log::debug('Inicia getAllAudioForUser desde' . AudioDao::class);
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
        Log::debug('Inicia getAllAudioForVisitants desde' . AudioDao::class);
        try {
            Log::debug("Rows by page");
            Log::debug($this->ROWS_BY_PAGE);
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
        Log::debug('Inicia toggleFavoriteTrack desde: ' . TrackDaoImpl::class);
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
        Log::debug('Inicia isFavorite desde: ' . TrackDaoImpl::class);
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
        Log::debug('Inicia setFavorit desde: ' . TrackDaoImpl::class);
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
        Log::debug('Inicia isRateBefore desde: ' . TrackDaoImpl::class);
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
        Log::debug('Inicia setRate desde: ' . TrackDaoImpl::class);
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
        Log::debug('Inicia modifyRate desde: ' . TrackDaoImpl::class);
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
        Log::debug('Inicia setListened desde: ' . TrackDaoImpl::class);
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

    /**
     * Ontiene los comentarios de un track
     * @param BasicRequest $request
     * @return mixed
     */
    public function getPostsTrack(BasicRequest $request)
    {
        Log::debug('Inicia getPostsTrack desde: ' . TrackDaoImpl::class);
        try {
            return DB::table('post_track')
                ->join('users', 'post_track.user_id', '=', 'users.id')
                ->select('post_track.*', 'users.name')
                ->where('post_track.track_id', '=', $request->getId())
                ->where('post_track.status_id', '=', Constantes::STATUS_ACTIVE)
                ->orderBy('post_track.created_at', 'DESC')
                ->paginate(10);

        } catch (\Exception $ex) {
            throw new DAOException($ex);
        }
    }

    /**
     * Obtiene el ultimo post insertado
     * @return mixed
     */
    public function getLastPostTrack($id)
    {
        Log::debug('Inicia getLastPostTrack desde: ' . TrackDaoImpl::class);
        try {
            return DB::table('post_track')
                ->join('users', 'post_track.user_id', '=', 'users.id')
                ->select('post_track.*', 'users.name')
                ->where('post_track.id', '=', $id)
                ->get();

        } catch (\Exception $ex) {
            throw new DAOException($ex);
        }
    }

    /**
     * Da de alta un nuevo comentario
     * @param BasicRequest $request
     * @return mixed
     */
    public function setPostTrack(BasicRequest $request)
    {
        Log::debug('Inicia setPostTrack desde: ' . TrackDaoImpl::class);
        try {
            if (empty($request->getData()['comment'])) {
                new Exception("El comentario es necesario para esta acción");
            }
            $setPostTrack = new PostTrack;
            $setPostTrack->comment = $request->getData()['comment'];
            $setPostTrack->post_track_parent_id = $request->getData()['postTrackParentId'];
            $setPostTrack->user_id = $request->getData()['userId'];
            $setPostTrack->track_id = $request->getId();
            $setPostTrack->status_id = 3;
            $setPostTrack->save();

            return $setPostTrack->id;

        } catch (\Exception $ex) {
            throw new DAOException($ex);
        }
    }

    /**
     * Obtiene la cantidad de tracks dado un id
     * de estado.
     * @param $id
     * @return mixed
     */
    public function getCountTracks($id)
    {
        Log::debug('Inicia getCountTracks desde: ' . TrackDaoImpl::class);
        try {
            return Track::where('status_id', '=', $id)->count();
        } catch (\Exception $ex) {
            throw new DAOException($ex);
        }
    }

    /**
     * Obtiene una lista de tracks deacuerdo a un filtro
     * selecionado
     * @param BasicRequest $request
     * @return mixed
     */
    public function getSmartListTracks(BasicRequest $request)
    {
        // TODO: Implement getSmartListTracks() method.
    }

    /**
     * Cabia de estado un track
     * @param $id
     * @return mixed
     */
    public function updateStatusTrack(BasicRequest $request)
    {
        Log::debug('Inicia updateStatusTrack desde: ' . TrackDaoImpl::class);
        try {
            return Track::where('id', '=', $request->getId())
                ->update(['status_id' => $request->getData()['statusId']]);
        } catch (\Exception $ex) {
            throw new DAOException($ex);
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
        // TODO: Implement updateTrackInReview() method.
    }

    /**
     * Autoriza un track para su publicacion definitiva en al app
     * @param BasicRequest $request
     * @return mixed
     */
    public function autorizeTrackInReview(BasicRequest $request)
    {
        // TODO: Implement autorizeTrackInReview() method.
    }

    private function elementary_select_tracks()
    {
        Log::debug('Inicia elementary_select_tracks desde: ' . TrackDaoImpl::class);
        try {
            return DB::table('tracks')
                ->join('authors', 'tracks.author_id', '=', 'authors.id')
                ->join('albumes', 'tracks.albume_id', '=', 'albumes.id')
                ->select(
                    'tracks.*',
                    'authors.firstName',
                    'authors.lastName',
                    'albumes.title as titleAlbume',
                    'Albumes.genre');

        } catch (\Exception $ex) {
            throw new Exception($ex);
        }

    }

    /**
     * Obtiene una lista de tracks por estado
     * @param BasicRequest $request
     * @return mixed
     */
    public function getListTracksByState(BasicRequest $request)
    {
        Log::debug('Inicia getListTracksByState desde: ' . TrackDaoImpl::class);
        try{
            $tracks = $this->elementary_select_tracks();
            return $tracks
                ->where('tracks.status_id', '=', $request->getData()['statusId'])
                ->paginate($request->getData()['rows_by_page']);
        }catch(\Exception $ex){
            throw new DAOException($ex);
        }
    }
    
}