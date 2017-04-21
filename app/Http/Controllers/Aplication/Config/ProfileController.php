<?php

namespace App\Http\Controllers\Aplication\Config;

use App\Beans\BasicRequest;
use App\Beans\HttpResponse;
use App\Library\HttpStatusCode;
use App\Library\Message;
use App\Library\Util;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            $patter = env('URL_BASE_IMGS') . 'avatars/*.*';
            $avatars = Util::scanDirectory($patter);
            $bRequest = new BasicRequest();
            $bRequest->setId(Auth::User()->id);
            $bRequest->setData(['rows' => env('ROWS_NOTE_PROFILE')]);
            $user = $this->profileService->getProfile($bRequest);
            $score = $this->profileService->getScores($bRequest);
            $notes = $this->profileService->getNotes($bRequest);

            return View('app.config.profile',
                ['user' => $user, 'score' => $score, 'avatars' => $avatars, 'notes' => $notes]);
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

            $updateAvatar = $this->profileService->updateImageProfile($bRequest);

            if ($updateAvatar) {
                $response->setMessage(Message::APP_PROFILE_IMAGE_UPDATED);
                $response->setData(asset(env('URL_BASE_IMGS') . $updateAvatar));
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function setFileBrowsAsProfileImage(Request $request)
    {
        Log::info('iniciando controlador setFileBrowsAsProfileImage desde: ' . ProfileController::class);
        try {

            $response = new HttpResponse();
            //validaciones
            if (!$request->hasFile('ImageBrows')) {
                $response->setMessage(Message::APP_NOT_FILE_RECIVER);
                return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
            }

            $bRequest = new BasicRequest();
            $bRequest->setId(Auth::User()->id);
            $bRequest->setRequest($request);

            $updateImageBrows = $this->profileService->setFileBrowsAsProfileImage($bRequest);

            if ($updateImageBrows) {
                $response->setMessage(Message::APP_PROFILE_IMAGE_UPDATED);
                $response->setData(asset($updateImageBrows));
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
    public function confirmImageBrows(Request $request)
    {
        Log::info('Inicias confirmImageBrows desde: ' . ProfileController::class);
        $response = new HttpResponse();
        try {
            $confirm_image = $request->input('conf_img');
            $bRequest = new BasicRequest();
            $bRequest->setId(Auth::User()->id);
            $bRequest->setData(['confirm_image' => $confirm_image]);

            $confirm = $this->profileService->ConfirmSetFileBrowsAsProfileImage($bRequest);
            if ($confirm) {
                $response->setMessage(Message::APP_PROFILE_IMAGE_UPDATED);
                $response->setData(asset($confirm));
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
     * Elimina las imagenes temporales
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelUpdateImage(Request $request)
    {
        Log::info('Inicias cancelUpdateImage desde: ' . ProfileController::class);
        $response = new HttpResponse();
        try {
            $patter = env('URL_BASE_IMGS') . 'users/temp*.*';
            Util::findAndSuprFiles($patter);
            $response->setMessage('Canceled');
            return response()->json($response->toArray(), HttpStatusCode::HTTP_OK);
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
    public function updatePassword(Request $request)
    {
        Log::info('Inicias updatePassword desde: ' . ProfileController::class);
        $response = new HttpResponse();
        try {
            $bRequest = new BasicRequest();
            $bRequest->setId(Auth::User()->id);
            Log::debug($request->input('current_password'));
            $bRequest->setData(
                [
                    'current_password' => $request->input('current_password'),
                    'new_password' => $request->input('new_password'),
                ]
            );
            $update = $this->profileService->updatePassword($bRequest);
            if ($update) {
                $response->setMessage('Cambio exitoso<br>Ingresa tu nueva contraseña la proxima vez que inicies sesi&oacute;n');
                $response->setData("OK");
                return response()->json($response->toArray(), HttpStatusCode::HTTP_OK);
            } else {
                $response->setMessage('Tu contraseña actual no coinside');
                $response->setData("ERROR");
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
