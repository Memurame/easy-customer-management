<?php

namespace App\Controllers;

use App\Models\WebsiteModel;
use App\Models\CustomerModel;
use App\Models\ProjectModel;
use App\Models\TaglistModel;
use App\Entities\Website;
use App\Entities\WebsiteTag;
use App\Models\CommentModel;

class apiProfileController extends BaseController
{
    

    public function createToken(){
        $data = array();
        $data['success'] = 0;

        $user = auth()->user();
        $tokens = $user->accessTokens();
        if($tokens){
            $data['message'] = "Es existiert bereits ein Token.";
        } else {
            $data['success'] = 1;
            $data['token'] = $user->generateAccessToken('API_Token');

            $email = emailer()->setFrom(setting('Email.fromEmail'), setting('Email.fromName') ?? '');
            $email->setTo($user->email);
            $email->setSubject("Neuer API-Token");
            $email->setMessage(view('email/new_apitoken_email.php', [
                'token' => $data['token'],
                'email' => $user->email]));
            if ($email->send(false) === false) {
                $data['message'] = "Token erfolgreich angelegt, jedoch konnte die Mail nicht versendet werden.";
            } else {
                $data['message'] = 'API-Token erfolgreich angelegt und an den Benutzer gesendet.';
            }
        }


        return $this->response->setJSON($data);
    }

    public function deleteToken(){
        $data = array();
        $data['success'] = 0;

        $user = auth()->user();
        $tokens = $user->accessTokens();

        if($tokens){
            $data['success'] = 1;
            $user->revokeAllAccessTokens();
            $data['message'] = 'Token erfolgreich gelöscht!';
        } else {
            
            $data['message'] = "Kein Token vorhanden.";
        }


        return $this->response->setJSON($data);
    }
}