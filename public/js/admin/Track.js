var  Track = {

	_init:function(){
		Track.resizeContents();
		$('body').on('click','a',Track.tracksFormActions);
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%'
		});

		$(".audio").mb_miniPlayer();

	}
	,
	resizeContents:function(){
		var dif = 220;
		var wh = $( window ).height();
		var ventana_H = wh-dif;
		$('#cont_tracks').slimScroll({
			height: ventana_H +'px'
		});
		$("#box_form_new_track").height(wh-195);
	}
	,
	tracksFormActions:function(e){

		if($(e.target).data('action') === 'clear-form-new-track'){
			e.preventDefault();
			$("#up").trigger('reset');
			$(document.getElementsByClassName('upload-path')).html('');
		}
		if($(e.target).data('action')=== 'delete-some-track'){
			console.log('delete-some-track...');
			var tracks = Util.getCheckeds('tracks',true);
			if(tracks.length > 0){
				Track.deleteTrack(tracks);
			}else{
				Util.showAlert(null,'warning',Messages.es.WARNING,Messages.es.NO_CHECKED);
			}
		}

		if($(e.target).data('action')=== 'delete-all-track'){
			console.log('delete-all-track...');
			Track.deleteTrack('-1');
		}

		if($(e.target).data('action')=== 'properties-track'){
			console.log('properties-track..');
		}

	}
	,
	deleteTrack:function(params){
		$.ajax({
			type: "DELETE",
			url: "/admin/tracks/" + params,
			data: {_token:$('#token').val()}
		})
		.done(function( msg ) {
			console.debug(msg);
			window.location.href = '/admin/tracks';
		});
	}

};
$(document).ready(Track._init);
