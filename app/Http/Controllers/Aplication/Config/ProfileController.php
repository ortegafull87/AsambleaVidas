<?php

namespace App\Http\Controllers\Aplication\Config;

use App\Beans\BasicRequest;
use App\Beans\HttpResponse;
use App\Library\HttpStatusCode;
use App\Library\Message;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use App\Service\ProfileServiceImpl as ProfileService;

class ProfileController extends Controller
{
    /**
     * @var
     */
    protected $profileService;

    /**
     * @constructor
     * @param ProfileService $profileService
     */
    public function __construct(ProfileService $profileService)
    {
        $this->middleware('auth');
        $this->profileService = $profileService;

    }

    /**
     * Muestra la vista del perfil logueado
     * @return View
     */
    public function getProfile()
    {
        Log::info('iniciando controlador getProfile desde: ' . ProfileController::class);
        if (Auth::guest()) {
            abort(404);
        } else {
            $bRequest = new BasicRequest();
            $bRequest->setId(Auth::User()->id);
            $user = $this->profileService->getProfile($bRequest);
            $score = $this->profileService->getScores($bRequest);
            return View('app.config.profile', ['user' => $user, 'score' => $score]);
        }

    }

    /**
     * Actualiza los datos de perfil axcepto la contraseña
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        Log::info('iniciando controlador updateProfile desde: ' . ProfileController::class);
        try {

            $response = new HttpResponse();

            $names = $request->input('inputName');
            $lastName = $request->input('inputLasName');
            $nickName = $request->input('inputNickName');
            $email = $request->input('inputEmail');
            $gandle = $request->input('sltGandle');
            $birthday = $request->input('inputBirthday');
            $location = $request->input('inputLocation');

            Log::info($birthday);
            $date = date_create($birthday);
            $birthday = date_format($date, "Y-m-d");
            Log::info($birthday);
            //validaciones

            $bRequest = new BasicRequest();
            $bRequest->setId(Auth::User()->id);
            $bRequest->setData([
                'name' => $names,
                'last_name' => $lastName,
                'nick_name' => $nickName,
                'email' => $email,
                'gandle' => $gandle,
                'birthday' => $birthday,
                'location' => $location,
            ]);
            $update = $this->profileService->updateProfile($bRequest);

            if ($update) {
                $response->setMessage("Perfil actualizado!!");
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

    /**
     * @param Request $request
     */
    public function setAvatarAsProfileImage(Request $request)
    {
        Log::info('iniciando controlador updateProfile desde: ' . ProfileController::class);
        try {

            $response = new HttpResponse();
            $avatar = $request->input('avatar');
            //validaciones

            $bRequest = new BasicRequest();
            $bRequest->setId(Auth::User()->id);
            $bRequest->setData([
                'image' => $avatar,
            ]);

            $updateAvatar = $this->profileService->updateProfile($bRequest);

            if ($updateAvatar) {
                $response->setMessage(Message::APP_PROFILE_IMAGE_UPDATED);
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

    public function setFileBrowsAsProfileImage(Request $request)
    {
        Log::info('iniciando controlador setFileBrowsAsProfileImage desde: ' . ProfileController::class);
        try {

            $response = new HttpResponse();
            //validaciones
            if(!$request->hasFile('ImageBrows')){
                $response->setMessage(Message::APP_NOT_FILE_RECIVER);
                return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
            }

            $bRequest = new BasicRequest();
            $bRequest->setId(Auth::User()->id);
            $bRequest->setRequest($request);

            $updateImageBrows = $this->profileService->setFileBrowsAsProfileImage($bRequest);

            if ($updateImageBrows) {
                $response->setMessage(Message::APP_PROFILE_IMAGE_UPDATED);
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
