<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 29/11/2016
 * Time: 09:51 PM
 */

namespace App\Library;

use App\User;
use Illuminate\Support\Facades\Log;
use Mail;

class SendMail
{
    /**
     * Email enviado para que un usuario nuevo
     * confirme su cuenta.
     *
     * @param $id
     * @return bool
     */
    public static function ConfirmationUser($id)
    {
        LOG::info('Enviando correo de confirmación para usuario: ' . $id);
        $status = false;
        try {
            $user = User::find($id);
            Mail::send('admin.mails.confirm_acount', ['user' => $user], function ($m) use ($user) {
                $m->from(env('MAIL_USERNAME'), env('APP_DNS'));
                $m->to($user->email, $user->name)->subject('Confirma tu cuenta');
                //$m->to('ortegafull87@gmail.com', $user->name)->subject('Confirma tu cuenta');
            });
            $status = true;
            LOG::info('Enviando a:' . $user->email);
        } catch (\Exception $ex) {
            LOG::error($ex->getMessage());
        } finally {
            return $status;
        }
    }

    /**
     * Envia Notificaciones de eventos en la app
     * @param $id
     * @param array $data
     */
    public static function notificationReview($id, Array $data)
    {
        LOG::info('Enviando correo de notificación de revisiones pendientes: ' . $id);
        $status = false;
        try {
            $user = User::find($id);
            Mail::send('admin.mails.notification_review', ['user' => $user, 'data' => $data], function ($m) use ($user) {
                $m->from(env('MAIL_USERNAME'), env('APP_DNS'));
                $m->to($user->email, $user->name)->subject('Revisiones pendientes.');
                //$m->to('ortegafull87@gmail.com', $user->name)->subject('Notificación ');
            });
            $status = true;
            LOG::info('Notificación enviada por correo a:' . $user->email);
        } catch (\Exception $ex) {
            LOG::error($ex->getMessage());
        } finally {
            return $status;
        }
    }

    public static function share($id, Array $emails, $id_track)
    {
        LOG::info('Enviando correo de shareMail');
        $status = false;
        try {
            Log::debug($emails);
            $user = User::find($id);
            Mail::send('app.mails.share', ['id_track'=>$id_track, 'user' => $user], function ($m) use ($user, $emails) {
                $m->from(env('MAIL_USERNAME'), env('APP_DNS'));
                $m->to($user->email, $emails[0])->subject('Un regalo para ti');
                foreach ($emails as $email){
                    $m->bcc($email);
                }
            });
            $status = true;
            LOG::info('Notificación enviada por correo a:' . $user->email);
        } catch (\Exception $ex) {
            LOG::error($ex->getMessage());
        } finally {
            return $status;
        }
    }
}