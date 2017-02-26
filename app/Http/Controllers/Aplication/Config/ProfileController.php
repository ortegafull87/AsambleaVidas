<?php

namespace App\Http\Controllers\Aplication\Config;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class ProfileController extends Controller
{
    /**
     * @param $id
     * @return View
     */
    public function get($id){
        return View('app.config.profile',['id'=>$id]);
        //return "Pagina de Perfil" . $id;
    }
}
