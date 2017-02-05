<?php

namespace App\Http\Controllers;

use App\Beans\BasicRequest;
use App\Beans\HttpResponse;
use App\Library\HttpStatusCode;
use App\Library\Message;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Service\TrackServiceImpl as TrackService;
use App\Models\Track;
use App\Models\Author;
use App\Models\Albume;
use Validator;
use DB;
use Response;
use Exception;
use Log;

class TrackAdmController extends Controller
{
    protected $trackService;

    public function __construct(TrackService $trackService)
    {
        $this->middleware('auth');
        $this->trackService = $trackService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
                'authors.firstName',
                'authors.lastName',
                'albumes.title as titleAlbume',
                'albumes.folder')
            ->paginate(10);

        return View('admin/tracks_adm', [
            'pistas' => $tracks,
            'authors' => Author::All(),
            'albumes' => Albume::All(),
            'paht' => env('URL_BASE_AUDIOFILES')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin/tracks_new', [
            'authors' => Author::All(),
            'albumes' => Albume::All()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        LOG:info(TrackAdmController::class);
        $title = $request->input('trk_titulo');
        $author_id = $request->input('trk_author');
        $albume_id = $request->input('trk_albume');

        try {
            $rules = array(
                'trk_titulo' => 'required',
                'trk_author' => 'required',
                'trk_albume' => 'required',
            );
            LOG::info('validando permisos');
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['message' => $validator], 204);
            } else {

                $phat = env('URL_BASE_AUDIOFILES');
                $albume = Albume::find($albume_id);
                $carpeta = $phat . '/' . $albume->folder;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777, true);
                }

                $myFile = $request->hasFile('file');
                LOG::info('verificando si hay archivo');
                if ($myFile) {

                    $error = array(
                        'name' => $request->file('file')->getClientOriginalName(),
                        'size' => $request->file('file')->getSize(),
                    );

                    $extension = $request->file('file')->getClientOriginalExtension();
                    $nombre = $request->file('file')->getClientOriginalName();
                    $request->file('file')->move($carpeta, $title . '.mp3');

                    $track = new Track;
                    $track->title = $request->input('trk_titulo');
                    $track->duration = 46;
                    $track->file = $title . '.mp3';
                    $track->author_id = $request->input('trk_author');
                    $track->albume_id = $request->input('trk_albume');
                    $newTrack = $track->save();

                    if ($newTrack) {
                        return response()->json(['message' => "Se ha guardado la pista \"" . $title . "\" satisfactoriamente"], 200);
                    }
                } else {
                    return Response::json(['message' => "No se ha detectado ningun archivo de audio"], 204);
                }
            }
        } catch (\Exception $e) {
            LOG::error($e);
            if (file_exists($carpeta . '/' . $title . '.mp3')) {
                unlink($carpeta . '/' . $title . '.mp3');
            }
            return Response::json(['message' => "No fue posible dar de alta esta pista, contacte al administrador", "error" => $e], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
                    'albumes.folder')
                ->where('tracks.id', '=', $id)
                ->get();

            return View('admin/tracks_edit', [
                'pistas' => $tracks,
                'authors' => Author::All(),
                'albumes' => Albume::All(),
                'paht' => env('URL_BASE_AUDIOFILES')
            ]);
        } catch (\Exception $e) {

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        LOG::info(TrackAdmController::class);
        $response = new HttpResponse();

        try {
            $rules = array(
                'trk_titulo' => 'required',
                'trk_author' => 'required',
                'trk_albume' => 'required',
            );

            $messages = [
                'required' => ' El campo \':attribute\' es obligatorio ',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {

                $errorRules = $validator->errors()->all();
                $response->setMessage(Message::WARNING_2X);
                $response->setError($errorRules);
                return response()->json($response->toArray(), HttpStatusCode::HTTP_ACCEPTED);
            }

            $basicRequest = new BasicRequest();
            $basicRequest->setRequest($request);
            $basicRequest->setId($id);
            $basicRequest->setData([
                'title' => $request->input('trk_titulo'),
                'author_id' => $request->input('trk_author'),
                'albume_id' => $request->input('trk_albume'),
                'sketch' => $request->input('trk_sketch'),
                'remote_repository' => $request->input('trk_url'),
            ]);

            $serviceResponse = $this->trackService->update($basicRequest);
            if ($serviceResponse->getStatus()) {
                $response->setMessage($serviceResponse->getMessage());
                $response->setData($serviceResponse->getData());
                return response()->json($response->toArray(), HttpStatusCode::HTTP_OK);
            } else {
                $response->setMessage(Message::ERROR_5X);
                $response->setError($serviceResponse->getMessage());
                return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
            }

        } catch (\Exception $e) {
            LOG::error($e);
            $response->setMessage(Message::ERROR_5X);
            $response->setError($e->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LOG::info(TrackAdmController::class);
        $response = new HttpResponse();
        $basicRequest = new BasicRequest();
        try {
            if ($id == -1) { //Borrar todos los registros.
                $basicRequest->setId($id);
            } else {
                $ids = preg_split('/[\s,]+/', $id);
                $data = Array();
                foreach ($ids as $idTable) {
                    $data[] = $idTable;
                }
                $basicRequest->setData($data);
            }
            $serviceResponse = $this->trackService->delete($basicRequest);

            if($serviceResponse){
                $response->setMessage($serviceResponse->getMessage());
                $response->setData($serviceResponse->getData());
                return response()->json($response->toArray(), HttpStatusCode::HTTP_OK);
            }else{
                $response->setMessage(Message::ERROR_5X);
                $response->setError($serviceResponse->getMessage());
                return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
            }

        } catch (\Exception $e) {
            LOG::error($e->getMessage());
            $response->setMessage(Message::ERROR_5X);
            $response->setError($e->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}