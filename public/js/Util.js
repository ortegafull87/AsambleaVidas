var Util={
	_init:function(){

	}
	,
	/**
	 * [showAlert description]
	 * @param  {[type]}   object   [description]
	 * @param  {[type]}   type     [description]
	 * @param  {[type]}   title    [description]
	 * @param  {[type]}   message  [description]
	 * @param  {Function} callback [description]
	 * @return {[type]}            [description]
	 */
	 showAlertPopUp:function(object,type,title,message,callback){
	 	swal({
	 		title: title,
	 		text: message,
	 		type: type
	 	}).then(function(){
	 		if(callback !== undefined){
	 			callback(object);
	 		}

	 	});
	 }
	 ,
	 showAlert:function(classe, message){

	 	$('.alert').fadeOut("fast");
	 	$('.alert').find('span').html();

	 	var alerta = $('.' + classe);
	 	var msg = alerta.find('span');

	 	msg.html(message);
	 	alerta.fadeIn("fast");

	 }
	 ,
	 /**classe
	  * Obtiene el id de uno o varios checkbox checados 
	  * si se le pasa el segundo parametro como true
	  * este devolvera un array solo con los id numericos, 
	  * si no se le pasa el segundo argumento
	  * por default devolvera un array con el id completo
	  * @param  {[String]} 		nameObject   [description]
	  * @param  {[boolean]} 	justIdNumber [description]
	  * @return {[Array]}       	         [description]
	  */
	  getCheckeds:function(nameObject,justIdNumber){
	  	var checkGroup = $('input[name="'+nameObject+'"]');
	  	var arrayGruop = [];
	  	$.each(checkGroup,function(i,track){
	  		if($(track).is(':checked')){
	  			var id = $(track).attr('id');
	  			if(justIdNumber === undefined || justIdNumber === false){
	  				arrayGruop.push(id);	
	  			}else{
	  				console.debug("justIdNumber");
	  				var idSplit = id.split('_');
	  				arrayGruop.push(idSplit[idSplit.length-1]);	
	  			}
	  		}
	  	});
	  	return arrayGruop;
	  }
	  ,
	  /**
	   * Conbierte bytes a MB
	   * @param  {[type]} bytess [description]
	   * @return {[type]}        [description]
	   */
	   parseToMB:function(bytess){
	   	if(bytess !== undefined && bytess > 0){
	   		return (bytess / (1024*1024)).toFixed(2);
	   	}else{
	   		return 0;
	   	}
	   }
	   ,
	   setCheckBoxStyle:function(){
	   	$('input').iCheck({
	   		checkboxClass: 'icheckbox_square-blue',
	   		radioClass: 'iradio_square-blue',
	   		increaseArea: '20%'
	   	});
	   }
	};
	$(document).ready(Util._init);