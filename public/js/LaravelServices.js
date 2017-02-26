var LaravelServices = {
    TYPES: {
        GET: "GET",
        POST: "POST",
        PUT: "PUT",
        PATCH: "PATCH",
        DELETE: "DELETE",
    },
    ajax: {
        GET: function (url, data, callback) {
        }
        ,
        POST: function (url, data, callback) {
        }
        ,
        PATCH: function (url, data, callback) {
        }
        ,
        PUT: function (url, data, callback) {
        }
        ,
        DELETE: function (url, data, callback) {
        }
    }
    ,
    jquery_ajax: function (type, url, data, callback) {
        $.ajax({
            type: type,
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
        })
    }
};
