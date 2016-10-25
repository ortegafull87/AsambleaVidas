<?php

namespace App\Http\Controllers;

use App\Beans\BasicRequest;
use App\Beans\HttpResponse;
use App\Beans\ServiceResponse;
use App\Library\HttpStatusCode;
use App\Library\Message;
use App\Library\Util;
use App\Service\UserServiceImpl as UserService;
use Illuminate\Auth\Access\Response;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Requests;
use Log;
use View;
use Exception;

class UserAdmController extends Controller
{
    protected $userService;

    const ROOT_ACCESS = 1;

    public function __construct(UserService $userServcice)
    {
        $this->middleware('auth');
        $this->userService = $userServcice;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bRequest = new BasicRequest();
        $bRequest->setRows(10);
        $data = $this
            ->userService
            ->Read($bRequest);
        return View('admin/users_adm', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $response = new HttpResponse();

        try {
            // Validamos que el usuario tenga permisos para usar esta funcion
            if (Util::AUNTH_USER_ROOT()) {

                $rules = array(
                    'user_id' => 'required',
                    'status_id' => 'required',
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

                $bRequest = new BasicRequest();
                $bRequest->setId($request->input('user_id'));
                $bRequest->setData(['status_id' => $request->input('status_id')]);
                $bRequest->setRequest($request);

                // Hacemos la peticion de la actualización
                $upDate = $this->userService->update($bRequest);

                if ($upDate->getStatus()) {

                    $response->setData($upDate->getData());
                    $response->setMessage($upDate->getMessage());

                    return response()->json($response->toArray(), HttpStatusCode::HTTP_OK);

                } else {

                    $response->setMessage(Message::ERROR_5X);
                    return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
                }

            } else {

                $response->setMessage(Message::NOT_PRIVILEGE);
                $response->setError(null);
                return response()->json($response->toArray(), HttpStatusCode::HTTP_UNAUTHORIZED);
                //return View('errors/401',[]);
            }
        } catch (\Exception $e) {
            LOG::error($e->getMessage());
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
        //
    }
}
