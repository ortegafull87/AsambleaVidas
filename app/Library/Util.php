<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 05/10/2016
 * Time: 09:49 PM
 */

namespace App\Library;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;
use App\Library\Message;

class Util
{
    const ROOT_ID   = 1;
    const ADMIN_ID  = 2;
    const USER_ID   = 3;

    /**
     * Verifica que el si un usuario tiene privilegios root
     * si no se setea un parametro tomará el privilegio del
     * usuario autenticado
     * <p/>
     * @param int $privilege_id
     * @return bool
     */
    public static function AUNTH_USER_ROOT($privilege_id = -1)
    {
        Log::info("Obteniendo privilegios de usuaio autenticado");
        try {
            /** @var TYPE_NAME $privilege_id */
            $privilege_id = ($privilege_id != -1) ? $privilege_id : Auth::user()->privilege_id;
            Log::info($privilege_id);
            return Util::ROOT_ID == $privilege_id ? true : false;
        } catch (\Exception $ex) {
            Log::error($ex);
            Log::error($ex->getMessage());
            throw new Exception(Message::EXCEPTION_NO_ROOT_PRIVILEGE);
        }
    }

    /**
     * Verifica que el si un usuario tiene privilegios Administrador
     * si no se setea un parametro tomará el privilegio del
     * usuario autenticado
     * <p/>
     * @param int $privilege_id
     * @return bool
     */
    public static function AUNTH_USER_ADMIN($privilege_id = -1)
    {
        Log::info("Obteniendo privilegios de usuaio autenticado");
        try {
            /** @var TYPE_NAME $privilege_id */
            $privilege_id = ($privilege_id != -1) ? $privilege_id : Auth::user()->privilege_id;
            Log::info($privilege_id);
            return Util::ADMIN_ID == $privilege_id ? true : false;
        } catch (\Exception $ex) {
            Log::error($ex);
            Log::error($ex->getMessage());
            throw new Exception(Message::EXCEPTION_NO_ROOT_PRIVILEGE);
        }
    }

    /**
     Verifica que el si un usuario tiene privilegios como
     * usuario registrado
     * si no se setea un parametro tomará el privilegio del
     * usuario autenticado
     * <p/>
     * @param int $privilege_id
     * @return bool
     */
    public static function AUNTH_USER_REGISTERED($privilege_id = -1)
    {
        Log::info("Obteniendo privilegios de usuaio autenticado");
        try {
            /** @var TYPE_NAME $privilege_id */
            $privilege_id = ($privilege_id != -1) ? $privilege_id : Auth::user()->privilege_id;
            Log::info($privilege_id);
            return Util::USER_ID == $privilege_id ? true : false;
        } catch (\Exception $ex) {
            Log::error($ex);
            Log::error($ex->getMessage());
            throw new Exception(Message::EXCEPTION_NO_ROOT_PRIVILEGE);
        }
    }

}