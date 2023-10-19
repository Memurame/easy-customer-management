<?php

namespace App\Entities;

use CodeIgniter\Entity;

class Chat extends Entity
{
    /**
     * @var array
     */
    protected $datamap = [];

    /**
     * @var string[]
     */
    protected $dates   = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $casts   = [];

    public $data;

    public function getChatname(){
        $userid = $this->getOtherUser();
        $userdetail = model('UserDetailsModel')
            ->where('user_id', $userid);

        return ($userdetail) ? $userdetail->firstname . ' ' . $userdetail->lastname : null;
    }


    public function getOtherUser(){
        if($this->user1_id == user_id()){
            return $this->user2_id;
        }
        elseif($this->user2_id == user_id()){
            return $this->user1_id;
        }

        return null;
    }
}