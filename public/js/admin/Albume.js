var Albume = {

	contenedor: $('#box_list_albumes')
	,

	_init:function(){
		console.debug('Albume Module loaded...');

		$('body').on('click','a',Albume.albumesFormActions);

		Albume.resizeContents();
		Util.setCheckBoxStyle();
	}
	,
	albumesFormActions:function(e){

		if($(e.target).data('action')=== 'delete-some-item'){

			console.log('delete-some-item...');
			var albumes = Util.getCheckeds('albumes',true);

			if(albumes.length > 0){

				Albume.deleteItem(albumes);

			}else{

				Util.showAlert(null, 'warning', Messages.es.WARNING, Messages.es.NO_CHECKED);
			}
		}

		if($(e.target).data('action')=== 'delete-all-items'){

			console.log('delete-all-items...');
			Albume.deleteItem('-1');

		}

	}
	,
	resizeContents:function(){

		var dif = 295;
		var wh = $( window ).height();
		var ventana_H = wh-dif;

		$('#cont').slimScroll({
			height: ventana_H +'px'
		});
	}
	,
	deleteItem:function(params){
		$.ajax({

			type: "DELETE",
			url: "/admin/albumes/" + params,
			data: {_token:$('#token').val()}
			,
			complete: function(xhr) {

				if(xhr.status >= 200 && xhr.status <= 202){
					
					Albume.contenedor.html(xhr.responseJSON.view);
					Util.setCheckBoxStyle();
					$(document.getElementsByClassName('upload-path')).html('');
					Util.showAlert('alert-success', xhr.responseJSON.message);

				}else if(xhr.status >= 204 && xhr.status <= 210){
					console.log(Messages.es.ERROR_DELETE);
					console.log(xhr.responseJSON.error);
					Util.showAlert('alert-warning', xhr.responseJSON.message);
					$(document.getElementsByClassName('upload-path')).html('');	

				}
			}
			,
			error:function(xhr){
				console.debug(xhr);
				if(typeof(xhr.responseText) === 'string'){

					var response = JSON.parse(xhr.responseText);
					console.log(Messages.es.ERROR_DELETE);
					console.log(response.error);
					Util.showAlert('alert-danger', response.message);

				}else{

					Util.showAlert('alert-danger', xhr.statusText);
					console.log(xhr);

				}
			}
		})
	}
};
$(document).ready(Albume._init);