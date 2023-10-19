<?php

namespace App\Controllers;

use App\Entities\Chat;
use App\Entities\Message;
use CodeIgniter\API\ResponseTrait;

class apiMessageController extends BaseController
{
    use ResponseTrait;



    public function getReceivers(){
        $receiverlist = model('ChatModel')->getAvailableReceivers();

        if(!$receiverlist){
            return $this->failNotFound('No possible recipients found');
        }
        return $this->respond($receiverlist, 200);

    }

    public function create(){
        $error = [];
        $json_data = $this->request->getJSON('array');

        $rules = [
            'message' => 'required',
            'receiver' => 'required'
        ];

        if (! $this->validate($rules))
        {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $chat = model('ChatModel')
            ->whereIn('user1_id', [user_id(), $json_data['receiver']])
            ->whereIn('user2_id', [user_id(), $json_data['receiver']])
            ->first();

        if($chat){
            $message = new Message();
            $message->user_id   = user_id();
            $message->chat_id   = $chat->id;
            $message->message   = $json_data['message'];
            model('MessageModel')->save($message);

            return $this->respond(['chat_id' => $chat->id], 200);

        } else {

            $chat = new Chat();
            $chat->user1_id     = $json_data['receiver'];
            $chat->user2_id     = user_id();
            model('ChatModel')->save($chat);
            $lastInsertID = model('ChatModel')->getInsertID();
            $chat = model('ChatModel')->find($lastInsertID);


            $message = new Message();
            $message->user_id   = user_id();
            $message->chat_id   = $chat->id;
            $message->message   = $json_data['message'];
            model('MessageModel')->save($message);

            return $this->respond(['chat_id' => $chat->id], 200);
        }
    }

    public function deleteChat($chatId = null){
        $chat = model('ChatModel')->find($chatId);

        if(!$chat){
            return $this->failNotFound('The chat does not exist');
        }

        if($chat->user1_id != user_id() AND $chat->user2_id != user_id()){
            return $this->failForbidden('You are not a participant in this chat, so you cannot delete it');
        }

        model('ChatModel')->delete($chat->id);

        return $this->respondDeleted();


    }

}