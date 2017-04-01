/**
 * Created by VictorDavid on 20/03/2017.
 */

var ProfileService = {
    get: {}
    ,
    set: {

        image: function (url, data, callback) {
            ProfileService._ajaxMultiPart(url, data, callback);
        }
        ,
        avatar: function (url, data, callback) {
            ProfileService._update(url, data, callback);
        }
        ,
    }
    ,
    update: {

        profile: function (url, data, callback) {
            ProfileService._update(url, data, callback);
        }
        ,
        updatePassword: function () {

        }
    }
    ,
    confirm: {
        image: function (url, data, callback) {
            ProfileService._update(url, data, callback);
        }
    }
    ,
    cancel:{
        image:function(url, data, callback){
            ProfileService._delete(url, data, callback)
        }
    }
    ,
    _update: function (url, data, callback) {
        $.ajax({
            type: "PATCH",
            url: url,
            data: data
            ,
            complete: function (xhr) {
                Util.response(xhr, callback);
            }
            ,
            error: function (xhr) {
                if (typeof(xhr.responseText) === 'string') {
                    Util.response(xhr, callback);
                } else {
                    $.toast({
                        heading: 'Ups! lo sentimos :(',
                        text: 'Tubimos un inconveninete',
                        position: 'mid-center',
                        stack: false,
                        icon: 'error',
                        hideAfter: 4000
                    });//toast
                    console.info(xhr);
                }
            }
        });
    }
    ,
    _ajaxMultiPart: function (url, data, callback) {
        $.ajax({
            url: url,
            data: data,
            type: 'POST',
            dataType: 'script',
            cache: false,
            contentType: false,
            processData: false,
            complete: function (xhr) {
                Util.response(xhr, callback);
            }
            ,
            error: function (xhr) {
                if (typeof(xhr.responseText) === 'string') {
                    Util.response(xhr, callback);
                } else {
                    $.toast({
                        heading: 'Ups! lo sentimos :(',
                        text: 'Tubimos un inconveninete',
                        position: 'mid-center',
                        stack: false,
                        icon: 'error',
                        hideAfter: 4000
                    });//toast
                    console.info(xhr);
                }
            }
        });
    }
    ,
    _delete: function (url, data, callback) {
        $.ajax({
            type: "DELETE",
            url: url,
            data: data
            ,
            complete: function (xhr) {
                Util.response(xhr, callback);
            }
            ,
            error: function (xhr) {
                if (typeof(xhr.responseText) === 'string') {
                    Util.response(xhr, callback);
                } else {
                    $.toast({
                        heading: 'Ups! lo sentimos :(',
                        text: 'Tubimos un inconveninete',
                        position: 'mid-center',
                        stack: false,
                        icon: 'error',
                        hideAfter: 4000
                    });//toast
                    console.info(xhr);
                }
            }
        });
    }

};
