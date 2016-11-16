var NewAlbume = {
    self: null,
    _init: function () {
        Util.setActiveSideMenu('admin/albumes/create');
        self = NewAlbume;
        self.events();

    }
    ,
    events: function () {

        $('#alb_description').wysihtml5(Options.wysihtml5);

        $('#new_albume').submit(function (object) {
            self.newAlbume(object)
        });

        $(document).on('click', 'a', function () {

            if ($(this).data('action') === 'clear-form') {
                $('#new_albume').trigger('reset');
            }

        });

    }
    ,
    newAlbume: function (object) {
        object.preventDefault();
        var actionForm = $(object.target).attr('action');
        var description = $('#alb_description').val();
        var dataString = $(object.target).serialize() + '&description=' + description;
        console.debug(dataString);
        $.ajax({
            url: actionForm,
            method: 'POST',
            data: dataString
            ,
            complete: function (xhr) {

                if (xhr.status >= 200 && xhr.status < 202) {

                    Util.showAlert('alert-success', xhr.responseJSON.message);
                    $(object.target).trigger('reset');

                } else if (xhr.status >= 202 && xhr.status <= 210) {

                    console.log(Messages.es.ERROR_CREATED);
                    console.log(xhr.responseJSON.error);
                    Util.showAlert('alert-warning', xhr.responseJSON.message + xhr.responseJSON.error);

                }
            }
            ,
            error: function (xhr) {

                if (typeof(xhr.responseText) === 'string') {

                    var response = JSON.parse(xhr.responseText);
                    console.log(Messages.es.ERROR_CREATED);
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

$(document).ready(NewAlbume._init);