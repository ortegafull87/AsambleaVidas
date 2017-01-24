/**
 * Created by VictorDavid on 12/01/2017.
 */
var AudioService = {

    set: {
        /**
         * Califica un track atraves del
         * metodo post.
         * @param url
         * @param callback
         */
        rate: function (url, callback) {
            $.post(url, function (data) {
                callback(data);
            });
        },
        /**
         * Agre el track a favoritos
         * @param url
         * @param callback
         */
        favorite: function (url, callback) {
            /*$.post(url, function (data) {
             callback(data);
             });*/
            AudioService.ajax.post(url, callback);
        }
    }
    ,
    ajax: {
        get: function () {

        }
        ,
        post: function (url, callback) {
            $.ajax({
                type: "POST",
                url: url
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
                            hideAfter: 6000
                        });//toast
                        console.info(xhr);
                    }
                }
            })
        }
        ,
        put: function () {

        }
        ,
        patch: function () {

        }
        ,
        delete: function () {

        }
    }
    ,

};