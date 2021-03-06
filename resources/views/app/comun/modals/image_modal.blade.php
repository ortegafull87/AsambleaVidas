<div id="modal_image" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span></button>
                <h4 class="modal-title">Imagen de perfil</h4>
            </div>
            <div class="modal-body">
                <div class="preview-image">
                    <img id="image_preview" class="profile-user-img img-responsive img-circle" height="100" width="100"
                         data-url="{{asset('').env('URL_BASE_IMGS')}}"
                         src="{{ asset('').env('URL_BASE_IMGS').((empty($user->image))?'no-image-profile.png':$user->image)}}"
                         alt="User profile picture">
                </div>
                <div class="upload-image" data-url-confirm="{{asset('configuration/profile/confirmImageBrows')}}">
                    <div id="dropZone" class="dropZone">
                        <form id="frm_up_profile_image" action="{{asset('configuration/profile/setImageBrows')}}"
                              method="post"
                              enctype="multipart/form-data" onsubmit="return false;">
                            <div class="labels">
                                <p><span id="spinner_img_profile" class="fa fa-cloud-upload fa-2x"></span></p>
                                <p id="p_up_profile_image">arrastra una imagen aqu&iacute;</p>
                                <label>ó</label>
                            </div>
                            <div class="controls">
                                <p class="msj"></p>
                                <input type="file" id="ImageBrows" name="ImageBrows" class="hidden">
                                <button class="btn btn-primary upload">busca en tu PC</button>
                                <button class="btn btn-link cancel">Intentar con otra imagen</button>
                                <button id="btn_done" class="btn btn-info">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="select-avatar">
                    <div class="instructions">
                        <p class="bg-primary">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            Si lo prefieres, puedes seleccionar un avatar de acuerdo a tu personalidad
                        </p>
                    </div>
                    <ul data-url="{{asset('configuration/profile/setAvatar')}}">
                        @foreach($avatars as $url_avatar)
                            <li><img src="{{asset($url_avatar)}}" height="50"
                                     data-avatar="{{str_replace(env('URL_BASE_IMGS'),'',$url_avatar)}}"></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!--<div class="modal-footer">
                <button id="close_modal_img" type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
            </div>-->
        </div>
    </div>
</div>
