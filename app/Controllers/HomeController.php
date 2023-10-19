<?php

namespace App\Controllers;

use App\Libraries\AbacusConnector;
use App\Models\InvoiceModel;;
use App\Models\WebsiteModel;
use App\Models\CustomerModel;
use App\Models\ProjectModel;
use CodeIgniter\I18n\Time;

class HomeController extends BaseController
{
    public function index()
    {

        $count = [];

        $websiteModel = new WebsiteModel();
        $count['website'] = $websiteModel->countAllResults();

        $customerModel = new CustomerModel();
        $count['customer'] = $customerModel->countAllResults();

        $projectModel = new ProjectModel();
        $count['project'] = $projectModel->countAllResults();

        $invoiceModel = new InvoiceModel();
        $count['invoice'] = $invoiceModel->countAllResults();

        return view('home', [
            'count' => $count,
            'last_active' => model('UserModel')->lastActiveUser()
        ]);
    }

    public function changelog()
    {
        $parser = new \Parsedown();

        $file = ROOTPATH . 'CHANGELOG.md';
        $content = file_get_contents($file);
        return view('changelog',[
            'changelog' => $parser->setBreaksEnabled(true)->text($content)
        ]);
    }

    public function feedback(){

        $rules = [
            'feedback' => 'required'
        ];

        if (! $this->validate($rules))
        {
            session()->setFlashdata('msg_error', 'Für ein Feedback musst du eine Nachricht eingeben.');
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $users = model('UserModel')->findAll();

        foreach($users as $user){
            if(!empty($user->email) AND $user->inGroup('superadmin')){
                $mailReceiver[] = $user->email;
            }

        }

        $parser = new \Parsedown();

        $email = emailer()->setFrom(setting('Email.fromEmail'), profile()->firstname . ' '. profile()->lastname);
        $email->setTo($mailReceiver);
        $email->setSubject("Feedback auf BEBV-Tools");
        $email->setMessage(view('templates/email/sendmail.php', [
            'betreff' => 'Feedback auf BEBV-Tools',
            'text' => $parser->setBreaksEnabled(true)->text($this->request->getPost('feedback'))]));
        if ($email->send(false)) {
            session()->setFlashdata('msg_success', 'Feedback wurde versendet.');
        }

        return redirect()->route('home');
    }
}