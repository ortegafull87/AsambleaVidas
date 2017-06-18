<div style="text-align: center;">
    <p style="font-size: 20px;color: #3d3d3d; padding-top: 20px;">
        ¡Hola <b>{{$user->name}}</b>!
    </p>
    <p style="font-size: 20px;color: #3d3d3d; padding-top: 20px;">
        <br>Te notificamos que tienes material pendiente de revisar.
        <br>
        <small style="color: #6d7169;padding-top: 5px;">Haz click en el bot&oacute;n de bajo para ir revisarlo.</small>
    </p>
    <br>
    <a class="btn_revisar" style="
                    background-color: #00a65a;
                    border-color: #008d4c;
                    border-radius: 5px;
                    color: white;
                    display: inline-block;
                    font-size: 20px;
                    text-decoration: none;
                    padding: 10px 20px;
                    margin-top: 15px;;
        " href="{{asset('/admin/review/'.$data['status_id'].'/tracks')}}">Revisar</a>

    <div style="text-align: center;margin-top: 50px;">
        <span>
            <img src="{{ asset('/img/app/logo-baner-mail.png') }}" height="40px">
        </span>
    </div>
</div>