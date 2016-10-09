<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 01/10/2016
 * Time: 10:45 AM
 */

namespace App\Dao;

use App\Beans\BasicRequest;
Use App\User;
use Illuminate\Support\Facades\DB;

class UserDaoImpl implements UserDao
{

    /**
     * Crea un o varios nuevos elementos
     * @param  BasicRequest $request
     * @return boolean
     */
    public function create(BasicRequest $request)
    {
        // TODO: Implement create() method.
    }

    /**
     * obtiene un o varios elementos
     * @param  BasicRequest $request
     * @return BasicRequest
     */
    public function Read(BasicRequest $request)
    {
        //return User::all() ;
        $rows = $request->getRows();
        return DB::table('users')
            ->join('privileges', 'users.privilege_id', '=', 'privileges.id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.password',
                'users.created_at',
                'users.updated_at',
                'users.privilege_id',
                'privileges.description'
            )->paginate($rows);
    }

    /**
     * Actualiza uno o varios elementos
     * @param  BasicRequest $request
     * @return boolean
     */
    public function update(BasicRequest $request)
    {
        // TODO: Implement update() method.
    }

    /**
     * Elimina uno o varios elementos
     * @param  BasicRequest $request
     * @return boolean
     */
    public function delete(BasicRequest $request)
    {
        // TODO: Implement delete() method.
    }
}