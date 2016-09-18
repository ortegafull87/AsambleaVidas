var jsmediatags = window.jsmediatags;
var NewTrack = {

	MAX_FILE_SIZE_UPLOAD:42,

	_init:function(){
		console.debug("New Track module loaded.....");
		NewTrack.loadFile();
		NewTrack.uploadTrackAction('#pg_bar_track');
	}
	,
	loadFile:function(){
		var span = document.getElementsByClassName('upload-path');
		var uploader = document.getElementsByName('file');
		for( item in uploader ) {
			uploader[item].onchange = function() {
				span[0].innerHTML = this.files[0].name + "<br>" + Util.parseToMB(this.files[0].size) + " Mb";
				console.debug(this.files[0]);
				jsmediatags.read(this.files[0], {
					onSuccess: function(tag) {
						console.log(tag);
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
		var btnSubmit = $("#btn_submit_track");
		var bar = mainBar.find('div[role="progressbar"]');
		var label = bar.find('span');
		mainBar.hide();
		$('#up').ajaxForm({
			beforeSubmit:function(arr){
				var file = arr[5];
	 					// verificar si el archivo ha sido seleccionado
	 					if(typeof(file.value) === 'string'){
	 						Util.showAlert('alert-warning',Messages.es.NO_FILE);
	 						console.log(file);
	 						return false;
	 					}

	 					//verificando el tamaño del archivo
	 					var sizeFile = (file.value.size / (1024*1024)).toFixed(2);
	 					if(sizeFile > NewTrack.MAX_FILE_SIZE_UPLOAD){
	 						Util.showAlert('alert-warning',Messages.es.FILE_SIZE);
	 						console.debug(sizeFile + 'MB');
	 						return false;
	 					}

	 				},
	 				beforeSend: function() {
	 					mainBar.show();
	 					btnSubmit.hide();
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
	 					btnSubmit.show();
	 					if(xhr.status >= 200 && xhr.status <= 202){
	 						Util.showAlert('alert-success',xhr.responseJSON.message);
	 						$("#up").trigger('reset');
	 						$(document.getElementsByClassName('upload-path')).html('');
	 					}else if(xhr.status >= 204 && xhr.status <= 210){
	 						Util.showAlert('alert-warning',xhr.responseJSON.message);
	 						$("#up").trigger('reset');
	 						$(document.getElementsByClassName('upload-path')).html('');	
	 					}
	 				}
	 				,
	 				error:function(xhr){
	 					console.debug(xhr);
	 					mainBar.hide();
	 					btnSubmit.show();

	 					if(typeof(xhr.responseText) === 'string'){
	 						var error =  JSON.parse(xhr.responseText);
	 						Util.showAlert('alert-danger',error.message);
	 					}else{
	 						Util.showAlert('alert-danger',xhr.statusText);
	 					}
	 				}
	 			});
	}
};
$(document).ready(NewTrack._init);