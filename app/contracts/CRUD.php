<?php

namespace App\Contracts;

use App\Beans\BasicRequest;
use Illuminate\Database\Eloquent\Model;

/**
 * Es una interfaz que deben de implementar
 * todas la clases que tienen una función de
 * catalogo.
 */
interface CRUD
{
	/**
	 * Crea un o varios nuevos elementos
	 * @param  BasicRequest $request
	 * @return boolean
	 */
	public function create(BasicRequest $request);

	/**
	 * obtiene un o varios elementos
	 * @param  BasicRequest $request
	 * @return BasicRequest
	 */
	public function Read(BasicRequest $request);

	/**
	 * Actualiza uno o varios elementos
	 * @param  BasicRequest $request
	 * @return boolean
	 */
	public function update(BasicRequest $request);

	/**
	 * Elimina uno o varios elementos
	 * @param  BasicRequest $request
	 * @return boolean
	 */
	public function delete(BasicRequest $request);
}