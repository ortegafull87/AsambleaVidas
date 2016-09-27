var Albume = {
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

				Author.deleteItem(albumes);

			}else{

				Util.showAlert(null, 'warning', Messages.es.WARNING, Messages.es.NO_CHECKED);
			}
		}

		if($(e.target).data('action')=== 'delete-all-items'){

			console.log('delete-all-items...');
			Author.deleteItem('-1');

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
};
$(document).ready(Albume._init);