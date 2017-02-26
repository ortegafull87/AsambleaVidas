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
                Util.openUrl($(object.target).data('url'));
            } else if (action === "activar") {
                _self.activar(object);
            }
        });

        /**
         * control para el boton cancelar
         */
        $(document).on('click','#btn_cancelar',function(object){
            var url = $(object.target).data('url');
            Util.openUrl(url);
        });

    }
    ,
    actualizar:function(){

    }
    ,
    autorizar:function(){

    }
    ,
    /**
     * Activa un audio
     * @param object
     */
    activar:function(object){
        var track_id = $(object.target).parents('tr').data('id');
        $.post('http://localhost:8000/admin/tracks/review/'+track_id+'/3/update',function(xhr){
            //var respond = JSON.parse(xhr);
            console.debug(xhr);
            Util.showAlert('alert-success', xhr.message);
        });
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