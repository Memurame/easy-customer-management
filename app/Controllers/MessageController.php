<?php

namespace App\Controllers;

use App\Entities\Message;
use CodeIgniter\Files\File;

class MessageController extends BaseController
{

    public function index()
    {

        $get_chat = $this->request->getGet('chat');


        $chats = model('ChatModel')->getChats();

        $receiverlist = model('ChatModel')->getAvailableReceivers();

        if($get_chat){
            $exist_chat = model('ChatModel')->find($get_chat);

            if(!$exist_chat){
                return redirect()->to(route_to('message.index'))->with('msg_error', 'Dieser Chat existiert nicht');
            }
            $messages = model('MessageModel')->getMessagesOfChat($get_chat, true);
            $receiver = model('ChatModel')->getOtherChatMember($get_chat);



            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                $rules = [
                    'message-text' => 'required',
                    'receiver-hidden' => 'required'
                ];

                if (!$this->validate($rules)) {
                    return redirect()->back()->with('msg_error', 'Bitte gib eine Nachricht ein');
                }

                $chat = model('ChatModel')
                    ->whereIn('user1_id', [user_id(), $this->request->getPost('receiver-hidden')])
                    ->whereIn('user2_id', [user_id(), $this->request->getPost('receiver-hidden')])
                    ->first();

                if($chat) {
                    $message = new Message();
                    $message->user_id = user_id();
                    $message->chat_id = $chat->id;
                    $message->message = $this->request->getPost('message-text');
                    model('MessageModel')->save($message);

                    session()->setFlashdata('msg_success', 'Nachricht wurde versendet.');

                    return redirect()->back();
                }
            }
        }

        return view('messenger/index', [
            'receiverlist' => $receiverlist,
            'chats' => $chats,
            'currentChat' => $get_chat ?? null,
            'messages' => $messages ?? [],
            'receiver' => $receiver ?? null
        ]);

    }

    public function chat(){



        return view('messenger/index');
    }
}
