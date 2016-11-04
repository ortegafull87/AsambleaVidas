var NewAuthor = {
    self: null,
    _init: function () {
        Util.setActiveSideMenu('admin/authors/create');
        self = NewAuthor;
        self.events();
    }
    ,
    events: function () {

        $('#new_author').submit(function (object) {
            NewAuthor.newAuthor(object)
        });

        $(document).on('click', 'a', function () {

            if($(this).data('action') === 'clear-form') {
                $('#new_author').trigger('reset');
            }

        });
    }
    ,
    newAuthor: function (object) {
        object.preventDefault();
        var actionForm = $(object.target).attr('action');
        var dataString = $(object.target).serialize();
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
$(document).ready(NewAuthor._init);