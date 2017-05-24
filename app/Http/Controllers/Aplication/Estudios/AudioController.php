<?php

namespace App\Http\Controllers\Aplication\Estudios;

use App\Beans\BasicRequest;
use App\Beans\HttpResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Library\Constantes;
use App\Library\HttpStatusCode;
use App\Library\Message;
use App\Library\SendMail;
use App\Service\TrackServiceImpl as TrackService;
use Google\Cloud\Exception\ServiceException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Mockery\CountValidator\Exception;

class AudioController extends Controller
{
    /**
     * @var TrackService
     */
    protected $trackService;

    /**
     * AudioController constructor.
     * @param TrackService $trackService
     */
    public function __construct(TrackService $trackService)
    {
        $this->trackService = $trackService;
    }

    public function getPostTrack($id)
    {
        try {

            $request = new BasicRequest();

            if (Auth::guest()) {
                $request->setId($id);
                $audio = $this->trackService->getAllAudioForVisitants($request);
            } else {
                $request->setId($id);
                $request->setData(['idUser' => Auth::user()->id]);
                $audio = $this->trackService->getAllAudioForUser($request);
                $favorites = $this->trackService->getFavoriteTracks($request);
            }
            $postsTrack = $this->trackService->getPostsTrack($request);
            if (Auth::guest()) {
                return view('app.estudios.audios.post_track', ['audio' => $audio, 'posts' => $postsTrack]);
            } else {
                return view('app.estudios.audios.post_track',
                    ['audio' => $audio, 'posts' => $postsTrack, 'favorites' => $favorites]);
            }

        } catch (ServiceException $sex) {
            Log::error($sex);
        } catch (\Exception $ex) {
            Log::error($ex);
        }
    }

    public function getAll()
    {
        try {
            $request = new BasicRequest();

            if (Auth::guest()) {
                $audios = $this->trackService->getAllAudioForVisitants($request);
            } else {
                $request->setData(['idUser' => Auth::user()->id]);
                $audios = $this->trackService->getAllAudioForUser($request);
                $favorites = $this->trackService->getFavoriteTracks($request);
            }
        } catch (ServiceException $sex) {
            Log::error($sex);
            return view('app.estudios.audios.all_tracks', ['audios' => null, 'message' => 'Error al tratar de ontener todos los audios']);
        } catch (\Exception $ex) {
            Log::error($ex);
            return view('app.estudios.audios.all_tracks', ['audios' => null, 'message' => 'Error al tratar de ontener todos los audios']);
        }

        if (Auth::guest()) {
            return view('app.estudios.audios.all_tracks', ['audios' => $audios]);
        } else {
            return view('app.estudios.audios.all_tracks', ['audios' => $audios, 'favorites' => $favorites]);
        }

    }

    /**
     * Obtiene mas tracks por pagina
     * @return View
     */
    public function getPerPage()
    {
        try {
            $request = new BasicRequest();
            $response = new HttpResponse();
            if (Auth::guest()) {
                $audios = $this->trackService->getAllAudioForVisitants($request);
            } else {
                $request->setData(['idUser' => Auth::user()->id]);
                $audios = $this->trackService->getAllAudioForUser($request);
            }
            $response->setMessage("OK");
            $vista = View::make('app/estudios/audios/box_track', ['audios' => $audios]);
            $response->setView($vista);
            return response()->json($response->toArray(), HttpStatusCode::HTTP_ACCEPTED);

        } catch (ServiceException $sex) {
            Log::error($sex);
            $response->setMessage(Message::APP_ERROR_GENERAL_PPROCESS_FAILED);
            $response->setError($sex->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $ex) {
            Log::error($ex);
            $response->setMessage(Message::APP_ERROR_GENERAL_PPROCESS_FAILED);
            $response->setError($ex->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Obtiene bloques de audios por pagina
     * por el metodo POST.
     */
    public function getTracksByPage()
    {

    }

    /**
     * Activa o desactiva el estado favorito
     * para un audio.
     */
    function toggleFavoriteTrack($id)
    {
        Log::info('Inicia toggleFavoriteTrack desde: ' . AudioController::class);
        try {
            //$idTrack = Request();
            $response = new HttpResponse();
            if (Auth::guest()) {
                $response->setMessage(Message::APP_WARNING_FUNCTION_ONLY_AUTH_USER);
                return response()->json($response->toArray(), HttpStatusCode::HTTP_FORBIDDEN);
            } else {
                $request = new BasicRequest();
                $request->setId($id);
                $request->setData(['idUser' => Auth::user()->id]);
                $toggleFavoriteTrack = $this->trackService->toggleFavoriteTrack($request);
                switch ($toggleFavoriteTrack) {
                    case Constantes::STATUS_ACTIVE :
                        $response->setMessage(Message::APP_SET_FAVORITE);
                        $response->setData(['idEstatus' => Constantes::STATUS_ACTIVE, 'class' => '.favorite']);
                        return response()->json($response->toArray(), HttpStatusCode::HTTP_ACCEPTED);
                        break;
                    case Constantes::STATUS_INACTIVE :
                        $response->setMessage(Message::APP_UNSET_FAVORITE);
                        $response->setData(['idEstatus' => Constantes::STATUS_INACTIVE]);
                        return response()->json($response->toArray(), HttpStatusCode::HTTP_ACCEPTED);
                        break;
                    default:
                        $response->setMessage(Message::APP_WARNING_TRY_AGAIN);
                        return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);

                };
            }
        } catch (ServiceException $sex) {
            Log::error($sex);
            $response->setMessage(Message::APP_ERROR_GENERAL_PPROCESS_FAILED);
            $response->setError($sex->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $ex) {
            Log::error($ex);
            $response->setMessage(Message::APP_ERROR_GENERAL_PPROCESS_FAILED);
            $response->setError($ex->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function setRate($id, $rate)
    {
        Log::info('Inicia seRate desde: ' . AudioController::class);
        Log::info('rate:' . $rate);
        try {
            $response = new HttpResponse();
            $request = new BasicRequest();
            $request->setId($id);
            if (Auth::guest()) {
                $request->setData(['idUser' => 0, 'idVisitor' => 98, 'rate' => $rate]);//Poner el id del visitante
            } else {
                $request->setData(['idUser' => Auth::user()->id, 'idVisitor' => 0, 'rate' => $rate]);
            }
            $isRate = $this->trackService->setRate($request);
            if ($isRate) {
                $response->setMessage(sprintf(Message::APP_SET_RATE, $rate));
                return response()->json($response->toArray(), HttpStatusCode::HTTP_ACCEPTED);
            } else {
                $response->setMessage(Message::APP_WARNING_TRY_AGAIN);
                return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (ServiceException $sex) {
            Log::error($sex);
            $response->setMessage(Message::APP_ERROR_GENERAL_PPROCESS_FAILED);
            $response->setError($sex->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $ex) {
            Log::error($ex);
            $response->setMessage(Message::APP_ERROR_GENERAL_PPROCESS_FAILED);
            $response->setError($ex->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function setListened($id)
    {
        Log::info('Inicia setListened desde: ' . AudioController::class);
        try {
            $response = new HttpResponse();
            $request = new BasicRequest();
            $request->setId($id);
            if (Auth::guest()) {
                $request->setData(['idUser' => 0, 'idVisitor' => 98]);//Poner el id del visitante
            } else {
                $request->setData(['idUser' => Auth::user()->id, 'idVisitor' => 0]);
            }
            $isListened = $this->trackService->setListened($request);

            if ($isListened) {
                $response->setMessage("listened");
                return response()->json($response->toArray(), HttpStatusCode::HTTP_ACCEPTED);
            } else {
                $response->setMessage(Message::APP_WARNING_TRY_AGAIN);
                return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
            }

        } catch (ServiceException $sex) {
            Log::error($sex);
            $response->setMessage(Message::APP_ERROR_GENERAL_PPROCESS_FAILED);
            $response->setError($sex->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $ex) {
            Log::error($ex);
            $response->setMessage(Message::APP_ERROR_GENERAL_PPROCESS_FAILED);
            $response->setError($ex->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function setPostTrack($id, Request $httpRequest)
    {
        Log::info('Inicia setPostTrack desde: ' . AudioController::class);
        try {
            $response = new HttpResponse();
            $request = new BasicRequest();
            //Verifica si la solicitud es de un usuario logeado
            if (Auth::guest()) {
                $response->setMessage(Message::APP_WARNING_FUNCTION_ONLY_AUTH_USER);
                return response()->json($response->toArray(), HttpStatusCode::HTTP_FORBIDDEN);
            } else {

                //Valida los datos obligatorios
                Log::debug(Input::get('comment'));
                if (0 == $id || empty(Input::get('comment'))) {
                    throw new Exception(sprintf(
                        Message::APP_ERROR_SET_MESSAGE_NO_PARAMS,
                        $id,
                        $httpRequest->input('comment')));
                }
                //Setea los valores necesarios
                $request->setId($id);
                $request->setData([
                    'comment' => $httpRequest->input('comment'),
                    'postTrackParentId' => $httpRequest->input('postTrackParentId'),
                    'userId' => Auth::user()->id
                ]);
                //Ejecuta el servisio
                $idPostTrack = $this->trackService->setPostTrack($request);
                if ($idPostTrack > 0) {
                    $lastPost = $this->trackService->getLastPostTrack($idPostTrack);
                    $response->setMessage("posted");
                    $vista = View::make('app/comun/post', ['posts' => $lastPost]);
                    $response->setView($vista);
                    return response()->json($response->toArray(), HttpStatusCode::HTTP_ACCEPTED);
                } else {
                    $response->setMessage(Message::APP_WARNING_TRY_AGAIN);
                    return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
                }//<-- else

            }//<-- else

        } catch (ServiceException $sex) {
            Log::error($sex);
            $response->setMessage(Message::APP_ERROR_GENERAL_PPROCESS_FAILED);
            $response->setError($sex->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $ex) {
            Log::error($ex);
            $response->setMessage(Message::APP_ERROR_GENERAL_PPROCESS_FAILED);
            $response->setError($ex->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updatePostTrack($id, Request $Request)
    {
        Log::info('Inicia updatePostTrack desde: ' . AudioController::class);
        try {
            $response = new HttpResponse();
            $bRequest = new BasicRequest();

            //Verifica si la solicitud es de un usuario logeado
            if (Auth::guest()) {
                $response->setMessage(Message::APP_WARNING_FUNCTION_ONLY_AUTH_USER);
                return response()->json($response->toArray(), HttpStatusCode::HTTP_FORBIDDEN);
            } else {
                //Valida los datos obligatorios
                if (0 == $id || empty(Input::get('comment'))) {
                    throw new Exception(sprintf(
                        Message::APP_ERROR_SET_MESSAGE_NO_PARAMS,
                        $id,
                        $Request->input('comment')));
                }

                Log::debug($Request->input('comment'));
                //Setea los valores necesarios
                $bRequest->setId($id);
                $bRequest->setData([
                    'comment' => $Request->input('comment'),
                ]);
                $updatePost = $this->trackService->updatePostTrack($bRequest);
                if ($updatePost) {
                    $post = $this->trackService->getLastPostTrack($id);
                    $pencil = View::make('app/comun/pencil-post_updated', ['post' => $post[0]]);
                    $response->setMessage("Updated");
                    $response->setView($pencil);
                    $response->setData($Request->input('comment'));
                    return response()->json($response->toArray(), HttpStatusCode::HTTP_OK);
                }
            }

        } catch (ServiceException $sex) {
            Log::error($sex);
            $response->setMessage(Message::APP_ERROR_GENERAL_PPROCESS_FAILED);
            $response->setError($sex->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $ex) {
            Log::error($ex);
            $response->setMessage(Message::APP_ERROR_GENERAL_PPROCESS_FAILED);
            $response->setError($ex->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $id
     * @param Request $request
     */
    public function shareMail($id, Request $request)
    {
        Log::info('Inicia shareMail desde: ' . AudioController::class);
        $response = new HttpResponse();
        try {
            if (Auth::guest()) {
                $response->setMessage(Message::APP_WARNING_FUNCTION_ONLY_AUTH_USER);
                return response()->json($response->toArray(), HttpStatusCode::HTTP_FORBIDDEN);
            } else {

                $bRequest = new BasicRequest();
                $emails = $request->input('emails');
                Log::debug($emails);
                $send = SendMail::share(Auth::user()->id, $emails, $id);
                if ($send) {
                    $response->setMessage("Compartido");
                    return response()->json($response->toArray(), HttpStatusCode::HTTP_OK);
                }
            }
        } catch (ServiceException $sex) {
            Log::error($sex);
            $response->setMessage(Message::APP_ERROR_GENERAL_PPROCESS_FAILED);
            $response->setError($sex->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $ex) {
            Log::error($ex);
            $response->setMessage(Message::APP_ERROR_GENERAL_PPROCESS_FAILED);
            $response->setError($ex->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Muestra más comentarios seccionados por página
     * @param $id
     */
    public function getMoreComments($id)
    {
        Log::info('Inicia getMoreComments desde: ' . AudioController::class);
        $response = new HttpResponse();
        try {

            $bRequest = new BasicRequest();
            $bRequest->setId($id);
            $posts = $this->trackService->getPostsTrack($bRequest);
            if ($posts) {
                $response->setMessage("OK");
                $vista = View::make('app/comun/post', ['posts' => $posts]);
                $response->setView($vista);
                return response()->json($response->toArray(), HttpStatusCode::HTTP_OK);
            }
        } catch (ServiceException $sex) {
            Log::error($sex);
            $response->setMessage(Message::APP_ERROR_GENERAL_PPROCESS_FAILED);
            $response->setError($sex->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $ex) {
            Log::error($ex);
            $response->setMessage(Message::APP_ERROR_GENERAL_PPROCESS_FAILED);
            $response->setError($ex->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
