<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Track;
use App\Models\Author;
use App\Models\Albume;
use Validator;
use DB;
use Response;
class TrackAdmController extends Controller
{

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
    $tracks = DB::table('tracks')
    ->join('authors', 'tracks.author_id', '=', 'authors.id')
    ->join('albumes', 'tracks.albume_id', '=', 'albumes.id')
    ->select(
        'tracks.id', 
        'tracks.title', 
        'tracks.duration', 
        'tracks.created_at', 
        'tracks.updated_at',
        'tracks.file',
        'authors.firstName', 
        'authors.lastName',
        'albumes.title as titleAlbume')
    ->paginate(10); 

    return View('admin/tracks_adm',[
        'pistas'    =>$tracks,
        'authors'   =>Author::All(),
        'albumes'   =>Albume::All()]);
}

/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
    return View('admin/tracks_new',[
        'authors'   =>Author::All(),
        'albumes'   =>Albume::All()]);
}

/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{

    $title = $request->input('trk_titulo');
    $author_id = $request->input('trk_author');
    $albume_id = $request->input('trk_albume');

    $rules = array(
        'trk_titulo'    => 'required',
        'trk_author'    => 'required',
        'trk_albume'    => 'required',
        );

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json(['message'=>$validator],400);

    } else {

        $phat='filesAudio';

        $albume = Albume::find($albume_id);

        $carpeta = $phat.'/'.$albume->genre.'/'.$albume->title;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        $myFile = $request->hasFile('file');
        if($myFile){

            $error = array(
                'name' => $request->file('file')->getClientOriginalName(),
                'size' => $request->file('file')->getSize(),
                );

            $extension =    $request->file('file')->getClientOriginalExtension();
            $nombre =       $request->file('file')->getClientOriginalName(); 
            $request->file('file')->move($carpeta,$title.'.mp3');      

            $track = new Track;
            $track->title       = $request->input('trk_titulo');
            $track->duration    = 46;
            $track->file        = $carpeta.'/'.$title.'.mp3';
            $track->author_id   = $request->input('trk_author');
            $track->albume_id   = $request->input('trk_albume');
            $track->save();

            return response()->json(['message'=>"Se ha guardado la pista \"". $title."\" satisfactoriamente" ],200);

        }else{

// Create a response and modify a header value
            return Response::json(['message'=>"No se ha detectado ningun archivo de audio" ],400);
        }
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
    $tracks = DB::table('tracks')
    ->join('authors', 'tracks.author_id', '=', 'authors.id')
    ->join('albumes', 'tracks.albume_id', '=', 'albumes.id')
    ->select(
        'tracks.id', 
        'tracks.title', 
        'tracks.duration', 
        'tracks.created_at', 
        'tracks.updated_at',
        'tracks.file',
        'authors.id as idAuthor',
        'authors.firstName', 
        'authors.lastName',
        'albumes.id as idAlbume',
        'albumes.title as titleAlbume')
    ->where('tracks.id', '=', $id)
    ->get(); 

    return View('admin/tracks_edit',[
        'pistas'    =>$tracks,
        'authors'   =>Author::All(),
        'albumes'   =>Albume::All()]);
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
    $tracks = DB::table('tracks')
    ->join('authors', 'tracks.author_id', '=', 'authors.id')
    ->join('albumes', 'tracks.albume_id', '=', 'albumes.id')
    ->select(
        'tracks.id', 
        'tracks.title', 
        'tracks.duration', 
        'tracks.created_at', 
        'tracks.updated_at',
        'tracks.file',
        'authors.id as idAuthor',
        'authors.firstName', 
        'authors.lastName',
        'albumes.id as idAlbume',
        'albumes.title as titleAlbume')
    ->where('tracks.id', '=', $id)
    ->get(); 

    $title = $request->input('trk_titulo');
    $author_id = $request->input('trk_author');
    $albume_id = $request->input('trk_albume');
    $myFile = $request->hasFile('file');

    $phat='filesAudio';
    $albume = Albume::find($albume_id);
    $carpeta = $phat.'/'.$albume->genre.'/'.$albume->title;

    if($myFile){
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        $extension =    $request->file('file')->getClientOriginalExtension();
        $nombre =       $request->file('file')->getClientOriginalName();

        if(unlink($tracks[0]->file)){    
            $request->file('file')->move($carpeta,$title.'.mp3');

            DB::table('tracks')
            ->where('id', $id)
            ->update(
                [
                'title' => $title,
                'author_id' =>$author_id,
                'albume_id' =>$albume_id,
                'file' => $carpeta.'/'.$title.'.mp3'
                ]);
            return response()->json(['message'=>'Pista: '.$id.' modificada.' ],200);
        } else{
            return response()->json(['message'=>'La pista : '.$tracks[0]->file.' no ha posido ser borrada' ],500);
//:: Error
        }

    }else{
        $rename = rename($tracks[0]->file, $carpeta.'/'.$title.'.mp3');
        if($rename){
            DB::table('tracks')
            ->where('id', $id)
            ->update(
                [
                'title' => $title,
                'author_id' =>$author_id,
                'albume_id' =>$albume_id,
                'file' => $carpeta.'/'.$title.'.mp3'
                ]);
            return response()->json(['message'=>'Pista: '.$id.' modificada.' ],200);
        }else{
//::Error
            return response()->json(['message'=>'La pista : '.$tracks[0]->file.' no ha posido ser renombrada' ],500);
        }

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

    try {
        DB::beginTransaction();

        if($id == -1){
            $allTracks = Track::all();
            foreach ($allTracks as $row) {
                if(unlink($row->file)){    
                    $row->delete();
                }
            }

        }else{

            $ids = preg_split('/[\s,]+/',$id);
            foreach($ids as $idTable){
                $track = Track::find($idTable);
                if(unlink($track->file)){    
                    $track->delete();
                }
            }
        }
        DB::commit();
        return 'OK';

    }catch(Exception $e){
        DB::rollBack();
        return $e;
    }
}
}