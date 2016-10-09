<?php

namespace App\Http\Controllers;

use App\Beans\BasicRequest;
use App\Beans\HttpResponse;
use App\Library\HttpStatusCode;
use App\Library\Message;
use App\Library\Util;
use App\Service\UserServiceImpl as UserService;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Mockery\CountValidator\Exception;

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
        $response = new HttpResponse();

        try {

            if (Util::AUNTH_USER_ROOT()) {
                return 'Yes';
            } else {
                $response->setMessage(Message::NOT_PRIVILEGE);
                $response->setError(null);
                //return response()->json($response->toArray(), HttpStatusCode::HTTP_UNAUTHORIZED);
                return View('errors/401',[]);
            }
        } catch (\Exception $e) {
            LOG::error($e->getMessage());
            $response->setMessage(Message::ERROR_5X);
            $response->setError($e->getMessage());
            return response()->json($response->toArray(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
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
        //
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
