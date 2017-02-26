/**
 * Created by VictorDavid on 25/02/2017.
 */
var AdminServices = {

    get: {}
    ,
    set: {
        autorizeTrack: function (url, data, callback) {
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
                    Util.responseError(xhr);
                }
            });
        }
    }

};