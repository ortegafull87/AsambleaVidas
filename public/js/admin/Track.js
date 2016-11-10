var Track = {

    _init: function () {
        Util.setActiveSideMenu('admin/tracks');
        Track.resizeContents();
        $('body').on('click', 'a', Track.tracksFormActions);
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });
        $('.abort-upload').hi;
        $(".audio").mb_miniPlayer();

    }
    ,
    resizeContents: function () {
        var dif = 240;
        var wh = $(window).height();
        var ventana_H = wh - dif;
        $('#cont_tracks').slimScroll({
            height: ventana_H + 'px'
        });
    }
    ,
    tracksFormActions: function (e) {

        if ($(e.target).data('action') === 'clear-form-new-track') {
            e.preventDefault();
            $("#up").trigger('reset');
            $(document.getElementsByClassName('upload-path')).html('');
        }
        if ($(e.target).data('action') === 'delete-some-track') {
            console.log('delete-some-track...');
            var tracks = Util.getCheckeds('tracks', true);
            if (tracks.length > 0) {
                Track.deleteTrack(tracks);
            } else {
                Util.showAlert(null, 'warning', Messages.es.WARNING, Messages.es.NO_CHECKED);
            }
        }

        if ($(e.target).data('action') === 'delete-all-track') {
            console.log('delete-all-track...');
            Track.deleteTrack('-1');
        }

        if ($(e.target).data('action') === 'properties-track') {
            console.log('properties-track..');
        }

    }
    ,
    deleteTrack: function (params) {
        $.ajax({
            type: "DELETE",
            url: "/admin/tracks/" + params,
            data: {_token: $('#token').val()},
            complete: function (xhr) {

                if (xhr.status >= 200 && xhr.status < 202) {
                    console.log(xhr.responseJSON);
                    Util.showAlert('alert-success', xhr.responseJSON.message);
                    for(var item in xhr.responseJSON.data){
                        // Se eliminan las pistas seleccionadas
                        $('tr#'+xhr.responseJSON.data[item]).fadeOut();
                    }

                } else if (xhr.status >= 202 && xhr.status <= 210) {

                    console.log(Messages.es.ERROR_UPDATED);
                    console.log(xhr.responseJSON.error);
                    Util.showAlert('alert-warning', xhr.responseJSON.message + xhr.responseJSON.error);

                }
            }
            ,
            error: function (xhr) {

                if(xhr.status === 500){

                    Util.showAlert('alert-danger', Messages.es.ERROR_500);
                    console.log(xhr);

                }else if (typeof(xhr.responseText) === 'string') {
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

        })
    }

};
$(document).ready(Track._init);
