<?php

namespace App\Controllers;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


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

        if($_SERVER['REQUEST_METHOD'] == 'POST'){


            $rules = [
                'username' => [
                    'label' => 'Auth.username',
                    'rules' => array_merge(
                        config('AuthSession')->usernameValidationRules,
                        [sprintf('is_unique[%s.username, id, %s]', $this->tables['users'], $user->id)]
                    ),
                ],
                'email' => [
                    'label' => 'Auth.email',
                    'rules' => array_merge(
                        config('AuthSession')->emailValidationRules,
                        [sprintf('is_unique[%s.secret, user_id, %s]', $this->tables['identities'], $user->id)]
                    ),
                ],
                'group'    => [
                    'rules' => 'required'
                ]
            ];

            if($this->request->getPost('password') == 'smtp'){
                $rules = array_merge($rules, [
                    'password' => 'required|strong_password'
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
            session()->setFlashdata('msg_success', 'Benutzer gespeichert.');
            
            
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
                'username' => [
                    'label' => 'Auth.username',
                    'rules' => array_merge(
                        config('AuthSession')->usernameValidationRules,
                        [sprintf('is_unique[%s.username]', $this->tables['users'])]
                    ),
                ],
                'email' => [
                    'label' => 'Auth.email',
                    'rules' => array_merge(
                        config('AuthSession')->emailValidationRules,
                        [sprintf('is_unique[%s.secret]', $this->tables['identities'])]
                    ),
                ],
                'password' => [
                    'label' => 'Auth.password',
                    'rules' => 'required|strong_password',
                ],
                'group'    => [
                    'rules' => 'required'
                ]
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Bitte fülle die erforderlichen Felder aus');
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

            if($this->request->getPost('sendmail')){
                $email = emailer()->setFrom(setting('Email.fromEmail'), setting('Email.fromName') ?? '');
                $email->setTo($user->email);
                $email->setSubject("Neuer Benutzer");
                $email->setMessage(view('email/new_user_email.php', [
                    'username' => $user->username,
                    'email' => $user->email,
                    'password' => $this->request->getPost('password')]));
                if ($email->send(false) === false) {
                    throw new RuntimeException("Cannot send email \n" . $email->printDebugger(['headers']));
                } else {
                    session()->setFlashdata('msg_success', 'Benutzer erfolgreich angelegt und wurde per Mail benachrigt.');
                }
            } else {
                session()->setFlashdata('msg_success', 'Benutzer erfolgreich angelegt.');
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