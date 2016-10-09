<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 01/10/2016
 * Time: 10:49 AM
 */

namespace App\Service;
use App\Beans\BasicRequest;
use App\Dao\UserDaoImpl as UserDao;

class UserServiceImpl implements UserService
{
    protected $userDao;

    /**
     * UserServiceImpl constructor.
     * @param UserDao $userDao
     */
    public function __construct(UserDao $userDao)
    {
        $this->userDao = $userDao;
    }


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

        return ['users' => $this->userDao->Read($request)];
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