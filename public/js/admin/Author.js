var Author = {
	_init:function(){
		console.debug("Author loaded");
		Author.resizeContents();
		Util.setCheckBoxStyle();
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

};
$(document).ready(Author._init);