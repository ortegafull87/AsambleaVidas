/**
 * Created by VictorDavid on 15/01/2017.
 */
var Util = {
    _init: function () {

    }
    ,
    response: function (xhr, callback) {
        var response = JSON.parse(xhr.responseText);
        if (xhr.status >= 200 && xhr.status <= 202) {
            callback(xhr);
        } else if (xhr.status == 403) {
            $.toast({
                heading: '',
                text: response.message + '<div class="centered"></div><button class="registrar btn btn-info"> Registrarme </button></div>',
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
    }
    ,
    responseError:function(xhr){
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
            console.info(xhr);
        }
    }
    ,
    /**
     * 
     * @param id
     * @param html
     */
    insertPost:function(html){
        $('.comments').prepend(html);
    }
};
$(document).ready(Util._init);