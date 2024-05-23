<?php

namespace App\Controllers;

use App\Models\WebsiteModel;
use App\Models\CustomerModel;
use App\Models\ProjectModel;
use App\Models\TaglistModel;
use App\Entities\Website;
use App\Entities\WebsiteTag;
use App\Models\CommentModel;
use CodeIgniter\API\ResponseTrait;

class apiUserController extends BaseController
{
    use ResponseTrait;

    public function delete($userId = null){
        $user = model('UserModel')->findById($userId);

        if(!$user){
            return $this->failNotFound('The user does not exist');
        }

        $userGroups = $user->getGroups();

        if((in_array('superadmin', $userGroups) OR in_array('admin', $userGroups)) AND !auth()->user()->inGroup('superadmin')){
            return $this->failForbidden('You do not have the necessary rights');
        }

        if($user->id == user_id()){
            return $this->fail('You cannot delete yourself');
        }


        model('UserModel')->delete($user->id, true);

        return $this->respondDeleted();


    }

    public function resetPassword($userId = null){
        $user = model('UserModel')->findById($userId);

        if(!$user){
            return $this->failNotFound('The user does not exist');
        }

        $userGroups = $user->getGroups();

        if((in_array('superadmin', $userGroups) OR in_array('admin', $userGroups)) AND !auth()->user()->inGroup('superadmin')){
            return $this->failForbidden('You do not have the necessary rights');
        }

        $newPassword = createRandomPassword(12);
        $user->password = $newPassword;
        $saved = model('UserModel')->save($user);

        if($saved) {
            $email = emailer()->setFrom(setting('Email.fromEmail'), setting('Email.fromName') ?? '');
            $email->setTo($user->email);
            $email->setSubject("Passwort wurde zurückgesetzt");
            $email->setMessage(view('templates/email/password_reset_email.php', [
                'username' => $user->username,
                'email' => $user->email,
                'password' => $newPassword]));
            if ($email->send(false) === false) {
                return $this->failServerError('Das Passwort wurde geändert, jedoch trat ein Fehler beim versenden der Mail auf.');

            }
        }

        return $this->respondUpdated('Passwort wurde geändert und dem Benutzer zugesendet.');


    }

}