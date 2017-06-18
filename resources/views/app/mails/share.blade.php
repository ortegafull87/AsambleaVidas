@extends('layouts.mail')
@section('headMail')
    ¡Hola! un cordial saludo
@endsection

@section('sectionMail')
    {{$user->name}} ha compartido el siguiente material contigo desde <a
            href="www.vivelatorah.org">vivelatorah.org</a>, estamos seguros que será de gran importancia para ti.
@endsection

@section('extraCont')
    <br>
    <br>
    <div style="text-align:center;">
        <a href="{{asset('estudios/audios/post/'.$id_track.'/track')}}"
           style="text-decoration:none; padding:10px 15px;font-size:1.5em; background-color:#31b0d5;color:white;border-radius:5px;">
            &#9658; Escuchar
        </a>
    </div>
@endsection

