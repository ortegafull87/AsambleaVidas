<?php

namespace App\Http\Controllers\Aplication\Estudios;

use App\Beans\BasicRequest;
use App\Beans\HttpResponse;
use App\Library\Constantes;
use App\Library\HttpStatusCode;
use App\Library\Message;
use Google\Cloud\Exception\ServiceException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Service\TrackServiceImpl as TrackService;

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

    public function getAll()
    {
        try {
            $request = new BasicRequest();

            if (Auth::guest()) {
                $audios = $this->trackService->getAllAudioForVisitants($request);
            } else {
                $request->setId(Auth::user()->id);
                $audios = $this->trackService->getAllAudioForUser($request);
            }
        } catch (ServiceException $sex) {
            Log::error($sex);
            return view('app.estudios.audios.all', ['audios' => null, 'message' => 'Error al tratar de ontener todos los audios']);
        } catch (\Exception $ex) {
            Log::error($ex);
            return view('app.estudios.audios.all', ['audios' => null, 'message' => 'Error al tratar de ontener todos los audios']);
        }
        return view('app.estudios.audios.all', ['audios' => $audios]);

    }

    /**
     * Obtiene bloques de audios por pagina
     * por el metodo POST.
     */
    function getTracksByPage()
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
            $idTrack = Request();
            $response = new HttpResponse();
            if (Auth::guest()) {
                $response->setMessage(Message::APP_WARNING_FUNCTION_ONLY_AUTH_USER);
                return response()->json($response->toArray(), HttpStatusCode::HTTP_FORBIDDEN);
            } else {
                $request = new BasicRequest();
                $request->setId($id);
                $request->setData(['idUser'=>Auth::user()->id]);
                $toggleFavoriteTrack = $this->trackService->toggleFavoriteTrack($request);
                switch ($toggleFavoriteTrack) {
                    case Constantes::STATUS_ACTIVE :
                        $response->setMessage(Message::APP_SET_FAVORITE);
                        $response->setData(['idEstatus'=>Constantes::STATUS_ACTIVE, 'class' => '.favorite']);
                        return response()->json($response->toArray(), HttpStatusCode::HTTP_ACCEPTED);
                        break;
                    case Constantes::STATUS_INACTIVE :
                        $response->setMessage(Message::APP_UNSET_FAVORITE);
                        $response->setData(['idEstatus'=>Constantes::STATUS_INACTIVE]);
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
}
