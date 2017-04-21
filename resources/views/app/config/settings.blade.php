<div class="active tab-pane" id="settings">
    <form id="frm_profile" action="{{asset('configuration/profile/setUpdate')}}" class="form-horizontal">
        <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Nombres</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputName" placeholder="[Primer nombre]  [Segundo nombre]"
                       value="{{$user->name}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Apellidos</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputLasName" placeholder="[Paterno]  [Materno]"
                       value="{{$user->last_name}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputNickName" class="col-sm-2 control-label">Apodo</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="inputNickName" placeholder="¿Como te gusta que te llamen?"
                       value="{{$user->nick_name}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword" class="col-sm-2 control-label">Contraseña</label>
            <div class="col-sm-10">
                <a id="mod_pass" href="#" class="app-link">Cambiar mi contraseña</a>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" name="inputEmail" placeholder="micorreo@email.com"
                       value="{{$user->email}}">
            </div>
        </div>
        <div class="form-group hidden">
            <label for="inputEmail" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
                <input type="email" class="form-control" name="inputConfirmEmail" placeholder="Confirma tu correo">
            </div>
        </div>
        <div class="form-group">
            <label for="sltGandle" class="col-sm-2 control-label">Sexo</label>
            <div class="col-sm-10">
                <select class="form-control" name="sltGandle">
                    <option value="X" {{($user->gandle == 'X')?"selected":""}}>Selecciona tu sexo</option>
                    <option value="M" {{($user->gandle == 'M')?"selected":""}}>Masculino</option>
                    <option value="F" {{($user->gandle == 'F')?"selected":""}}>Femenino</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputBirthday" class="col-sm-2 control-label">Nacimiento</label>
            <div class="col-sm-10">
                <!--<input id="datemask" type="text" class="form-control" name="inputBirthday"  value="{{$user->birthday}}">-->
                <input id="datemask" type="text" class="form-control" name="inputBirthday"  value="{{ date('d/m/Y',strtotime($user->birthday)) }}">
            </div>
        </div>
        <!--<div class="form-group">
            <label for="inputBirthday" class="col-sm-2 control-label">Ubicaci&oacute;n</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="inputContry" placeholder="Selecciona tu pais" value="">
            </div>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="inputProvince" placeholder="Selecciona tu estado" value="">
            </div>
            <div class="col-sm-1">
                <button class="btn btn-default">
                    <i class="fa fa-map-marker"></i>
                </button>
            </div>
        </div>-->

        <br>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-info">Guardar</button>
            </div>
        </div>
    </form>
</div>
<!-- /.tab-pane -->