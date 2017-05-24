/**
 * Created by VictorDavid on 15/01/2017.
 */
var CONSTANTS = {
    SPINNER_1X: '<i class="fa fa-refresh fa-spin fa-fw"></i>',
    SPINNER_2X: '<i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>',
    SPINNER_3X: '<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>'
};

var auxes={};

var Util = {

    _init: function () {

    }
    ,
    response: function (xhr, callback) {
        if (xhr.responseText.indexOf('TokenMismatchException') === -1) {
            var response = JSON.parse(xhr.responseText);
            if (xhr.status >= 200 && xhr.status <= 202) {
                callback(xhr);
            } else if (xhr.status == 403) {
                $.toast({
                    heading: '',
                    text: response.message + '<div class="centered"></div><button class="registrar btn btn-info"> Registrarme </button>  <a href="/login">Iniciar sesión</a></div>',
                    position: 'mid-center',
                    stack: false,
                    icon: 'warning',
                    hideAfter: 8000
                });//toast
            } else if (xhr.status == 500) {
                $.toast({
                    heading: '',
                    text: response.message,
                    position: 'mid-center',
                    stack: false,
                    icon: 'error',
                    hideAfter: 6000
                });//toast
                console.info(response.error);
            } else {
                $.toast({
                    heading: 'Ups! lo sentimos :(',
                    text: 'Tubimos un inconveninete',
                    position: 'mid-center',
                    stack: false,
                    icon: 'error',
                    hideAfter: 6000
                });//toast
                console.info(xhr);
            }
        } else {
            $.toast({
                heading: 'Tu sesi&oacute;n ha terminao',
                text: '<div class="centered"></div><button class="registrar btn btn-info"> Registrarme </button>  <a href="/login">Iniciar sesión</a></div>',
                position: 'mid-center',
                stack: false,
                icon: 'info',
                hideAfter: 8000
            });//toast
        }
    }
    ,
    responseError: function (xhr) {
        if (typeof(xhr.responseText) === 'string') {
            Util.response(xhr, callback);
        } else {
            $.toast({
                heading: 'Ups! lo sentimos :(',
                text: 'Tubimos un inconveninete',
                position: 'mid-center',
                stack: false,
                icon: 'error',
                hideAfter: 6000
            });//toast
            console.debug(xhr);
        }
    }
    ,
    /**
     *
     * @param id
     * @param html
     */
    insertPost: function (html) {
        $('.post').prepend(html);
    }
    ,
    /**
     * Abre una url dada en la pagina actual
     * @param url
     */
    openUrl: function (url) {
        window.location.href = url;
    }
    ,
    spinner: {
        _button: {
            text: null,

            on: function (selector) {
                var _aux = Util.encript(selector);

                auxes[_aux] = $(selector).html();
                var w = $(selector).width();
                $(selector).width(w+'px');
                $(selector).html(CONSTANTS.SPINNER_1X);
            }
            ,
            off: function (selector) {
                var _aux = Util.encript(selector);
                $(selector).html(auxes[_aux]);
                delete auxes[_aux];
            }
        }
    }
    ,
    encript:function(str){
        return $.md5(str);
    }
};

/**
 * Animate.css
 */
$.fn.extend({
    animateCss: function (animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        this.addClass('animated ' + animationName).one(animationEnd, function() {
            $(this).removeClass('animated ' + animationName);
        });
    }
});

$(document).ready(Util._init);