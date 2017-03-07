<?php

namespace App\Http\Controllers;

use App\Beans\BasicRequest;
use App\Beans\HttpResponse;
use App\Library\HttpStatusCode;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Service\TrackServiceImpl as TrackService;
use Illuminate\Support\Facades\Log;

class SmartFinderController extends Controller
{
    /**
     * @var TrackService
     */
    protected $trackService;

    /**
     * SmartFinderController constructor.
     * @param TrackService $trackService
     */
    public function __construct(TrackService $trackService)
    {
        $this->trackService = $trackService;
    }

    /**
     * @param $str
     */
    public function findTracks(Request $request){
        Log::info("Iniciando controllador findTracks");
        try {
            $basicRequest = new BasicRequest();
            $response = new HttpResponse();

            LOG::debug('Seteando valores');
            $basicRequest->setData(['str' => $request->input('query')]);

            $tracksFounded =  $this->trackService->findTracks($basicRequest);

            if(is_array($tracksFounded)){
                LOG::debug('Termina controlador: findTracks');
                return response()->json($tracksFounded, HttpStatusCode::HTTP_OK);
            }else{
                return response()->json([], HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
            }

        } catch (ServiceException $e) {
            LOG::error($e);
            $response->setMessage(Message::ERROR_5X);
            $response->setError($e->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            LOG::error($e);
            $response->setMessage(Message::ERROR_5X);
            $response->setError($e->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

    }


}
