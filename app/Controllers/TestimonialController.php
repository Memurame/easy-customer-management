<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TestimonialFormModel;
use App\Models\TestimonialModel;
use App\Entities\Testimonial;

class TestimonialController extends BaseController
{
    public function form()
    {
        if(!$this->request->getGet('form')){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $formModel = new TestimonialFormModel();
        $form = $formModel->where('token', $this->request->getGet('form'))->first();
        if(!$form OR !$form->active){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }


        if($_SERVER['REQUEST_METHOD'] == 'POST') {


            $rules = [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required'
            ];
            foreach (cache('testimonial_' . $form->id . '_required') as $required) {
                $rules = array_merge($rules, [$required => 'required']);
            }

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Es wurden nicht alle erforderlichen Felder ausgefüllt!');
            }

            $testimonial = new Testimonial($this->request->getPost([
                'firstname', 'lastname', 'email'
            ]));

            $data = [];
            foreach (cache('testimonial_' . $form->id . '_fieldNames') as $fieldName) {
                $data[$fieldName] = $this->request->getPost($fieldName) ?? null;
            }

            $testimonial->data = json_encode($data);
            $testimonial->form = $form->id;

            $testimonialModel = new TestimonialModel();
            $testimonialModel->save($testimonial);

            $lastInsertID = $testimonialModel->getInsertID();
            $testimonial = $testimonialModel->find($lastInsertID);

            return redirect()->back()->with('msg_success', lang('Das Formular wurde erfolgreich übermittelt. Vielen Dank.'));
        }



        return view('testimonial/form', [
            'formFields' => cache('testimonial_'.$form->id.'_fields'),
            'form' => $form
        ]);
    }

    public function index()
    {
        $testimonialModel = new TestimonialModel();
        $testimonials = $testimonialModel->findAll();


        return view('testimonial/index', [
            'testimonials'  => $testimonials
        ]);
    }

    public function edit($id)
    {
        $testimonialModel = new TestimonialModel();
        $testimonial = $testimonialModel->find($id);

        $testimonial->dataArray = json_decode($testimonial->data);

        $formModel = new TestimonialFormModel();
        $form = $formModel->find($testimonial->form);
        if(!$form){
            return redirect()->route('testimonial.index')->with('msg_error', 'Das Formular zu diesem Eintrag existiert nicht mehr.');
        }

        

        if($_SERVER['REQUEST_METHOD'] == 'POST') {


            $rules = [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required'
            ];
            foreach (cache('testimonial_' . $form->id . '_required') as $required) {
                $rules = array_merge($rules, [$required => 'required']);
            }

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Es wurden nicht alle erforderlichen Felder ausgefüllt!');
            }


            $data = [];
            foreach (cache('testimonial_' . $form->id . '_fieldNames') as $fieldName) {
                $data[$fieldName] = $this->request->getPost($fieldName) ?? null;
            }

            $testimonial->firstname = $this->request->getPost('firstname');
            $testimonial->lastname = $this->request->getPost('lastname');
            $testimonial->email = $this->request->getPost('email');
            $testimonial->data = json_encode($data);

            
            if ($testimonial->hasChanged()){
                $testimonialModel = new TestimonialModel();
                if (! $testimonialModel->save($testimonial)){
                    return redirect()->back()->withInput()->with('msg_errors', $testimonialModel->errors());
                }
                return redirect()->back()->with('msg_success', lang('Das Formular wurde erfolgreich übermittelt. Vielen Dank.'));
            }

            return redirect()->route('testimonial.index')->with('msg_info', lang('Es wurden keine Änderungen erkannt.'));
        }

        return view('testimonial/edit', [
            'testimonial'  => $testimonial,
            'formFields' => cache('testimonial_'.$form->id.'_fields')
        ]);
    }
}

