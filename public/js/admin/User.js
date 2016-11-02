/**
 * Created by VictorDavid on 12/10/2016.
 */
var User = {
    _init: function () {
        Util.setActiveSideMenu('admin/users');
        User.events();
    }
    ,
    events: function () {
        var self = User;
        $(document).on('click', 'div#cont > table a', function (event) {
            event.preventDefault();
            if (confirm('Cambiará el estado de el usuario: x')) {
                User.edit(this);
            } else {
                //no code
            }
        });
    }
    ,
    edit: function (obj) {
        var actionForm =    $(obj).attr('href');
        var user_id =       $(obj).attr('id');
        var status_id =     $(obj).data('status');
        var token = $('#token').val();
        $.ajax({
            url: actionForm,
            method: 'PATCH',
            data: {"user_id": user_id, "status_id": status_id, "_token": token}
            ,
            complete: function (xhr) {

                if (xhr.status >= 200 && xhr.status < 202) {
                    var data = xhr.responseJSON.data.user;
                    console.debug(data);
                    $('#user_' + user_id + ' > td').eq(6).html(data[0].updated_at);
                    $('#user_' + user_id + ' > td').eq(7).html(data[0].status);
                    $('#user_' + user_id + ' > td a').attr('data-status',data[0].status_id);
                    $('#user_' + user_id + ' > td a').removeData();
                    $('#user_' + user_id + ' > td a i').attr('class',(data[0].status_id == 1)?'fa fa-thumbs-down fa-lg':'fa fa-thumbs-up fa-lg');
                    Util.showAlert('alert-success', xhr.responseJSON.message);

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
$(document).ready(User._init);
