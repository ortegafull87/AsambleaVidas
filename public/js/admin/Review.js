/**
 * Created by VictorDavid on 26/02/2017.
 */
var Review = {

    _self: null
    ,
    /**
     * Funcion de inicialización
     */
    _init: function () {
        $('#input_search_main_admin').remove();
        Util.setActiveSideMenu('admin/review');
        _self = Review;
        _self.resizeContents();
        _self.events();
    }
    ,

    /**
     * Listener de eventos generados en la DOM
     */
    events: function () {

        /**
         * Control para los botones que filtran los estados de audio.
         */
        $(document).on('click', 'td.review_action button', function (object) {
            var action = $(object.target).data('action');
            if (action === "revisar" || action === "actualizar") {
                AdminServices.util.showSpinnerInElement(object.target);
                Util.openUrl($(object.target).data('url'));
            } else if (action === "update") {
                _self.update(object);
            }
        });

        /**
         * control para el boton cancelar
         */
        $(document).on('click', '#btn_cancelar', function (object) {
            var url = $(object.target).data('url');
            Util.openUrl(url);
        });

        /**
         * listener para la accion del boton actualizar
         */
        $(document).on('click', '#btn_actualizar', function (object) {
            _self.actualizar(object);
        });

        /**
         * Listener para la accion del boton autorizar
         */
        $(document).on('click', '#btn_autorizar', function (object) {
            _self.autorizar(object);
        });

        //SmartFinder
        $('#finder_track').bootcomplete({
            url:$('body').data('url') + 'smart/finder/findTracks',
            method:'post',
            minLength:2,
            afterClick:function(object){
                var url_link = $('input#finder_track').data('url');
                url_link = url_link.replace(':id',$(object).data('id'));
                Util.openUrl(url_link);
            },
        });

    }
    ,
    /**
     * Actualiza la informacion faltante despues de que
     * se agrega por primera vez un track
     * sketch, descripcion
     * @param object
     */
    actualizar: function (object) {
        var url = $(object.target).data('url');
        var data = {
            //"trk_title": $.trim($('#trk_titulo').val()),
            "documentacion": CKEDITOR.instances.documentacion.getData()
        };
        AdminServices.util.SpinerInButtonOn('btn_actualizar');
        AdminServices.set.actualizarTrack(url, data, function (xhr) {
            Util.showAlert('alert-success', xhr.responseJSON.message);
            $('#btn_cancelar').html("<i class='fa fa-arrow-left' aria-hidden='true'></i> Regresar");
        })
    }
    ,
    /**
     * Autoriza y actualiza un track para su visualización
     * en producción.
     * @param object
     */
    autorizar: function (object) {
        var url = $(object.target).data('url');
        var data = {
            //"trk_title": $.trim($('#trk_titulo').val()),
            "documentacion": CKEDITOR.instances.documentacion.getData()
        };
        AdminServices.util.SpinerInButtonOn('btn_autorizar');
        AdminServices.set.autorizeTrack(url, data, function (xhr) {
            Util.showAlert('alert-success', xhr.responseJSON.message);
            $('#btn_cancelar').html("<i class='fa fa-arrow-left' aria-hidden='true'></i> Regresar");
            _self.toggleSpinerInButton('btn_autorizar');
        })
    }
    ,
    /**
     * Actualiza el estatus de un track
     * @param object
     */
    update: function (object) {
        var url = $(object.target).data('url');
        AdminServices.util.showSpinnerInElement(object.target);
        AdminServices.set.updateStatusTrack(url, {}, function (xhr) {
            //Util.showAlert('alert-success', xhr.message);

            $(object.target).parents('tr').fadeOut('fast');
            _self.incressAmoungFilter($(object.target).data('idst'));
            //Make animation


        });
    }
    ,
    incressAmoungFilter: function (id) {
        var element = '#pd_' + id;
        var amoung = parseInt($('#pd_' + id).html());
        setTimeout(function () {
            $(element).addClass('animated bounceIn');
            $(element).html(1 + amoung);
            setTimeout(function () {
                $(element).removeClass('animated bounceIn');
            }, 500);
        }, 1000);

    }
    ,
    /**
     * Le proporciona un alto a la caja de los tracks
     * deacuerdo al tamaño y resulución de la pantalla.
     */
    resizeContents: function () {
        var dif = 300;
        var wh = $(window).height();
        var ventana_H = wh - dif;
        $('#cont_tracks').slimScroll({
            height: ventana_H + 'px'
        });
    }
};

$(document).ready(Review._init);