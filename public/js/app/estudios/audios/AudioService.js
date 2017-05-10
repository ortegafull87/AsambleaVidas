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
         * Agrega el track a favoritos
         * @param url
         * @param callback
         */
        favorite: function (url, callback) {
            /*$.post(url, function (data) {
             callback(data);
             });*/
            AudioService.ajax.post(url, {}, callback);
        }
        ,
        /**
         * Agrega un registro a la lista de listeneds
         * (Reproducidos)
         * @param url
         * @param callback
         */
        listened: function (url, callback) {
            $.post(url, function (data) {
                callback(data.message);
            });
        }
        ,
        /**
         * Crear un nuevo post
         * @param url
         * @param data
         * @param callback
         */
        post: function (url, data, callback) {
            AudioService.ajax.post(url, data, callback)
        }
        ,

        share: {
            /**
             * Solicita el servicio para compartir por correo un audio
             * @param url
             * @param data
             * @param callback
             */
            mail: function (url, data, callback) {
                AudioService.ajax.post(url, data, callback)
            }
        }

    }
    ,
    update: {
        /**
         * ACtualiza el cdomentario de un post
         * @param url
         * @param data
         * @param callback
         */
        post: function (url, data, callback) {
            AudioService.ajax.patch(url, data, callback);
        }
    }
    ,
    ajax: {
        get: {
            trakPerPage: function (page, callback) {
                _self.onSpinner('.track-box-container');
                var path = $('body').data('base');
                $.post(path + 'estudios/audios/perPage?page=' + page, function (xhr) {
                    _self.offSpinner();
                    callback(xhr);

                });
            }

        }
        ,
        post: function (url, data, callback) {
            $.ajax({
                type: "POST",
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
                            hideAfter: 6000
                        });//toast
                        console.info(xhr);
                    }
                }
            });
        }
        ,
        put: function () {

        }
        ,
        patch: function (url, data, callback) {
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
                            hideAfter: 6000
                        });//toast
                        console.info(xhr);
                    }
                }
            });
        }
        ,
        delete: function () {

        }
    }
    ,

};