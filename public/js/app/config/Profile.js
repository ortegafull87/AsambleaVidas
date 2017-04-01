/**
 * Created by VictorDavid on 20/03/2017.
 */
var Profile = {

    MESSAGES:{
        CONFIRM:'As&iacute; se ver&aacute; tu foto de ferfil en todo el sitio'
    }
    ,
    sppiner: 'fa fa-refresh fa-spin fa-2x fa-fw',
    iconUpload: 'fa fa-cloud-upload fa-2x',
    imageTemp: ""
    /**
     * Init
     */
    ,
    init: function () {
        Profile.events();
    }
    ,
    /**
     * Eventos generales de la pantalla de perfil
     */
    events: function () {

        $(document).on('click', 'button[data-dismiss="modal"]', function () {
            Profile.resetForm();
        });

        $(document).on('submit', 'form#frm_profile', function (object) {
            object.preventDefault();
            var url = $(object.target).attr('action');
            var data = $(this).serialize();
            ProfileService.update.profile(url, data, Profile.postSubmit);
        });

        /**
         * Listener para el boton Editar Imagen de perfil
         */
        $(document).on('click', '.btn-update-image', function () {
            $('#modal_image').modal();
        });

        /**
         * Trigger para la selección de una imagen desde un pc
         */
        $(document).on('click', 'button.upload', function (object) {
            $('#ImageBrows').trigger('click');
        });

        /**
         * Trigger para el boton que abre el explorador
         * para subir una imagen al servidor.
         */
        $(document).on('change', '#ImageBrows', function (onj) {
            var file = $("#ImageBrows").prop("files");
            upload(file);
        });

        /**
         * Resetea el formulario.
         */
        $(document).on('click', 'button.cancel', function () {
            Profile.resetForm();
        });

        $('#dropZone').on(
            'dragover',
            function (e) {
                e.preventDefault();
                e.stopPropagation();
                $('#dropZone').addClass('dragg-over');
            }
        )
        $('#dropZone').on(
            'dragleave',
            function (e) {
                e.preventDefault();
                e.stopPropagation();
                $('#dropZone').removeClass('dragg-over');
            }
        )
        $('#dropZone').on(
            'dragenter',
            function (e) {
                e.preventDefault();
                e.stopPropagation();
            }
        )
        $('#dropZone').on(
            'drop',
            function (e) {
                $('#dropZone').removeClass('dragg-over');
                if (e.originalEvent.dataTransfer) {
                    if (e.originalEvent.dataTransfer.files.length) {
                        e.preventDefault();
                        e.stopPropagation();
                        upload(e.originalEvent.dataTransfer.files);
                    }
                }
            }
        );
        /**
         * Accion para subir una imagen
         * @param files
         */
        function upload(files) {
            $('#spinner_img_profile').attr('class', Profile.sppiner);
            var url = $('#frm_up_profile_image').attr('action');
            Profile.imageTemp = $('#image_preview').attr('src');
            var data = new FormData();
            data.append("ImageBrows", files[0]);
            data.append('_method', 'patch');
            data.append('MAX_FILE_SIZE', '1000000');
            ProfileService.set.image(url, data, function (xhr) {
                var response = JSON.parse(xhr.responseText);
                Profile.previewImage(response.data);
                Profile.showFormConfirmView('brows');
            });
        }


        /**
         * Listener que selecciona un avatar de una lista.
         */
        $(document).on('click', '.select-avatar ul li', function (object) {
            var preview_avatar = $(object.target).attr('src');
            Profile.imageTemp = $('#image_preview').attr('src');
            Profile.previewImage(preview_avatar);
            Profile.showFormConfirmView('avatar');
        });

        /**
         * Listener que confirma la seleccion de un avatar
         */
        $(document).on('click', 'button.done-av', function () {
            Profile.setAvatarAsImage();
        });

        /**
         * Listener que confirma la seleccion de un avatar
         */
        $(document).on('click', 'button.done-br', function () {
            Profile.setFilaBrowsAsImage();
        });
    }
    ,
    /**
     * Asigna una archivo como imagen
     */
    setFilaBrowsAsImage: function () {
        var conf_image = $('#image_preview').attr('src');
        var url = $('.upload-image').data('url-confirm');
        conf_image = Profile.parseUrlImage(conf_image);
        $('p.msj').html('<span class="'+Profile.sppiner+'"></span>');
        ProfileService.confirm.image(url, {'conf_img': conf_image}, Profile.applyChanges);
    }
    ,
    /**
     *Asigna un avatar como imagen
     */
    setAvatarAsImage: function () {
        var new_avatar = $('#image_preview').attr('src');
        var url = $('.select-avatar ul').data('url');
        new_avatar = Profile.parseUrlImage(new_avatar);
        $('p.msj').html('<span class="'+Profile.sppiner+'"></span>');
        ProfileService.set.avatar(url, {'avatar': new_avatar}, Profile.applyChanges);
    }
    ,
    /**
     * Actualiza la imagen de perfile en las pantallas
     * donde aparece la misma.
     * @param src
     */
    changeImageInDom: function (img) {
        $('#image_preview').attr('src', img);
        $('#image_profile').attr('src', img);
        $('#image_profile_bar').attr('src', img);
        $('#image_profile_menu').attr('src', img);
    }

    ,
    /**
     * Muestra mensaje Toast despues de una petición ajax.
     * @private
     */
    postSubmit: function (xhr) {
        var response = JSON.parse(xhr.responseText);
        $.toast({
            text: response.message,
            position: 'mid-center',
            stack: false,
            icon: 'info',
            hideAfter: 3000,
            loader: false,
        });
    }
    ,
    /**
     * Resetea el formulario a su estado original
     */
    resetForm: function () {
        $('#spinner_img_profile').attr('class', Profile.iconUpload);
        $('#image_preview').attr('src', Profile.imageTemp);
        $('#dropZone').removeClass('dropped');
        $('.select-avatar').slideDown('fast');
        $('.close-modal-img').show();
        $('.controls .msj').html();
        $('p.msj').hide();
        Profile.cancelUpdateImage();
    }
    ,
    /**
     * Separa la imagen de una cadea url
     * @param url
     * @returns {*}
     */
    parseUrlImage: function (url) {
        if (url !== '') {
            return url.substring(url.indexOf('/img/') + 5, url.length);
        } else {
            return null;
        }
    }
    ,
    /**
     * Muestra una vista previa de como se veria
     * la imagen seleccionada.
     */
    previewImage: function (preview) {
        $('#image_preview').attr('src', preview);
    }
    ,
    /**
     * Muestra las opsiones de confirmación
     * deacuerdo con la imagen seleccionada.
     * @param type
     */
    showFormConfirmView: function (type) {
        if (type === 'avatar') {
            $('#btn_done').removeClass('done-br');
            $('#btn_done').addClass('done-av');
        } else if (type === 'brows') {
            $('#btn_done').removeClass('done-av');
            $('#btn_done').addClass('done-br');
        }
        $('.controls .msj').html(Profile.MESSAGES.CONFIRM);
        $('#close_modal_img').hide();
        $('p.msj').show();
        $('#dropZone').addClass('dropped');
        $('.select-avatar').slideUp('fast');
    }
    ,
    /**
     * Aplica los cambios definitivos en una actualización
     * de imagen de perfil
     * @param xhr
     */
    applyChanges: function (xhr) {
        var response = JSON.parse(xhr.responseText);
        Profile.changeImageInDom(response.data);
        Profile.imageTemp = response.data;
        Profile.resetForm();
        setTimeout(function () {
            $('#image_preview').addClass('animated bounceIn');
            setTimeout(function () {
                $('#image_preview').removeClass('animated bounceIn');
            }, 500);
        }, 800);
    }
    ,
    /**
     * Cancela una actualización
     */
    cancelUpdateImage: function () {
        var url = $('body').data('base') + 'configuration/profile/cancelImage';
        ProfileService.cancel.image(url, {}, function () {
        });
    }

};
$(document).ready(Profile.init);
