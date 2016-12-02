<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 01/10/2016
 * Time: 10:49 AM
 */

namespace App\Service;

use App\Beans\BasicRequest;
use App\Beans\ServiceResponse;
use App\Dao\UserDaoImpl as UserDao;
use Illuminate\Support\Facades\Log;

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
        LOG::info('Iniciando...' . UserServiceImpl::class);

        $response = new ServiceResponse();
        $status_id = $request->getData()['status_id'];
        $id = $request->getId();

        try {
            switch ($status_id) {
                case 3:
                    $update = $this->userDao->setBajaUsuario($id);
                    break;
                case 4:
                    $update = $this->userDao->setAltaUsuario($id);
                    break;
                default:
                    //no code
                    break;
            }


            if ($update) {

                LOG::info('Obteniendo Usuario actualizado');

                $user = $this->userDao->getUserById($id);
                $response->setStatus(true);
                $response->setMessage('Usuario actulizado con el estado: ' . $user[0]->status);
                $response->setData(['user' => $user]);

                return $response;

            } else {

                $response->setStatus(false);
                $response->getMessage('Tubimos incovenientes para actualizar este usuario');
                $response->setData(null);

                return $response;
            }

        } catch (\Exception $e) {

            LOG::error($e->getMessage());
            $response->setStatus(false);
            $response->setMessage($e->getMessage());
            $response->setData([]);

            return $response;;
        }
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

    /**
     * Funcion para confirmar una nueva cuenta
     * @param $id
     * @param $token
     * @return mixed
     */
    public function confirm($id, $token)
    {
        $confirm = false;
        try {
            $user = $this->userDao->confirmAcount($id, $token);
            if (count($user)) {
                if ($this->userDao->setAltaUsuario($id)) {
                    $confirm = true;
                }
            }
            return $confirm;
        } catch (\Exception $ex) {
            LOG::error($ex->getMessage());
        }
    }
}