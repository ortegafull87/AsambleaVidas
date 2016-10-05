<?php

namespace App\Http\Controllers;

use App\Beans\BasicRequest;
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
use App\Service\AlbumeServiceImpl as AlbumeService; 
class AlbumAdmController extends Controller
{
    protected $albumeService;
    
    public function __construct(AlbumeService $albumeService){
        $this->middleware('auth');
        $this->albumeService = $albumeService;
    }
    
    private $generos = array(
        array('id' => 1, 'genre' => 'Predicación'),
        array('id' => 2, 'genre' => 'Serie'),
        array('id' => 3, 'genre' => 'Estudio'),
        array('id' => 4, 'genre' => 'Otro'),  
        );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
         $request = new BasicRequest();
         $request->setRows(10);
         $params = $this->albumeService->Read($request);
         return View('admin/albumes_adm',$params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
     {

        return View('admin/albumes_new',['generos' => $this->generos]);
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

            /**DB::table('albumes')
            ->where('id',$id)
            ->update(
                [
                'title'=> $albumeTitle,
                'genre' => $albumGenre,
                ]);*/

            Albume::where('id', $id)
            ->update(
                [
                'title'=> $albumeTitle,
                'genre' => $albumGenre,
                ]
                );


            $response->setMessage(Message::SUCCESS_ALBUMES_UPDATED);
            return response()->json($response->toArray(),HttpStatusCode::HTTP_CREATED);

        } catch (\Exception $e) {
            LOG::error($e->getMessage());
            $response->setMessage(Message::ERROR_5X);
            $response->setError($e->getMessage());
            return response()->json($response->toArray(),HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {

        LOG::info("Eliminando albume(es): ". $id);
        
        $response = new HttpResponse();

        try {

            DB::beginTransaction();

            if($id == -1){
                $allAlbumes = Albume::all();
                foreach ($allAlbumes as $row) { 
                    $row->delete();
                }
                $response->setMessage(Message::SUCCESS_AUTHORS_DELETED_ONE);
                $response->setData($allAlbumes);

            }else{

                $ids = preg_split('/[\s,]+/',$id);
                foreach($ids as $idTable){
                    $albume = Albume::find($idTable);
                    $albume->delete();
                }
                $response->setMessage(Message::SUCCESS_ALBUMES_DELETED_MANY);
                $response->setData($ids);
            }

            $params = ['albumes' => DB::table('albumes')->paginate(10)];
            $view   = View::make('admin/partials/list_albumes',$params);
            $response->setView($view);
            
            DB::commit();
            
            return response()->json($response->toArray(),HttpStatusCode::HTTP_OK);

        }catch(\Illuminate\Database\QueryException $qe){
            DB::rollBack();
            
            if(23000 == $qe->getCode()){
                $response->setMessage(Message::ERROR_ALBUMES_FOREIGN_KEY);
            }else{
                $response->setMessage(Message::ERROR_5X);
            }

            $response->setError($qe->getMessage());
            
            LOG::error($qe->getMessage());
            return response()->json($response->toArray(),HttpStatusCode::HTTP_NO_DELETE);

        }catch(\Exception $e){
            DB::rollBack();

            $response->setMessage(Message::ERROR_5X);
            $response->setError($e->getMessage());

            LOG::error($e->getMessage());

            return response()->json($response->toArray(),HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
