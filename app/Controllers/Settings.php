<?php

namespace App\Controllers;


class Settings extends BaseController
{
    public function index()
    {

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $rules = [
                'from_email' => 'required',
                'from_name' => 'required',
                'title' => 'required'

            ];

            if($this->request->getPost('protocol') == 'smtp'){
                $rules = array_merge($rules, [
                    'smtp_host' => 'required',
                    'smtp_user' => 'required',
                    'smtp_port' => 'required',
                    'smtp_secure' => 'required',
                ]);
            }
            

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            service('settings')->set('App.siteName', $this->request->getPost('title'));
            service('settings')->set('App.defaultLocale', $this->request->getPost('defaultLocale'));

            service('settings')->set('Email.protocol', $this->request->getPost('protocol'));
            service('settings')->set('Email.fromName', $this->request->getPost('from_name'));
            service('settings')->set('Email.fromEmail', $this->request->getPost('from_email'));
            service('settings')->set('Email.SMTPHost', $this->request->getPost('smtp_host'));
            service('settings')->set('Email.SMTPUser', $this->request->getPost('smtp_user'));
            if($this->request->getPost('smtp_pass')){
                service('settings')->set('Email.SMTPPass', $this->request->getPost('smtp_pass'));
            }
            service('settings')->set('Email.SMTPPort', $this->request->getPost('smtp_port'));
            service('settings')->set('Email.SMTPCrypto', $this->request->getPost('smtp_secure'));

            service('settings')->set('Auth.allowRegistration', boolval($this->request->getPost('allowRegistration')));


            return redirect()->route('admin.settings')->with('msg_success', 'Einstellungen wurden gespeichert');
        }

        return view('settings');
    }
}