<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Author;
use Validator;
use DB;
use Response;
use Excetion;
use Log;
use App\Library\HttpStatusCode;
use App\Library\Message;
use App\Beans\HttpResponse;
use View;

class AuthorAdmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params = ['authors' => DB::table('authors')->paginate(10)];
        return View('admin/authors_adm',$params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin/authors_new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $authorFirstName   = $request->input("nombre");
        $authorLastName    = $request->input("apellidos");
        $authorEmail       = $request->input("email");
        try {

            $rules = array(
                'nombre'        => 'required|regex:/^[\pL\s\-]+$/u',
                'apellidos'     => 'required|regex:/^[\pL\s\-]+$/u',
                'email'         => 'required',
                );

            $messages = [
            'required'  => ' El campo \':attribute\' es obligatorio ',
            'regex'     => ' El campo \':attribute\' Solo acepta letras ',
            ];


            $validator = Validator::make($request->all(), $rules,$messages);

            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['message'=>$message],202);

            } 

            $author = new Author;
            $author->firstName  =  $authorFirstName;
            $author->lastName   =  $authorLastName;
            $author->save();

            $params = ['authors' => DB::table('authors')->paginate(10)];

            return response()->json(
                ['message'=>'Alta satisfactoria para el autor: '
                .$authorFirstName
                . '  '
                .$authorLastName]
                ,201);

        } catch (Exception $e) {
            return response()->json(['message'=>$e->getMessage()],500);
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
        $author = [
        'authors' => DB::table('authors')
        ->where('id','=',$id)
        ->get()];
        return View('admin/authors_edit',$author);
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
        $authorFirstName   = $request->input("nombre");
        $authorLastName    = $request->input("apellidos");
        $authorEmail       = $request->input("email");
        try {

            $rules = array(
                'nombre'        => 'required|regex:/^[\pL\s\-]+$/u',
                'apellidos'     => 'required|regex:/^[\pL\s\-]+$/u',
                'email'         => 'required',
                );

            $messages = [
            'required'  => ' El campo \':attribute\' es obligatorio ',
            'regex'     => ' El campo \':attribute\' Solo acepta letras ',
            ];


            $validator = Validator::make($request->all(), $rules,$messages);

            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['message'=>$message],202);

            }

            DB::table('authors')
            ->where('id',$id)
            ->update(
                [
                'firstName'=> $authorFirstName,
                'lastName' => $authorLastName,
                //'email'    => $authorEmail,
                ]); 

            return response()->json(['message'=>'Author modificado.'],200);
        } catch (Exception $e) {
            return response()->json(['message'=>$e->getMessage()],500);
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
        LOG::info("Eliminando autor(es): ". $id);
        
        $response = new HttpResponse();

        try {

            DB::beginTransaction();

            if($id == -1){
                $allAuthors = Author::all();
                foreach ($allAuthors as $row) { 
                    $row->delete();
                }
                $response->setMessage(Message::SUCCESS_AUTHORS_DELETED_ONE);
                $response->setData($ids);

            }else{

                $ids = preg_split('/[\s,]+/',$id);
                foreach($ids as $idTable){
                    $author = Author::find($idTable);
                    $author->delete();
                }
                $response->setMessage(Message::SUCCESS_AUTHORS_DELETED_MANY);
                $response->setData($ids);
            }

            $params = ['authors' => DB::table('authors')->paginate(10)];
            $view   = View::make('admin/partials/list_authors',$params);
            $response->setView($view);
            
            DB::commit();
            
            return response()->json($response->toArray(),HttpStatusCode::HTTP_OK);

        }catch(\Illuminate\Database\QueryException $qe){
            DB::rollBack();
            
            if(23000 == $qe->getCode()){
                $response->setMessage(Message::ERROR_AUTHORS_FOREIGN_KEY);
            }else{
                $response->setMessage(Message::ERROR_5X);
            }

            $response->setError($qe->getMessage());
            
            LOG::error($qe->getMessage());
            return response()->json($response->toArray(),HttpStatusCode::HTTP_NO_DELETE);

        }catch(\Exception $e){
            DB::rollBack();

            $response->setMessage(Message::ERROR_5X);
            $response->setError($qe->getMessage());

            LOG::error($e->getMessage());

            return response()->json($response->toArray(),HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
