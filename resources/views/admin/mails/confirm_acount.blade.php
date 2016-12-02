@extends('layouts.email')

@section('mail-title')
    ¡Ya casi {{$user->name}}!
@endsection

@section('mail-message')
    Te damos la más cordial bienvenida a esta comunidad, antes de continuar, es necesario confirmar tu cuenta.
@endsection

@section('mail-btn')
    <a href="http://" style="background-color:#178f8f;border-radius:4px;color:#ffffff;display:inline-block;font-family:Helvetica, Arial, sans-serif;font-size:16px;font-weight:bold;line-height:50px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;">Confirmar</a>
@endsection

@section('mail-actions')
    <a href="#">Ver en navegador</a> | <a href="#">Unsubscribe</a> | <a href="#">Contacto</a>
@endsection

@section('mail-rigts')
    © 2016 vivelatorah.org Todos los derechos reservados
@endsection