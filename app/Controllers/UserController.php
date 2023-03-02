<?php

namespace App\Controllers;
use CodeIgniter\Shield\Models\UserModel;


class UserController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();


        return view('admin/user/index', [
            'users' => $users
        ]);
    }

}