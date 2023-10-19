<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\UserDetails;
use App\Models\UserDetailsModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Entities\User;
use Psr\Log\LoggerInterface;

class ProfileController extends BaseController
{
    private array $tables;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger,
    ): void {
        parent::initController($request, $response, $logger);

        /** @var Auth $authConfig */
        $authConfig = config("Auth");
        $this->tables = $authConfig->tables;
    }
    public function index()
    {
        $user = auth()->user();

        return view("profile/account", [
            "user" => $user,
        ]);
    }

    public function password()
    {
        return view("profile/password", [
            "user" => auth()->user(),
        ]);
    }

    public function updateProfile()
    {
        $user = auth()->user();
        $userModel = model("UserModel");
        $userdetailModel = model("UserDetailsModel");

        $usernameRules            = config('Auth')->usernameValidationRules;
            $usernameRules['rules'][] = sprintf(
                'is_unique[%s.username,id, %s]',
                $this->tables['users'],
                user_id()
            );

            $emailRules            = config('Auth')->emailValidationRules;
            $emailRules['rules'][] = sprintf(
                'is_unique[%s.secret,id, %s]',
                $this->tables['identities'],
                user_id()
                
            );

        $rules = [
            "username" =>$usernameRules,
            "email" => $emailRules,
            "firstname" => "required",
            "lastname" => "required",
        ];

        $rules_msg = [
            "username" => [
                "is_unique" => "Dieser Benutzername existiert bereits",
            ],
            "email" => ["is_unique" => "Diese Adresse existiert bereits"],
        ];

        if (!$this->validate($rules, $rules_msg)) {
            return redirect()
                ->back()
                ->withInput()
                ->with("errors", $this->validator->getErrors())
                ->with(
                    "msg_error",
                    "Fehler beim Speichern der Benutzerangaben",
                );
        }

        $user->username = $this->request->getPost("username");
        $user->email = $this->request->getPost("email");

        $userdetail = $userdetailModel->find(auth()->id());
        $userdetail->firstname = $this->request->getPost("firstname");
        $userdetail->lastname = $this->request->getPost("lastname");
        $userdetail->department = $this->request->getPost("department");
        $userdetail->phone = $this->request->getPost("phone");
        $userdetail->avatar = get_gravatar($user->email);

        if ($user->hasChanged()) {
            $userModel->save($user);
        }
        if ($userdetail->hasChanged()) {
            $userdetailModel->save($userdetail);
        }

        return redirect()
            ->to(route_to("profile.index"))
            ->with("msg_success", "Profil wurde aktualisiert");
    }

    public function updatePassword()
    {
        $user = auth()->user();
        $userModel = model(UserModel::class);

        $auth = service("authentication");

        $rules = [
            "password" => "required|strong_password[]",
            "password-confirm" => "required|matches[password]",
        ];
        $rules_msg = [
            "password-confirm" => [
                "matches" => "Das Password stimmt nicht überein",
            ],
        ];

        if (!$this->validate($rules, $rules_msg)) {
            return redirect()
                ->back()
                ->withInput()
                ->with("errors", $this->validator->getErrors())
                ->with("msg_error", "Fehler beim ändern des Passwortes");
        }

        /*
        if (! auth()->check(['email' => $user->email, 'password' => $this->request->getPost('password-old')])->isOK())
        {
            return redirect()->back()->withInput()
                ->with('msg_error', 'Das aktuelle Passwort scheint nicht korrekt zu sein.');
        }
        */
        $user->password = $this->request->getPost("password");
        if (!$userModel->save($user)) {
            return redirect()
                ->back()
                ->withInput()
                ->with("errors", $this->validator->getErrors())
                ->with(
                    "msg_error",
                    "Es ist ein Fehler beim Speichern aufgetretten",
                );
        }

        return redirect()
            ->to(route_to("profile.password"))
            ->with("msg_success", "Passwort wurde aktualisiert");
    }
}