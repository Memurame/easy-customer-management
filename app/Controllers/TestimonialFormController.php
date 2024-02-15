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
                'title', 'description'
            ]));



            $form->data = preg_replace('/\s*\R\s*/', ' ', trim($this->request->getPost('json')));
            $form->token = bin2hex(random_bytes(20));
            $form->active = true;

            $formModel = new TestimonialFormModel();
            $formModel->save($form);

            return redirect()->route('testimonialForm.index')->with('msg_success', lang('Das Formular wurde erfolgreich übermittelt. Vielen Dank.'));
        }

        return view('testimonial_form/add');
    }

    public function edit($id)
    {

        $formModel = new TestimonialFormModel();
        $form = $formModel->find($id);

        if(!$form){
            return redirect()->route('testimonialForm.index')->with('msg_error', 'Das Formular existiert nicht.');
        }



        if($_SERVER['REQUEST_METHOD'] == 'POST') {


            $rules = [
                'title' => 'required',
                'description' => 'required',
                'json' => 'required'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Es wurden nicht alle erforderlichen Felder ausgefüllt!');
            }


            $form->title = $this->request->getPost('title');
            $form->description = $this->request->getPost('description');
            $form->data = preg_replace('/\s*\R\s*/', ' ', trim($this->request->getPost('json')));

            $formModel->save($form);

            return redirect()->route('testimonialForm.index')->with('msg_success', lang('Das Formular wurde erfolgreich übermittelt. Vielen Dank.'));
        }

        return view('testimonial_form/edit', [
            'form' => $form
        ]);
    }
}

