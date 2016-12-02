<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 01/10/2016
 * Time: 10:45 AM
 */

namespace App\Dao;

use App\Beans\BasicRequest;
use App\Library\Constantes;
use App\Service\UserServiceImpl;
Use App\User;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use Illuminate\Support\Facades\Log;

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
            ->join('status', 'users.status_id', '=', 'status.id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.password',
                'users.created_at',
                'users.updated_at',
                'users.privilege_id',
                'users.status_id',
                'privileges.description',
                'status.status'
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

    /**
     * Da de baja un usuario del sistema.
     * @param $id
     * @return mixed
     */
    public function setBajaUsuario($id)
    {
        LOG::info('Desactivando usuario: ' . $id . ' ' .UserServiceImpl::class);
        try {
            User::where('id', $id)
                ->update(['status_id' => Constantes::USER_INACTIVE]);
            return true;
        } catch (\Exception $e) {
            LOG::error($e->getMessage());
            throw  new Exception($e->getMessage());
        }
    }

    /**
     * Activa un usuario del sistema.
     * @param $id
     * @return mixed
     */
    public function setAltaUsuario($id)
    {
        LOG::info('Activando usuario: ' . $id . ' ' . UserDaoImpl::class);
        try {
            User::where('id', $id)
                ->update(['status_id' => Constantes::USER_ACTIVE]);
            return true;
        } catch (\Exception $e) {
            LOG::error($e->getMessage());
            throw  new Exception($e->getMessage());
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        return DB::table('users')
            ->join('privileges', 'users.privilege_id', '=', 'privileges.id')
            ->join('status', 'users.status_id', '=', 'status.id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.password',
                'users.created_at',
                'users.updated_at',
                'users.privilege_id',
                'users.status_id',
                'privileges.description',
                'status.status'
            )->where('users.id', '=', $id)
            ->get();
    }

    /**
     * Confirma la creacion de una nueva cuenta de usuario
     * @param $id
     * @param $token
     * @return mixed
     */
    public function confirmAcount($id, $token)
    {
        LOG::info("Confirmando cuenta creada para el usuario: " . $id . 'from: ' . UserDaoImpl::class);
        try{
            return User::where('id',$id)
                ->where('register_token',$token)
                ->get();
        }catch(\Exception $ex){
            LOG::error($ex->getMessage());
            throw new Exception($ex->getMessage());
        }
    }
}