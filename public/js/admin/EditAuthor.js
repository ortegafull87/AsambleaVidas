var EditAuthor = {
	_init:function(){
		console.debug("EdiAuthor loaded...");
		$('#edit_author').submit(function(object){
			EditAuthor.editAuthor(object)
		});

		$('#btn_cancelar,#btn_regresar').click(function(){
			window.location.href='/admin/authors';
		});
	}
	,
	editAuthor:function(object){
		object.preventDefault();
		var actionForm 	= $(object.target).attr('action');
		var dataString 	= $(object.target).serialize();	 
		$.ajax({
			url:actionForm,
			method:'PATCH',
			data:dataString,
			success:function(data , status, xhr){
				if(xhr.status === 200 || xhr.status === 201){
					Util.showAlert('alert-success',data.message);
					$(object.target).trigger('reset');
					$('#btn_regresar').show();
					$('#btn_cancelar').hide();
				}else{
					console.log(xhr);
					Util.showAlert('alert-warning',data.message);
				}
			},
			error:function(xhr){
				console.log(xhr);
				Util.showAlert('alert-danger',xhr.status + ': ' + xhr.statusText);
			}
		});
	}
};
$(document).ready(EditAuthor._init);