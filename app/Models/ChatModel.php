<?php

namespace App\Models;

use App\Entities\Chat;
use CodeIgniter\Model;


class ChatModel extends Model
{

    public $table = 'chat';
    protected $db;
    protected $allowedFields = [
        "user2_id",
        "user1_id"
    ];

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $returnType = Chat::class;
    protected $useSoftDeletes = false;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getAvailableReceivers(){
        $return = [];
        foreach(model('UserModel')->findAll() as $val){
            $search_exists = $this
                ->whereIn('user1_id', [user_id(), $val->id])
                ->whereIn('user2_id', [user_id(), $val->id])
                ->findAll();

            if(!$search_exists AND user_id() != $val->id){
                $return[$val->id] = profile($val->id)->firstname . ' ' . profile($val->id)->lastname;
            }

        }

        return $return;
    }

    public function getChats(){
        $chats = $this
            ->where('user1_id', user_id())
            ->orWhere('user2_id', user_id())
            ->findAll();

        return $chats;
    }

    public function getOtherChatMember($chatId){
        $chat = $this->find($chatId);
        if($chat->user1_id == user_id()){
            return $chat->user2_id;
        } else {
            return $chat->user1_id;
        }

    }

}