@extends('layouts.mail')

@section('headMail')
    ¡Ya casi {{$user->name}}!
@endsection

@section('sectionMail')
    Te damos la más cordial bienvenida a esta comunidad, antes de continuar es necesario confirmar tu cuenta.
@endsection

@section('extraCont')
    <br>
    <br>
    <div style="text-align:center;">
        <a href="{{asset('/acount/new/'.$user->id.'/'.$user->register_token.'/confirm')}}" style="background-color:#178f8f;border-radius:4px;color:#ffffff;display:inline-block;font-family:Helvetica, Arial, sans-serif;font-size:16px;font-weight:bold;line-height:50px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;">Confirmar</a>
    </div>
    <br>
    <p><small>Si tu no has creado esta cuenta, favor de no confirmar.</small></p>
@endsection