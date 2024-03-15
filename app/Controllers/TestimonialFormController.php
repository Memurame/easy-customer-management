<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TestimonialFormModel;
use App\Entities\TestimonialForm;

class TestimonialFormController extends BaseController
{
    public function index()
    {

        $formModel = new TestimonialFormModel();
        $forms = $formModel->findAll();

        return view('testimonial_form/index', [
            'testimonialForms'  => $forms
        ]);
    }

    public function add()
    {

        $users = model('UserModel')->findAll();
        if($_SERVER['REQUEST_METHOD'] == 'POST') {


            $rules = [
                'title' => 'required',
                'description' => 'required',
                'json' => 'required'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Es wurden nicht alle erforderlichen Felder ausgefüllt!');
            }

            $form = new TestimonialForm($this->request->getPost([
                'title', 'description', 'message_success', 'mail_confirmation', 'mail_confirmation',
                'mail_approved', 'mail_rejected', 'mail_new'
            ]));



            $form->data = preg_replace('/\s*\R\s*/', ' ', trim($this->request->getPost('json')));
            $form->token = bin2hex(random_bytes(20));
            $form->active = true;
            $form->notify = ($this->request->getPost('notify')) ? json_encode($this->request->getPost('notify')) : '[]';

            $formModel = new TestimonialFormModel();
            $formModel->save($form);

            return redirect()->route('testimonialForm.index')->with('msg_success', lang('Das Formular wurde erfolgreich übermittelt. Vielen Dank.'));
        }

        return view('testimonial_form/add', [
            'users' => $users
        ]);
    }

    public function edit($id)
    {

        $formModel = new TestimonialFormModel();
        $form = $formModel->find($id);

        if(!$form){
            return redirect()->route('testimonialForm.index')->with('msg_error', 'Das Formular existiert nicht.');
        }

        $users = model('UserModel')->findAll();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $rules = [
                'title' => 'required',
                'description' => 'required',
                //'json' => 'required'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Es wurden nicht alle erforderlichen Felder ausgefüllt!');
            }


            $form->title = $this->request->getPost('title');
            $form->description = $this->request->getPost('description');
            $form->message_success = $this->request->getPost('message_success');
            $form->mail_confirmation = $this->request->getPost('mail_confirmation');
            $form->mail_approved = $this->request->getPost('mail_approved');
            $form->mail_rejected = $this->request->getPost('mail_rejected');
            $form->mail_new = $this->request->getPost('mail_new');
            $form->notify = ($this->request->getPost('notify')) ? json_encode($this->request->getPost('notify')) : '[]';;
            //$form->data = preg_replace('/\s*\R\s*/', ' ', trim($this->request->getPost('json')));

            if($form->hasChanged()){
                $formModel->save($form);
            }
            

            return redirect()->route('testimonialForm.index')->with('msg_success', lang('Das Formular wurde erfolgreich übermittelt. Vielen Dank.'));
        }

        return view('testimonial_form/edit', [
            'form' => $form,
            'users' => $users
        ]);
    }
}

