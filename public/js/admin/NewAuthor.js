var NewAuthor = {
	_init:function(){
		console.debug("NewAuthor loaded");

		$('#new_author').submit(function(object){
			NewAuthor.newAuthor(object)
		});
	}
	,
	newAuthor:function(object){
		object.preventDefault();
		var actionForm 	= $(object.target).attr('action');
		var dataString 	= $(object.target).serialize();	 
		$.ajax({
			url:actionForm,
			method:'POST',
			data:dataString,
			success:function(data , status, xhr){
				if(xhr.status === 200 || xhr.status === 201){
					Util.showAlert('alert-success',data.message);
					$(object.target).trigger('reset');
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
$(document).ready(NewAuthor._init);