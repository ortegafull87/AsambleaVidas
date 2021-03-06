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
use DB;
use Illuminate\Support\Facades\Input;
use Log;
use Mockery\CountValidator\Exception;

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

            $filter = (isset($request->getData()['fter'])?$request->getData()['fter']:'');
            if($filter == 'all' || empty($filter)){
                $filter = DB::raw(' true ');
            }else{
                $filter = DB::raw(" al.genre = '" . $filter. "' ");
            }

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
                ->where('t.status_id', '=', Constantes::STATUS_ACTIVE)
                ->whereRaw($filter)
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
        Log::debug('Inicia getAllAudioForVisitants desde: ' . AudioDao::class);
        try {
            
            $filter = (isset($request->getData()['fter'])?$request->getData()['fter']:'');
            
            if($filter == 'all' || empty($filter)){
                $filter = DB::raw(' true ');
            }else{
                $filter = DB::raw(" al.genre = '" . $filter. "' ");
            }

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
                ->where('t.status_id', '=', Constantes::USER_ACTIVE)
                ->whereRaw($filter)
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
            // Obtiene los post ecepto los de tipo respuesta
            $posts = DB::table('post_track')
                ->join('users', 'post_track.user_id', '=', 'users.id')
                ->select('post_track.id', 'post_track.id as virtual_id', 'post_track.comment', 'post_track.post_track_parent_id', 'post_track.track_id', 'post_track.user_id', 'post_track.status_id', 'post_track.created_at', 'post_track.updated_at', 'users.name', 'users.image')
                ->where('post_track.track_id', '=', $request->getId())
                ->where('post_track.status_id', '=', Constantes::STATUS_ACTIVE)
                ->where('post_track_parent_id', '<', 1);

            // Obtiene solo los post de tipo respuesta
            $posts_resp = DB::table('post_track')
                ->join('users', 'post_track.user_id', '=', 'users.id')
                ->select('post_track.id', 'post_track.post_track_parent_id as virtual_id', 'post_track.comment', 'post_track.post_track_parent_id', 'post_track.track_id', 'post_track.user_id', 'post_track.status_id', 'post_track.created_at', 'post_track.updated_at', 'users.name', 'users.image')
                ->where('post_track.track_id', '=', $request->getId())
                ->where('post_track.status_id', '=', Constantes::STATUS_ACTIVE)
                ->where('post_track_parent_id', '>', 0);

            $all_post = $posts->union($posts_resp)
                ->orderBy('virtual_id', 'ASC')
                ->get();


            $paginate = 10;
            $page = Input::get('page', 1);

            $offSet = ($page * $paginate) - $paginate;
            $itemsForCurrentPage = array_slice($all_post, $offSet, $paginate, true);
            $result = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($all_post), $paginate, $page);
            return $result;

            //return new Paginator($all_post, 10,2);

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
                ->select('post_track.*', 'users.name', 'users.image')
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

        Log::debug('Inicia updateTrackInReview desde: ' . TrackDaoImpl::class);
        try {
            return Track::where('id', '=', $request->getId())
                ->update(
                    [
                        'sketch' => $request->getData()['sketch'],
                        'description' => $request->getData()['documentacion'],
                        'status_id' => $request->getData()['statusId'],
                    ]
                );
        } catch (\Exception $ex) {
            throw new DAOException($ex);
        }
    }

    /**
     * Autoriza un track para su publicacion definitiva en al app
     * @param BasicRequest $request
     * @return mixed
     */
    public function autorizeTrackInReview(BasicRequest $request)
    {
        try {
            return Track::where('id', '=', $request->getId())
                ->update(
                    [
                        'sketch' => $request->getData()['sketch'],
                        'description' => $request->getData()['documentacion'],
                        'status_id' => $request->getData()['statusId'],
                    ]
                );
        } catch (\Exception $ex) {
            throw new DAOException($ex);
        }
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

    private function smart_finder_select()
    {
        Log::debug('Inicia smart_finder_select desde: ' . TrackDaoImpl::class);
        try {
            return DB::table('tracks')
                ->join('authors', 'tracks.author_id', '=', 'authors.id')
                ->join('albumes', 'tracks.albume_id', '=', 'albumes.id')
                ->select(
                    'tracks.id as id',
                    'tracks.title as label');

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
        try {
            $tracks = $this->elementary_select_tracks();
            return $tracks
                ->where('tracks.status_id', '=', $request->getData()['statusId'])
                ->paginate($request->getData()['rows_by_page']);
        } catch (\Exception $ex) {
            throw new DAOException($ex);
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
        Log::debug('Inicia getTrackForReview desde: ' . TrackDaoImpl::class);
        try {
            $tracks = $this->elementary_select_tracks();
            return $tracks
                ->where('tracks.id', '=', $request->getId())
                ->get();
        } catch (\Exception $ex) {
            throw new DAOException($ex);
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

        Log::debug('Inicia findTracks desde: ' . TrackDaoImpl::class);
        try {
            $tracks = $this->smart_finder_select();
            $str = $request->getData()['str'];
            $str = '%' . $str . '%';
            return $tracks
                ->where('tracks.title', 'like', $str)
                ->orWhere('authors.firstName', 'like', $str)
                ->orWhere('authors.lastName', 'like', $str)
                ->orWhere('albumes.title', 'like', $str)
                ->orWhere('Albumes.genre', 'like', $str)
                ->orWhere('tracks.created_at', 'like', $str)
                ->get();
        } catch (\Exception $ex) {
            throw new DAOException($ex);
        }
    }

    /**
     * Funcion que obtiene información de un track para
     * la revista.
     * @param BasicRequest $request
     * @return mixed
     */
    public function getTrackById(BasicRequest $request)
    {
        Log::debug('Inicia getTrackById desde: ' . TrackDaoImpl::class);
        try {
            $tracks = $this->elementary_select_tracks();
            return $tracks
                ->where('tracks.id', '=', $request->getId())
                ->get();
        } catch (\Exception $ex) {
            throw new DAOException($ex);
        }
    }

    /**
     * Modifica el comentario de un post
     * @param BasicRequest $request
     * @return mixed
     */
    public function updatePostTrack(BasicRequest $request)
    {
        Log::debug('Inicia updatePostTrack desde: ' . TrackDaoImpl::class);
        try {
            return PostTrack::where('id', '=', $request->getId())
                ->update($request->getData());
        } catch (\Exception $ex) {
            throw new DAOException($ex);
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
        Log::debug('Inicia getFavoriteTracks desde: ' . TrackDaoImpl::class);
        $id_user = $request->getData()['idUser'];
        try {
            return DB::table('tracks as t')
                ->join('authors as au', 't.author_id', '=', 'au.id')
                ->join('albumes as al', 't.albume_id', '=', 'al.id')
                ->select(
                    't.id as id',
                    't.title',
                    't.file',
                    'al.title as albume',
                    'al.genre',
                    'al.genre',
                    DB::raw('concat(au.firstName,\' \',au.lastName) as author'))
                ->whereRaw('t.id in (select track_id from favorites where user_id=' . $id_user . ' and status_id=3)')
                ->get();
        } catch (\Exception $ex) {
            throw new DAOException($ex);
        }
    }
}