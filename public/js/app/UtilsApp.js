/**
 * Created by VictorDavid on 15/01/2017.
 */
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
        $('.comments').prepend(html);
    }
    ,
    /**
     * Abre una url dada en la pagina actual
     * @param url
     */
    openUrl: function (url) {
        window.location.href = url;
    }
};
$(document).ready(Util._init);