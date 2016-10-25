var jsmediatags = window.jsmediatags;
var EditTrack = {
    init: function () {
        $(".audio").mb_miniPlayer();
        EditTrack.loadFile();
        EditTrack.uploadTrackAction('#pg_bar_track');
        EditTrack.listeners();
    },
    listeners: function () {
        $('#btn_regresar').on('click', function () {
            window.location.href = '/admin/tracks';
        });
        $('#btn_cancelar').on('click', function () {
            window.location.href = '/admin/tracks';
        });
    },
    loadFile: function () {
        var span = document.getElementsByClassName('upload-path');
        var uploader = document.getElementsByName('file');
        for (item in uploader) {
            uploader[item].onchange = function () {
                span[0].innerHTML = this.files[0].name + "<br>" + Util.parseToMB(this.files[0].size) + " Mb";
                console.debug(this.files[0]);
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
        var btnSubmit = $("#btn_submit_update");
        var btnRegresar = $('#btn_regresar');
        var btnCancelar = $('#btn_cancelar');
        var bar = mainBar.find('div[role="progressbar"]');
        var label = bar.find('span');
        var started_at = new Date();
        mainBar.hide();

        $('#edit').ajaxForm({
            beforeSubmit: function (arr) {
                var file = arr[5];

                //verificando el tamaño del archivo
                var file = document.getElementsByName('file');
                if (typeof(file.value) === 'string') {
                    var sizeFile = (file.value.size / (1024 * 1024)).toFixed(2);
                    if (sizeFile > Track.MAX_FILE_SIZE_UPLOAD) {
                        Util.showAlert('alert-warning', Messages.es.FILE_SIZE);
                        console.debug(sizeFile + 'MB');
                        return false;
                    }
                }

            },
            beforeSend: function (xhr) {

                $('#abort-upload').removeClass('hide');
                $('#abort-upload').click(function () {
                    xhr.abort();
                });

                mainBar.show();
                btnSubmit.hide();
                btnCancelar.hide();
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
                $('#abort-upload').addClass('hide')
                mainBar.hide();
                btnRegresar.show();
                var message = xhr.responseJSON.message;
                console.debug(message);
                if (xhr.status >= 200 && xhr.status <= 201) {
                    Util.showAlert('alert-success', xhr.responseJSON.message);
                    $("#up").trigger('reset');
                    $(document.getElementsByClassName('upload-path')).html('');
                } else if (xhr.status >= 202 && xhr.status <= 210) {
                    Util.showAlert('alert-warning', xhr.responseJSON.message + xhr.responseJSON.error);
                    $("#up").trigger('reset');
                    $(document.getElementsByClassName('upload-path')).html('');
                }
            }
            ,
            error: function (xhr) {
                mainBar.hide();
                btnSubmit.show();
                btnCancelar.show();
                btnRegresar.hide();
                console.log(xhr);
                $('#abort-upload').addClass('hide')
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
$(document).ready(EditTrack.init);