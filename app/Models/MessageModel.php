<?php

namespace App\Models;

use App\Entities\Message;
use CodeIgniter\Model;


class MessageModel extends Model
{

    public $table = 'message';
    protected $db;
    protected $allowedFields = [
        "user_id",
        "message",
        "is_read",
        "chat_id"
    ];

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $returnType = Message::class;
    protected $useSoftDeletes = false;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }



    public function getMessagesOfChat($chatId, $mask_as_read = false)
    {
        $messages = $this
            ->where('chat_id', $chatId)
            ->findAll();

        if($mask_as_read){
            foreach($messages as $message){
                if($message->user_id != user_id()){
                    $message->is_read = true;
                    model('MessageModel')->save($message);
                }
            }

            $messages = $this
                ->where('chat_id', $chatId)
                ->findAll();
        }


        return $messages;

    }

    public function getNewMessagesOfCurrentUser()
    {
        $chatIds = [];
        $chats = model('ChatModel')
            ->whereIn('user1_id', [user_id()])
            ->orWhereIn('user2_id', [user_id()])
            ->findAll();

        if(!$chats){
            return [];
        }
        foreach($chats as $chat){
            $chatIds[] = $chat->id;
        }

        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->whereIn('chat_id', $chatIds);
        $builder->whereNotIn('user_id', [user_id()]);
        $builder->where('is_read', null);
        $builder->orderBy('created_at');
        $query = $builder->get();

        return $query->getResult();

        return $messages;

    }
}