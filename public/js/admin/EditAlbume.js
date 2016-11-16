var EditAlbume = {
    self: null,
    _init: function () {
        self = EditAlbume;
        self.events();
    }
    ,
    events: function () {
        $('#edit_albume').submit(function (object) {
            object.preventDefault();
            EditAlbume.EditAlbume(object)
        });

        $('#alb_description').wysihtml5(Options.wysihtml5);

        $('#btn_cancelar,#btn_regresar').click(function () {
            window.location.href = '/admin/albumes';
        });

        $(document).on('click', 'a', function () {

            if ($(this).data('action') === 'clear-form') {
                $('#edit_albume').trigger('reset');
            }

        });
    }
    ,
    EditAlbume: function (object) {
        object.preventDefault();
        var actionForm = $(object.target).attr('action');
        var description = $('#alb_description').val();
        var dataString = $(object.target).serialize() + '&description=' + description;
        $.ajax({
            url: actionForm,
            method: 'PATCH',
            data: dataString
            ,
            complete: function (xhr) {

                if (xhr.status >= 200 && xhr.status < 202) {

                    Util.showAlert('alert-success', xhr.responseJSON.message);
                    //$(object.target).trigger('reset');
                    $('#btn_regresar').show();
                    $('#btn_cancelar').hide();

                } else if (xhr.status >= 202 && xhr.status <= 210) {

                    console.log(Messages.es.ERROR_UPDATED);
                    console.log(xhr.responseJSON.error);
                    Util.showAlert('alert-warning', xhr.responseJSON.message + xhr.responseJSON.error);

                }
            }
            ,
            error: function (xhr) {

                if (typeof(xhr.responseText) === 'string') {

                    var response = JSON.parse(xhr.responseText);
                    console.log(Messages.es.ERROR_UPDATED);
                    console.log(response.error);
                    Util.showAlert('alert-danger', response.message);

                } else {

                    Util.showAlert('alert-danger', xhr.statusText);
                    console.log(xhr);

                }
            }
        });
    }
};

var Options = {
    wysihtml5: {
        toolbar: {
            "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
            "emphasis": true, //Italics, bold, etc. Default true
            "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            "html": false, //Button which allows you to edit the generated HTML. Default false
            "link": true, //Button to insert a link. Default true
            "image": false, //Button to insert an image. Default true,
            "color": true, //Button to change color of font
            "blockquote": true, //Blockquote
            "size": 'sm' //default: none, other options are xs, sm, lg
        }
    }
};
$(document).ready(EditAlbume._init);