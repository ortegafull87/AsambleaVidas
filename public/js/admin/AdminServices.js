/**
 * Created by VictorDavid on 25/02/2017.
 */
var AdminServices = {
    temps:{"content":null,"element":null},
    spinner:'<i id="_spinner" class="fa fa-refresh fa-spin fa-fw"></i>',
    get: {}
    ,
    set: {
        actualizarTrack: function (url, data, callback) {
            $.ajax({
                type: "POST",
                url: url,
                data: data
                ,
                complete: function (xhr) {
                    AdminServices.util.SpinerInButtonOff('btn_actualizar');
                    AdminServices.process.response(xhr, function (_xhr) {
                        callback(_xhr);
                    })
                }
                ,
                error: function (xhr) {
                    AdminServices.util.SpinerInButtonOff('btn_actualizar');
                    AdminServices.process.error(xhr);
                }
            });
        }
        ,
        autorizeTrack: function (url, data, callback) {
            $.ajax({
                type: "POST",
                url: url,
                data: data
                ,
                complete: function (xhr) {
                    AdminServices.util.SpinerInButtonOff('btn_autorizar');
                    AdminServices.process.response(xhr, function (_xhr) {
                        callback(_xhr);
                    })
                }
                ,
                error: function (xhr) {
                    AdminServices.util.SpinerInButtonOff('btn_autorizar');
                    AdminServices.process.error(xhr);
                }
            });
        }
        ,
        updateStatusTrack: function (url, data, callback) {
            $.ajax({
                type: "POST",
                url: url,
                data: data
                ,
                complete: function (xhr) {
                    AdminServices.util.hideSpinnerInElement();
                    AdminServices.process.response(xhr, function (_xhr) {
                        callback(_xhr);
                    })
                }
                ,
                error: function (xhr) {
                    AdminServices.util.hideSpinnerInElement();
                    AdminServices.process.error(xhr);
                }
            });
        }
    }
    ,
    process: {
        response: function (xhr, callback) {
            if (xhr.status >= 200 && xhr.status < 202) {
                console.log(xhr.responseJSON);
                callback(xhr);

            } else if (xhr.status >= 202 && xhr.status <= 210) {

                console.log(Messages.es.ERROR_UPDATED);
                console.log(xhr.responseJSON.error);
                Util.showAlert('alert-warning', xhr.responseJSON.message + xhr.responseJSON.error);

            }
        }
        ,
        error: function (xhr) {
            if (xhr.status === 500) {
                Util.showAlert('alert-danger', Messages.es.ERROR_500);
                console.log(xhr);

            } else if (xhr.status === 405) {
                Util.showAlert('alert-danger', xhr.statusText);
                console.log(xhr);

            } else if (typeof(xhr.responseText) === 'string') {

                console.debug(xhr);
                var response = JSON.parse(xhr.responseText);
                console.log(Messages.es.ERROR_UPDATED);
                console.log(response.error);
                Util.showAlert('alert-danger', response.message);

            } else {
                Util.showAlert('alert-warning', xhr.statusText);
                console.log(xhr);
            }
        }
    }
    ,
    util: {
        SpinerInButtonOn: function (id) {
            $('#' + id + ' i').removeClass('hidden');
            $('#' + id + ' span').addClass('hidden');
        }
        ,
        SpinerInButtonOff: function (id) {
            $('#' + id + ' i').addClass('hidden');
            $('#' + id + ' span').removeClass('hidden');
        }
        ,
        showSpinnerInElement:function(element){
            AdminServices.temps.content = $(element).html();
            AdminServices.temps.element = element;
            $(element).html(AdminServices.spinner);
        }
        ,
        hideSpinnerInElement:function(){
            $(AdminServices.temps.element).html(AdminServices.temps.content);
            AdminServices.temps.content=null;
            AdminServices.temps.element=null;
        }
    }

};