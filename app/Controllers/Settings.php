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
                'title' => 'required',
                'smtp_host' => 'required',
                'smtp_user' => 'required',
                'smtp_port' => 'required',
                'smtp_secure' => 'required',

            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            service('settings')->set('App.siteName', $this->request->getPost('title'));
            service('settings')->set('Email.fromName', $this->request->getPost('from_name'));
            service('settings')->set('Email.fromEmail', $this->request->getPost('from_email'));
            service('settings')->set('Email.SMTPHost', $this->request->getPost('smtp_host'));
            service('settings')->set('Email.SMTPUser', $this->request->getPost('smtp_user'));
            
            if($this->request->getPost('smtp_pass')){
                service('settings')->set('Email.SMTPPass', $this->request->getPost('smtp_pass'));
            }
            
            service('settings')->set('Email.SMTPPort', $this->request->getPost('smtp_port'));
            service('settings')->set('Email.SMTPCrypto', $this->request->getPost('smtp_secure'));

            return redirect()->route('admin.settings');
        }

        return view('settings');
    }
}