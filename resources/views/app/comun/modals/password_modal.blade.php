<div id="modal_password" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span></button>
                <h4 class="modal-title">Cambio de contraseña</h4>
            </div>
            <div class="modal-body">
                <div class="instructions">
                    <p class="bg-primary">
                        <i class="fa fa-info-circle" aria-hidden="true"></i> Por tu seguridad necesitamos comprobar que
                        eres tu quien quiere hacer este cambio por lo que te pedimos los siguientes datos: </p>
                </div>
                <form id="frmUpdatePassword" action="{{asset('configuration/profile/updatePassword')}}">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Contraseña actual</label>
                        <input type="password" class="form-control" id="current_password" name="current_password"
                               placeholder="Escribe tu contraseña actual" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nueva contraseña</label>
                        <input type="password" class="form-control" id="new_password" name="new_password"
                               placeholder="Escribe tu nueva contraseña" minlength="6" required >
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirmaci&oacute;n</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                               placeholder="Confirma tu nueva contraseña" minlength="6" required>
                    </div>
                </form>
                <p class="text-muted hidden">La pr&oacutexima vez que inicies sesión ingresa con tu nueva
                    contraseña</p>
            </div>
            <div class="modal-footer">
                <button id="close_modal_passw" type="button" class="btn btn-default" data-dismiss="modal">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-info pull-right" form="frmUpdatePassword">Cambiar</button>
            </div>
        </div>
    </div>
</div>