<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Albume;
use Validator;
use DB;
use Response;
use Excetion;
use Log;
use App\Library\HttpStatusCode;
use App\Library\Message;
use App\Beans\HttpResponse;
use View;
class AlbumAdmController extends Controller
{
    private $generos = array(
        array('id' => 1, 'genre' => 'Predicación'),
        array('id' => 2, 'genre' => 'Serie'),
        array('id' => 3, 'genre' => 'Estudio'),
        array('id' => 4, 'genre' => 'Otro'),  
        );

    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
        $params = ['albumes' => DB::table('albumes')->paginate(10)];
        return View('admin/albumes_adm',$params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
     {
        $generos = array(
            array('id' => 1, 'genre' => 'Predicación'),
            array('id' => 2, 'genre' => 'Serie'),
            array('id' => 3, 'genre' => 'Estudio'),
            array('id' => 4, 'genre' => 'Otro'),  
            );

        return View('admin/albumes_new',['generos' => $generos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
     {
        $response = new HttpResponse();
        
        $albumeTitle   = $request->input("title");
        $albumGenre    = $request->input("genre");

        LOG::info("Creando album: " . $albumeTitle );

        try {

            $rules = array(
                'title'         => 'required',
                'genre'         => 'required',
                );

            $messages = [
            'required'  => ' El campo \':attribute\' es obligatorio ',
            ];


            $validator = Validator::make($request->all(), $rules,$messages);

            if ($validator->fails()) {

                $errorRules = $validator->errors()->all();
                $response->setMessage(Message::WARNING_2X);
                $response->setError($errorRules);
                return response()->json($response->toArray(),HttpStatusCode::HTTP_ACCEPTED);

            } 

            $albume = new Albume;
            $albume->title   =  $albumeTitle;
            $albume->genre   =  $albumGenre;
            $albume->save();

            //$params = ['authors' => DB::table('authors')->paginate(10)];
            $response->setMessage('Albume:  ' . $albumeTitle . ' creado.');
            return response()->json($response->toArray(),HttpStatusCode::HTTP_CREATED);

        } catch (\Exception $e) {
            LOG::error($e->getMessage());
            $response->setMessage(Message::ERROR_5X);
            $response->setError($e->getMessage());
            return response()->json($response->toArray(),HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($id)
     {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
        $params = [
        'albume' => DB::table('albumes')
        ->where('id','=',$id)
        ->get(),
        'generos'=> $this->generos
        ];
        return View('admin/albumes_adit',$params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
     {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
        //
    }
}
