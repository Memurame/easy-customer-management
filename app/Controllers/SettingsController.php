<?php

namespace App\Controllers;


class SettingsController extends BaseController
{
    public function setting1()
    {

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $rules = [
                'title' => 'required'

            ];
            

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            service('settings')->set('Site.title', $this->request->getPost('title'));
            service('settings')->set('App.defaultLocale', $this->request->getPost('defaultLocale'));

            $imgLogin = $this->request->getFile('image_login');
            $imgLogo = $this->request->getFile('image_logo');

            if ($imgLogin->isValid() AND !$imgLogin->hasMoved()) {
                $newName = $imgLogin->getRandomName();
                $imgLogin->move(ROOTPATH.'public/uploads/login', $newName);
                service('settings')->set('Site.loginImage', 'uploads/login/' . $newName);
            }
            if ($imgLogo->isValid() AND !$imgLogo->hasMoved()) {
                $newName = $imgLogo->getRandomName();
                $imgLogo->move(ROOTPATH.'public/uploads/logo', $newName);
                service('settings')->set('Site.logo', 'uploads/logo/' . $newName);
            }


            return redirect()->route('setting.1')->with('msg_success', 'Einstellungen wurden gespeichert');
        }

        return view('admin/settings/1');
    }
    public function setting2()
    {

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $rules = [
                'company_name' => 'required',
                'company_street' => 'required',
                'company_postcode' => 'required',
                'company_city' => 'required',
                'company_phone' => 'required',
                'company_mail' => 'required',
                'iban' => 'required'

            ];

            if (! $this->validate($rules))
            {
                return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('msg_error', 'Bitte alle erforderlichen Felder ausfüllen');
            }

            service('settings')->set('Company.name', $this->request->getPost('company_name'));
            service('settings')->set('Company.street', $this->request->getPost('company_street'));
            service('settings')->set('Company.postcode', $this->request->getPost('company_postcode'));
            service('settings')->set('Company.city', $this->request->getPost('company_city'));
            service('settings')->set('Company.phone', $this->request->getPost('company_phone'));
            service('settings')->set('Company.mail', $this->request->getPost('company_mail'));
            service('settings')->set('Company.website', $this->request->getPost('company_website'));
            service('settings')->set('Company.mwst', $this->request->getPost('company_mwst'));
            service('settings')->set('Company.iban', $this->request->getPost('iban'));
            service('settings')->set('Company.payment_deadline', $this->request->getPost('payment_deadline'));
            service('settings')->set('Company.invoice', $this->request->getPost('invoice'));
            service('settings')->set('Company.invoice_qr', $this->request->getPost('invoice_qr'));
            service('settings')->set('Company.qriban', $this->request->getPost('qriban'));
            service('settings')->set('Company.qriban_reference', $this->request->getPost('qriban_reference'));

            return redirect()->route('setting.2')->with('msg_success', 'Einstellungen wurden gespeichert');
        }

        return view('admin/settings/2');
    }

    public function setting3()
    {

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $rules = [
                'from_email' => 'required',
                'from_name' => 'required'
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

            return redirect()->route('setting.3')->with('msg_success', 'Einstellungen wurden gespeichert');
        }

        return view('admin/settings/3');
    }

    public function setting4()
    {

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            service('settings')->set('Auth.allowRegistration', boolval($this->request->getPost('allowRegistration')));

            return redirect()->route('setting.4')->with('msg_success', 'Einstellungen wurden gespeichert');
        }

        return view('admin/settings/4');
    }

    public function setting5()
    {

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            service('settings')->set('Abacus.url', $this->request->getPost('abacus_url'));
            service('settings')->set('Abacus.clientId', $this->request->getPost('abacus_clientid'));
            if($this->request->getPost('abacus_clientsecret')){
                service('settings')->set('Abacus.clientSecret', $this->request->getPost('abacus_clientsecret'));
            }
            service('settings')->set('Abacus.mandant', $this->request->getPost('abacus_mandant'));

            return redirect()->route('setting.2')->with('msg_success', 'Einstellungen wurden gespeichert');
        }

        return view('admin/settings/5');
    }
}