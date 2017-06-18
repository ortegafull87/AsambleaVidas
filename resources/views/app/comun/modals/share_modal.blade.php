<div id="modal_share" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Compartir</h4>
            </div>
            <div class="modal-body">
                <!--<div class="app-instructions">
                    <span class="pull-right"><a class="fa fa-info-circle"></a></span>
                    <div class="info">
                        <p class="bg-primary text-left">
                            Puedes Ingresar un o más
                            correos, presiona
                            la tecela enter cuando termines cada uno. Para finalizar haz click en el boton
                            compartir
                        </p>
                    </div>
                </div>-->
                <div id="my_tabs" class="nav-tabs" style="border-bottom: 0;">
                    <ul class="nav nav-tabs hidden">
                        <li class=""><a href="#tab_menu" data-toggle="tab" aria-expanded="false"></a></li>
                        <li class=""><a href="#tab_frm_mail" data-toggle="tab" aria-expanded="false"></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active fade in active" id="tab_menu">
                            <ul class="app-v-list share-list">
                                <li data-link="envelope"><span class="fa fa-envelope fa-2x text-muted"></span><label>correo</label>
                                </li>
                                <li data-link="facebook"><span
                                            class="fa fa-facebook-square fa-2x text-light-blue"></span><label>facebook</label>
                                </li>
                                <li data-link="twitter"><span
                                            class="fa fa-twitter-square fa-2x text-aqua"></span><label>twitte</label>
                                </li>
                                <li data-link="google"><span
                                            class="fa fa-google-plus-square fa-2x text-red"></span><label>google
                                        +</label></li>
                            </ul>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane fade " id="tab_frm_mail">
                            <div class="instructions">
                                <p class="bg-primary text-left">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i> Puedes Ingresar uno o más
                                    correos, presiona
                                    la tecla Enter cuando termines cada uno. Para finalizar haz click en el boton
                                    compartir</p>
                            </div>
                            <br>
                            <div class="form-group btn-block text-left">
                                <label>Para: </label>
                                <textarea id="addressee" class="form-control" data-actiong="muiltitag"></textarea>
                                <div class="row" style="margin-top: 5px">
                                    <div class="col-sm-6">
                                        <button id="btn_cancel_share_mail" class="btn btn-default btn-block">Cancelar</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button id="do-share" class="btn btn-info btn-block"
                                                data-url="{{asset('estudios/audios/post/{id}/shareMail')}}"><span
                                                    class="fa fa-paper-plane"></span> Compartir
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->