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

	/*Exceptions*/
	const EXCEPTION_NO_ROOT_PRIVILEGE	= "Lo sentimos tuvimos algunos inconvenientes, obteniendo sus privilegios";

	/*Generales*/
	const ERROR_5X 						= "Lo sentimos tuvimos algunos inconvenientes, por favor contacta al administrador.";
	const WARNING_2X					= "Algo no anda bien. ";
	const NOT_PRIVILEGE					= "No tiene privilegios para usar esta función";

	/*App Errors*/
	const APP_ERROR_GENERAL_PPROCESS_FAILED		= "Ups! Tubimos un inconveniente, porfavor intenta más tarde.";
	const APP_WARNING_FUNCTION_ONLY_AUTH_USER	= "Registrate para usar esta función, es fácil, no te toma más de 3 minutos.";
	const APP_WARNING_TRY_AGAIN			= "Ups!, intentalo de nuevo.";
	/*App Messages*/
	const APP_SET_FAVORITE					= "Me gusta!";
	const APP_UNSET_FAVORITE				= "Ya no me gusta";





}