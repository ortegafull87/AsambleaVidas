var jsmediatags = window.jsmediatags;
var NewTrack = {
    self: null,
    MAX_FILE_SIZE_UPLOAD: 42,
    _init: function () {
        Util.setActiveSideMenu('admin/tracks/create');
        self = NewTrack;
        self.events();
        self.uploadTrackAction('#pg_bar_track');
    }
    ,
    events: function () {

        self.loadFile();

        $(document).on('click', 'a', function () {

            if ($(this).data('action') === 'clear-form') {
                $('#up').trigger('reset');
            }

        });
    }
    ,
    loadFile: function () {
        var span = document.getElementsByClassName('upload-path');
        var uploader = document.getElementsByName('file');
        for (item in uploader) {
            uploader[item].onchange = function () {
                span[0].innerHTML = this.files[0].name + "<br>" + Util.parseToMB(this.files[0].size) + " Mb";
                jsmediatags.read(this.files[0], {
                    onSuccess: function (tag) {
                        console.log(tag);
                    },
                    onError: function (error) {
                        console.log(':(', error.type, error.info);
                    }
                });
            }
        }
    }
    ,
    uploadTrackAction: function (id_MainBar) {
        var mainBar = $(id_MainBar);
        var btnSubmit = $("#btn_submit_track");
        var bar = mainBar.find('div[role="progressbar"]');
        var label = bar.find('span');
        var started_at = new Date();
        mainBar.hide();
        $('#up').ajaxForm({
            beforeSubmit: function (arr) {
                var file = arr[5];
                // verificar si el archivo ha sido seleccionado
                if (typeof(file.value) === 'string') {
                    Util.showAlert('alert-info', Messages.es.NO_FILE);
                    return false;
                }

                //verificando el tamaño del archivo
                var sizeFile = (file.value.size / (1024 * 1024)).toFixed(2);
                if (sizeFile > NewTrack.MAX_FILE_SIZE_UPLOAD) {
                    Util.showAlert('alert-info', Messages.es.FILE_SIZE);
                    return false;
                }
                // verificando el formato del archivo.
                console.debug(file.value.type);
                if (file.value.type !== "audio/mp3") {
                    Util.showAlert('alert-info', Messages.es.FILE_FORMAT);
                    return false;
                }

            },
            beforeSend: function (xhr) {
                $('#abort-upload').removeClass('hide');
                $('#abort-upload').click(function () {
                    xhr.abort();
                });
                mainBar.show();
                btnSubmit.hide();
                label.toggleClass('sr-only');
                var percentVal = '0%';
                bar.css({'width': percentVal});

            },
            uploadProgress: function (event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.css({'width': percentVal});
                label.html(percentVal);

                var _total = Util.parseToMB(total);
                var _toComplete = Util.parseToMB(position);
                var infoUpLoad = Util.getInfoAjaxUpLoad(started_at, position, total);

                $('#upload-info > div').eq(0).find('span').html(_toComplete + ' Mb');//completado
                $('#upload-info > div').eq(1).find('span').html(_total + " Mb");//total
                $('#upload-info > div').eq(2).find('span').html(infoUpLoad.Kbytes_per_second + " Kb/s");//total
                $('#upload-info > div').eq(3).find('span').html(infoUpLoad.left_time + infoUpLoad.name_time + ' Restantes.');//tiempo estimado
            },
            success: function () {
                var percentVal = '100%';
                bar.css({'width': percentVal});
                label.html(percentVal);

            },
            complete: function (xhr) {
                mainBar.hide();
                btnSubmit.show();
                $('#abort-upload').addClass('hide')
                if (xhr.status >= 200 && xhr.status <= 202) {
                    Util.showAlert('alert-success', xhr.responseJSON.message);
                    $("#up").trigger('reset');
                    $(document.getElementsByClassName('upload-path')).html('');
                } else if (xhr.status >= 204 && xhr.status <= 210) {
                    Util.showAlert('alert-warning', xhr.responseJSON.message);
                    $("#up").trigger('reset');
                    $(document.getElementsByClassName('upload-path')).html('');
                }
            }
            ,
            error: function (xhr) {
                console.debug(xhr);
                mainBar.hide();
                btnSubmit.show();

                if (typeof(xhr.responseText) === 'string') {
                    var error = JSON.parse(xhr.responseText);
                    Util.showAlert('alert-danger', error.message);
                } else {
                    Util.showAlert('alert-danger', xhr.statusText);
                }
            }
        });
    }
};
$(document).ready(NewTrack._init);