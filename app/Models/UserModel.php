<?php

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{

    public function lastActiveUser($limit = 6){

        $users = $this
            ->where('last_active !=', null)
            ->OrderBy('last_active', 'desc')
            ->limit($limit)
            ->findAll();

        return $users;
    }

}