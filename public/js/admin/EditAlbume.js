var EditAlbume = {
	_init:function(){
		console.debug("Edit albume loaded...");
		$('#edit_albume').submit(function(object){
			object.preventDefault();
			EditAlbume.EditAlbume(object)
		});

		$('#btn_cancelar,#btn_regresar').click(function(){
			window.location.href='/admin/albumes';
		});
	}
	,
	EditAlbume:function(object){
		object.preventDefault();
		var actionForm 	= $(object.target).attr('action');
		var dataString 	= $(object.target).serialize();	 
		$.ajax({
			url:actionForm,
			method:'PATCH',
			data:dataString
			,
			complete: function(xhr) {

				if(xhr.status >= 200 && xhr.status < 202){
					
					Util.showAlert('alert-success', xhr.responseJSON.message);
					//$(object.target).trigger('reset');
					$('#btn_regresar').show();
					$('#btn_cancelar').hide();

				}else if(xhr.status >= 202 && xhr.status <= 210){

					console.log(Messages.es.ERROR_UPDATED);
					console.log(xhr.responseJSON.error);
					Util.showAlert('alert-warning', xhr.responseJSON.message + xhr.responseJSON.error);

				}
			}
			,
			error:function(xhr){
				
				if(typeof(xhr.responseText) === 'string'){

					var response = JSON.parse(xhr.responseText);
					console.log(Messages.es.ERROR_UPDATED);
					console.log(response.error);
					Util.showAlert('alert-danger', response.message);

				}else{

					Util.showAlert('alert-danger', xhr.statusText);
					console.log(xhr);

				}
			}
		});
	}
};
$(document).ready(EditAlbume._init);