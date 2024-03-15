<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class TestimonialForm extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getNotifyMail($userID){
        return model("UserModel")->find($userID)->email;
    }
}
