<?php

namespace App\Controllers;
use App\Entities\UserDetails;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;
use CodeIgniter\Shield\Authentication\Passwords;


class UserController extends BaseController
{
    /**
     * Auth Table names
     */
    private array $tables;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ): void {
        parent::initController(
            $request,
            $response,
            $logger
        );

        /** @var Auth $authConfig */
        $authConfig   = config('Auth');
        $this->tables = $authConfig->tables;
    }
    
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
        $user = $userModel->findById($id);

        if(!$user){
            session()->setFlashdata('msg_error', 'Der ausgewählte Benutzer wurde nicht gefunden.');
            return redirect()->route('user.index');
        }
        $userGroups = $user->getGroups();

        if((in_array('superadmin', $userGroups) OR in_array('admin', $userGroups)) AND !auth()->user()->can('user.manage-admins')){
            session()->setFlashdata('msg_error', 'Du besitzt keine Berechtigung einen Administrator zu bearbeiten.');
            return redirect()->route('user.index');
        }

        $userDetailModel = model('UserDetailsModel');
        $userDetail = $userDetailModel->find($user->id);
        if(!$userDetail){
            $userDetail = new UserDetails();
            $userDetail->user_id = $user->id;
            $userDetailModel->save($userDetail);

            $userDetail = $userDetailModel->find($user->id);
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $usernameRules            = config('Auth')->usernameValidationRules;
            $usernameRules['rules'][] = sprintf(
                'is_unique[%s.username,id, %s]',
                $this->tables['users'],
                $user->id
            );

            $emailRules            = config('Auth')->emailValidationRules;
            $emailRules['rules'][] = sprintf(
                'is_unique[%s.secret,id, %s]',
                $this->tables['identities'],
                $user->id
                
            );

            $rules = [
                'username' => $usernameRules,
                'email' => $emailRules,
                'group'    => [
                    'rules' => 'required'
                ],
                'firstname'    => [
                    'rules' => 'required'
                ],
                'lastname'    => [
                    'rules' => 'required'
                ]
            ];

            if($this->request->getPost('password')){

                $rules = array_merge($rules, [
                    'password' => [
                        'rules'  => ['required', 'strong_password[]'],
                    ]
                ]);
            }

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }


            $user->username = $this->request->getPost('username');
            $user->email = $this->request->getPost('email');

            if($this->request->getPost('password')){
                $user->password = $this->request->getPost('password');
            }


                $userModel->save($user);
                
            


            $userDetail->firstname = $this->request->getPost('firstname');
            $userDetail->lastname = $this->request->getPost('lastname');
            $userDetail->department = $this->request->getPost('department');
            $userDetail->phone = $this->request->getPost('phone');
            $userDetail->avatar = get_gravatar($user->email);


            if($userDetail->hasChanged()) {
                $userDetailModel->save($userDetail);
            }

            session()->setFlashdata('msg_success', 'Benutzer gespeichert.');


            // Zusätzliche Berechtigungen setzen.
            // Superadmin, Admin und User sind da nicht erlaubt.
            $selectedRights = $this->request->getPost('right');
            foreach(service('settings')->get('AuthGroups.groups') as $key => $group){
                if(!in_array($key, ['superadmin','admin','user'])){
                    if($key == $selectedRights){
                        $user->addGroup($key);
                    } else {
                        $user->removeGroup($key);
                    }
                }
            }
            // Hauptgruppe wie Superadmin,admin und user setzen.
            // Hier kann immer nur eine Gruppe aktiv sein.
            $selectedGroup = $this->request->getPost('group');
            foreach(service('settings')->get('AuthGroups.groups') as $key => $group){
                if(in_array($key, ['superadmin','admin','user'])){
                    if($key == $selectedGroup){
                        $user->addGroup($key);
                    } else {
                        $user->removeGroup($key);
                    }
                }
            }

            
            return redirect()->route('user.index');
            
            

        }



        return view('admin/user/edit', [
            'user' => $user,
            'detail' => $userDetail
        ]);
    }

    public function add()
    {

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $usernameRules            = config('Auth')->usernameValidationRules;
            $usernameRules['rules'][] = sprintf(
                'is_unique[%s.username]',
                $this->tables['users']
            );

            $emailRules            = config('Auth')->emailValidationRules;
            $emailRules['rules'][] = sprintf(
                'is_unique[%s.secret]',
                $this->tables['identities']
                
            );
        
            $rules = [
                'username' => $usernameRules,
                'email' => $emailRules,
                'group'    => [
                    'rules' => 'required'
                ],
                'firstname'    => [
                    'rules' => 'required'
                ],
                'lastname'    => [
                    'rules' => 'required'
                ]
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Bitte fülle die erforderlichen Felder aus');
            }

            $userGroup = null;

            $rndPw = createRandomPassword(12);

            $userModel = model('UserModel');
            $user = new User($this->request->getPost(['username', 'email']));
            $user->password = $rndPw;
            $userModel->save($user);

            $user = $userModel->findById($userModel->getInsertID());

            $user->activate();


           $userDetail = new UserDetails();
           $userDetail->user_id = $user->id;
           $userDetail->firstname = $this->request->getPost('firstname');
           $userDetail->lastname = $this->request->getPost('lastname');
           $userDetail->department = $this->request->getPost('department');
           $userDetail->phone = $this->request->getPost('phone');
           $userDetail->avatar = get_gravatar($user->email);


           if($userDetail->hasChanged()) {
               model('UserDetailsModel')->save($userDetail);
           }


           // Zusätzliche Berechtigungen setzen.
           // Superadmin, Admin und User sind da nicht erlaubt.
            $selectedRights = $this->request->getPost('right');
            foreach(service('settings')->get('AuthGroups.groups') as $key => $group){
                if(!in_array($key, ['superadmin','admin','user'])){
                    if($key == $selectedRights){
                        if(($group['isAdmin'] && auth()->user()->can('user.manage-admins')) OR !$group['isAdmin']){
                            $user->addGroup($key);
                        }
                        else{
                            $user->addGroup('user');
                        }

                    }
                }
            }
            // Hauptgruppe wie Superadmin,admin und user setzen.
           // Hier kann immer nur eine Gruppe aktiv sein.
            $selectedGroup = $this->request->getPost('group');
            foreach(service('settings')->get('AuthGroups.groups') as $key => $group){
               if(in_array($key, ['superadmin','admin','user'])){
                   if($key == $selectedGroup){
                       $user->addGroup($key);
                   }
               }
            }


            $email = emailer()->setFrom(setting('Email.fromEmail'), setting('Email.fromName') ?? '');
            $email->setTo($user->email);
            $email->setSubject("Neuer Benutzer");
            $email->setMessage(view('templates/email/new_user_email.php', [
                'username' => $user->username,
                'email' => $user->email,
                'password' => $rndPw]));
            if ($email->send(false) === false) {
                session()->setFlashdata('msg_warning', 'Benutzer erfolgreich angelegt jedoch konnte die E-Mail nicht versendet werden. Siehe in den Logs.');
                //throw new RuntimeException("Cannot send email \n" . $email->printDebugger(['headers']));
            } else {
                session()->setFlashdata('msg_success', 'Benutzer erfolgreich angelegt und wurde per Mail benachrigt.');
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
            $data['message'] = "Du kannst dich selbst nicht löschen.";
        }
        else{
            if(empty($user)){
                $data['message'] = "Der Benutzer wurde nicht gefunden.";
            } else {
                $deleted = $userModel->delete($user->id, true);
                if($deleted){
                    $data['success'] = 1;
                } else {
                    $data['message'] = "Fehler beim Lsöchen des Benutzers";
                }
            }
        }

        


        return $this->response->setJSON($data);
    }


}