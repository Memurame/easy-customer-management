<?php

namespace App\Controllers;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Entities\User;


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

    public function edit($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);


        if($_SERVER['REQUEST_METHOD'] == 'POST'){


            $rules = [
                'username' => 'required',
                'email' => 'required',
                'group' => 'required'
            ];

            if($this->request->getPost('password') == 'smtp'){
                $rules = array_merge($rules, [
                    'password' => 'required'
                ]);
            }

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $userModel = model('UserModel');


            $user->username = $this->request->getPost('username');
            $user->email = $this->request->getPost('email');

            if($this->request->getPost('password')){
                $user->password = $this->request->getPost('password');
            }
            
            $userModel->save($user);


            $selectedGroups = $this->request->getPost('group');
            foreach(service('settings')->get('AuthGroups.groups') as $key => $group){
                if(($group['isAdmin'] && auth()->user()->can('user.manage-admins')) OR !$group['isAdmin']){
                    if(array_key_exists($key, $selectedGroups)){
                        $user->addGroup($key);
                    } else {
                        $user->removeGroup($key);
                    }
                }
            }
            return redirect()->route('user.index');
            
            

        }



        return view('admin/user/edit', [
            'user' => $user
        ]);
    }

    public function add()
    {



        if($_SERVER['REQUEST_METHOD'] == 'POST'){


            $rules = [
                'username' => 'required',
                'email' => 'required',
                'password' => 'required',
                'group' => 'required'
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $userGroup = null;


            $userModel = model('UserModel');
            $user = new User($this->request->getPost(['username', 'email', 'password']));
            $userModel->save($user);

            $user = $userModel->findById($userModel->getInsertID());

            $user->activate();

            $selectedGroups = $this->request->getPost('group');
            foreach(service('settings')->get('AuthGroups.groups') as $key => $group){
                if(($group['isAdmin'] && auth()->user()->can('user.manage-admins')) OR !$group['isAdmin']){
                    if(array_key_exists($key, $selectedGroups)){
                        $user->addGroup($key);
                    } else {
                        $user->removeGroup($key);
                    }
                }
            }
            return redirect()->route('user.index');
            
            

        }
        return view('admin/user/add');
    }




    public function apiDelete($id){
        $data = array();
        $data['success'] = 0;
        $data['token'] = csrf_hash();

        $userModel = model('UserModel');
        $user = $userModel->findById($id);

        if($user->id == user_id()){
            $data['error'] = "Du kannst dich selbst nicht löschen.";
        }
        else{
            if(empty($user)){
                $data['error'] = "Der Benutzer wurde nicht gefunden.";
            } else {
                $deleted = $userModel->delete($user->id, true);
                if($deleted){
                    $data['success'] = 1;
                } else {
                    $data['error'] = "Fehler beim Lsöchen des Benutzers";
                }
            }
        }

        


        return $this->response->setJSON($data);
    }

}