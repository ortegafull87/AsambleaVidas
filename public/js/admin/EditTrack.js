var jsmediatags = window.jsmediatags;
var EditTrack = {
	init:function(){
		$(".audio").mb_miniPlayer();
		EditTrack.loadFile();
		EditTrack.uploadTrackAction('#pg_bar_track');
		EditTrack.listeners();
	},
	listeners:function(){
		$('#btn_regresar').on('click',function(){
			window.location.href = '/admin/tracks';
		});
		$('#btn_cancelar').on('click',function(){
			window.location.href = '/admin/tracks';
		});
	},
	loadFile:function(){
		var span = document.getElementsByClassName('upload-path');
		var uploader = document.getElementsByName('file');
		for( item in uploader ) {
			uploader[item].onchange = function() {
				span[0].innerHTML = this.files[0].name;

				jsmediatags.read(this.files[0], {
					onSuccess: function(tag) {
	 							//console.log(tag);
	 						},
	 						onError: function(error) {
	 							console.log(':(', error.type, error.info);
	 						}
	 					});
			}
		}
	}
	,
	uploadTrackAction:function(id_MainBar){
		var mainBar = $(id_MainBar);
		var btnSubmit = $("#btn_submit_update");
		var btnRegresar = $('#btn_regresar');
		var btnCancelar = $('#btn_cancelar');
		var bar = mainBar.find('div[role="progressbar"]');
		var label = bar.find('span');
		mainBar.hide();

		$('#edit').ajaxForm({
			beforeSubmit:function(arr){
				var file = arr[5];

	 					//verificando el tamaño del archivo
	 					var file = document.getElementsByName('file');
	 					if(typeof(file.value) === 'string'){
	 						var sizeFile = (file.value.size / (1024*1024)).toFixed(2);
	 						if(sizeFile > Track.MAX_FILE_SIZE_UPLOAD){
	 							Util.showAlert('alert-warning',Messages.es.FILE_SIZE);
	 							console.debug(sizeFile + 'MB');
	 							return false;
	 						}
	 					}

	 				},
	 				beforeSend: function() {
	 					mainBar.show();
	 					btnSubmit.hide();
	 					btnCancelar.hide();
	 					label.toggleClass('sr-only');
	 					var percentVal = '0%';
	 					bar.css({'width':percentVal});

	 				},
	 				uploadProgress: function(event, position, total, percentComplete) {
	 					var percentVal = percentComplete + '%';
	 					bar.css({'width':percentVal});
	 					label.html(percentVal);

	 				},
	 				success: function() {
	 					var percentVal = '100%';
	 					bar.css({'width':percentVal});
	 					label.html(percentVal);

	 				},
	 				complete: function(xhr) {
	 					mainBar.hide();
	 					btnRegresar.show();
	 					var message = xhr.responseJSON.message;
	 					console.debug(message);
	 					Util.showAlert('alert-success',xhr.responseJSON.message);
	 				}
	 				,
	 				error:function(xhr){
	 					mainBar.hide();
	 					btnSubmit.show();
	 					btnCancelar.show();
	 					console.debug(xhr);
	 					Util.showAlert('alert-danger',Messages.es.ERROR,xhr)
	 				}
	 			});
	}
};
$(document).ready(EditTrack.init);