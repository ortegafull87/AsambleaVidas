var Util = {
    URL_BASE: location.origin = location.protocol + "//" + location.host + "/",
    self: null,
    _init: function () {
        self = Util;
    }
    ,
    /**
     * [showAlert description]
     * @param  {[type]}   object   [description]
     * @param  {[type]}   type     [description]
     * @param  {[type]}   title    [description]
     * @param  {[type]}   message  [description]
     * @param  {Function} callback [description]
     * @return {[type]}            [description]
     */
    showAlertPopUp: function (object, type, title, message, callback) {
        swal({
            title: title,
            text: message,
            type: type
        }).then(function () {
            if (callback !== undefined) {
                callback(object);
            }

        });
    }
    ,
    showAlert: function (classe, message) {

        $('.alert').fadeOut("fast");
        $('.alert').find('span').html();

        var alerta = $('.' + classe);
        var msg = alerta.find('span');

        msg.html(message);
        alerta.fadeIn("fast");

    }
    ,
    /**classe
     * Obtiene el id de uno o varios checkbox checados
     * si se le pasa el segundo parametro como true
     * este devolvera un array solo con los id numericos,
     * si no se le pasa el segundo argumento
     * por default devolvera un array con el id completo
     * @param  {[String]}        nameObject   [description]
     * @param  {[boolean]}    justIdNumber [description]
     * @return {[Array]}                 [description]
     */
    getCheckeds: function (nameObject, justIdNumber) {
        var checkGroup = $('input[name="' + nameObject + '"]');
        var arrayGruop = [];
        $.each(checkGroup, function (i, track) {
            if ($(track).is(':checked')) {
                var id = $(track).attr('id');
                if (justIdNumber === undefined || justIdNumber === false) {
                    arrayGruop.push(id);
                } else {
                    console.debug("justIdNumber");
                    var idSplit = id.split('_');
                    arrayGruop.push(idSplit[idSplit.length - 1]);
                }
            }
        });
        return arrayGruop;
    }
    ,
    /**
     * Conbierte bytes a MB
     * @param  {[type]} bytess [description]
     * @return {[type]}        [description]
     */
    parseToMB: function (bytess) {
        if (bytess !== undefined && bytess > 0) {
            return (bytess / (1024 * 1024)).toFixed(2);
        } else {
            return 0;
        }
    }
    ,
    setCheckBoxStyle: function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });
    }
    ,
    /**
     * Calcula el tiempo restante y la tasa de tranferencia de una
     * carga ajax.
     * @param started_at
     * @param position
     * @param total
     * @returns {{left_time: string, name_time: string, Kbytes_per_second: string}}
     */
    getInfoAjaxUpLoad: function (started_at, position, total) {

        var seconds_elapsed = ( new Date().getTime() - started_at.getTime() ) / 1000;
        var bytes_per_second = seconds_elapsed ? position / seconds_elapsed : 0;
        var Kbytes_per_second = bytes_per_second / 1000;
        var remaining_bytes = total - position;
        var seconds_remaining = seconds_elapsed ? remaining_bytes / bytes_per_second : 'calculating...';
        var left_time = (seconds_remaining > 60) ? seconds_remaining / 60 : seconds_remaining;
        var name_time = (seconds_remaining > 60) ? 'Min.' : 'Seg.';

        return {
            "left_time": left_time.toFixed(1),
            "name_time": name_time,
            "Kbytes_per_second": Kbytes_per_second.toFixed(1)
        }
    }
    ,
    /**
     * Resalta el menu aside que ha sido seleccionado.
     * @param {type} link
     * @returns {undefined}
     */
    setActiveSideMenu: function (link) {
        $('section.sidebar > ul').find('li > a[href="' + self.URL_BASE + link + '"]')
            .parent()
            .addClass('active')
            .closest('.treeview')
            .addClass('active');
    }
    ,
    /**
     * Obtiene la altura de la ventana actual
     * @returns {*|jQuery}
     */
    getHeightFromWindow: function () {
        return $(window).height();
    }
    ,
    /**
     *
     * @param title
     * @param msj
     * @param cb_ok
     * @param cb_cancel
     */
    confirm: function (obj, title, cb_ok, cb_cancel) {
        (new PNotify({
            title: title, //'Confirmation Needed',
            text: '¿Desea continuar?',
            icon: 'glyphicon glyphicon-question-sign',
            hide: false,
            confirm: {
                confirm: true
            },
            buttons: {
                closer: false,
                sticker: false
            },
            history: {
                history: false
            }
        })).get().on('pnotify.confirm', function () {
            if (obj === undefined) {
                cb_ok();
            } else {
                cb_ok(obj);
            }
        }).on('pnotify.cancel', function () {
            if (cb_cancel !== undefined) {
                if (obj === undefined) {
                    cb_cancel();
                } else {
                    cb_cancel(obj);
                }
            }
        });
    }


};
$(document).ready(Util._init);