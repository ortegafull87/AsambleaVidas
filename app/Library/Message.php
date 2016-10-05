<?php

namespace App\Library;

class Message{
	/*Modulo Authors*/
	const SUCCESS_AUTHORS_DELETED_ONE	= "Autor eliminado"; 
	const SUCCESS_AUTHORS_DELETED_MANY	= "Autors eliminados";
	const ERROR_AUTHORS_FOREIGN_KEY 	= "El autor(es) que desea eliminar ya se encuentran asignados a una o más pistas, no es posible eliminarlos";
	/*Modulo Albumes*/
	const SUCCESS_ALBUMES_UPDATED		= "Albume actualizado";
	const SUCCESS_ALBUMES_DELETED_ONE	= "Álbume eliminado"; 
	const SUCCESS_ALBUMES_DELETED_MANY	= "Álbumes eliminados";  
	const ERROR_ALBUMES_FOREIGN_KEY 	= "El Albume(es) que desea eliminar ya se encuentran asignados a una o más pistas, no es posible eliminarlos";
	
	/*Generales*/
	const ERROR_5X 						= "Lo sentimos tuvimos algunos inconvenientes, por favor contacta al administrador.";
	const WARNING_2X					= "Algo no anda bien. ";


}