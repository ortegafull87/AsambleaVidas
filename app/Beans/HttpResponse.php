<?php 

namespace App\Beans;

 /**
  * 
  */
  class HttpResponse {

  	private $message;
  	private $view;
  	private $data;
  	private $error;

  	public function setMessage($message = ""){
  		$this->message = $message;
  	}

  	public function setView($view = null){
  		if($view != null || $view != ""){
  			$this->view = $view->render();
  		}else{
  			$this->view = $view;
  		}
  	}

  	public function setData($data = ""){
  		$this->data = $data;
  	}

  	public function setError($error = null){
  		$this->error = $error;
  	}

 	/**
 	 * Regresa un array con los valores seteados
 	 * @return [type] [description]
 	 */
 	 public function toArray(){
 	 	return 
 	 	[
 	 	'message'	=> $this->message,
 	 	'view' 		=> $this->view,
 	 	'data' 		=> $this->data,
 	 	'error' 	=> $this->error,
 	 	];
 	 }
 	}