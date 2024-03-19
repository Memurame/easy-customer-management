<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TestimonialFormModel;
use App\Models\TestimonialModel;
use App\Entities\Testimonial;
use App\Entities\Mail;

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

        
        $captcha = false;
        if(!empty(service('settings')->get('Site.cfSiteKey')) && !empty(service('settings')->get('Site.cfSecretKey'))){
            $captcha = true;
        }


        if($_SERVER['REQUEST_METHOD'] == 'POST') {


            $rules = [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required'
            ];

            if($captcha){
                $rules = array_merge($rules, ['cf-turnstile-response' => 'required|verifycaptcha']);
            }

            foreach (cache('testimonial_' . $form->id . '_required') as $required) {
                if(in_array($required, cache('testimonial_' . $form->id . '_files'))){
                    $rules = array_merge($rules, [$required => 'uploaded['.$required.']']);
                } else {
                    $rules = array_merge($rules, [$required => 'required']);
                }
                
            }

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Es wurden nicht alle erforderlichen Felder ausgefüllt!');
            }


            $testimonial = new Testimonial($this->request->getPost([
                'firstname', 'lastname', 'email'
            ]));

            $data = [];
            $log = [];
            foreach (cache('testimonial_' . $form->id . '_fields') as $fieldName => $fieldPref) {
                if($fieldPref['type'] == 'upload'){
                    $image = $this->request->getFile($fieldName);
                    
                    if ($image->getSize() > 0 AND $image->isValid() AND !$image->hasMoved()) {
                        $newName = $image->getRandomName();
                        $image->move(ROOTPATH.'public/uploads/testimonial/', $newName);
                        $data[$fieldName] = 'uploads/testimonial/' . $newName;
                    }
                }
                else {
                    $data[$fieldName] = $this->request->getPost($fieldName) ?? null;
                }
                if(isset($fieldPref['log']) AND $fieldPref['log'] == true){
                    $log[$fieldName]['ip'] = $_SERVER['REMOTE_ADDR'];
                    $log[$fieldName]['time'] = date('Y.m.d - H:i');
                    $log[$fieldName]['browser'] = $_SERVER['HTTP_USER_AGENT'];
                }
            }

            $testimonial->log = json_encode($log);
            $testimonial->data = json_encode($data);
            $testimonial->form = $form->id;
            $testimonial->active = 1;
            $testimonial->token_view = bin2hex(time() . random_bytes(20));
            $testimonial->token_edit = bin2hex(time() . random_bytes(20));

            $testimonialModel = new TestimonialModel();
            $testimonialModel->save($testimonial);

            $lastInsertID = $testimonialModel->getInsertID();
            $testimonial = $testimonialModel->find($lastInsertID);


            $parser = new \Parsedown();


            if(!empty($form->mail_confirmation)){
                $mail = new Mail();
                $mail->receiver = $this->request->getVar("email");
                $mail->name = $this->request->getVar("firstname") . ' ' . $this->request->getVar("lastname");
                $mail->subject = "Formular Mitgliederportrait BEBV";
                $mail->text = $form->mail_confirmation;
                $mail->type = "queue";
                model("MailModel")->save($mail);
            }

            if(!empty($form->mail_new)){
                foreach(json_decode($form->notify, true) as $notify){

                    $text_find = array('[_URL_PREVIEW_]', '[_URL_EDIT_]');
                    $text_replace = array(
                        base_url(route_to('testimonial.preview', $testimonial->token_view)),
                        base_url(route_to('testimonial.edit', $testimonial->id))
                    );
                    
                    $mail = new Mail();
                    $mail->receiver = $form->getNotifyMail($notify);
                    $mail->name = $form->getNotifyMail($notify);
                    $mail->subject = "Neues Mitgliederportrait";
                    $mail->text = str_replace($text_find, $text_replace, $form->mail_new);
                    $mail->type = "queue";
                    model("MailModel")->save($mail);
        
                }
            }

            

            if(!empty($form->message_success)){
                return view('testimonial/register/success', [
                    'form' => $form
                ]);
            } else {
                return redirect()->back()->with('msg_success', lang('Das Formular wurde erfolgreich übermittelt. Vielen Dank.'));
            }
            
        }



        return view('testimonial/register/index', [
            'formFields' => cache('testimonial_'.$form->id.'_raw'),
            'form' => $form,
            'captcha' =>  $captcha
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
        $testimonial->logArray = json_decode($testimonial->log);

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

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Es wurden nicht alle erforderlichen Felder ausgefüllt!');
            }


            $data = json_decode($testimonial->data, true);
            
            foreach (cache('testimonial_' . $form->id . '_fields') as $fieldName => $fieldPref) {
                if(!isset($fieldPref['editable']) OR $fieldPref['editable'] == true){
                    if($fieldPref['type'] == 'upload'){
                        $image = $this->request->getFile($fieldName);
                        
                        if ($image->getSize() > 0 AND $image->isValid() AND !$image->hasMoved()) {
                            $newName = $image->getRandomName();
                            $image->move(ROOTPATH.'public/uploads/testimonial/', $newName);
                            $data[$fieldName] = 'uploads/testimonial/' . $newName;
                        }
                    }
                    else {
                        $data[$fieldName] = $this->request->getPost($fieldName) ?? null;
                    }
                }
            }
            

            $testimonial->firstname = $this->request->getPost('firstname');
            $testimonial->lastname = $this->request->getPost('lastname');
            $testimonial->email = $this->request->getPost('email');
            $testimonial->data = json_encode($data);
            $testimonial->active = $this->request->getPost('active');
            unset($testimonial->dataArray);
            unset($testimonial->logArray);


            if($this->request->getPost('active') == 2 && $this->request->getPost('notify')){
                $text_find = array(
                    '[_URL_]',
                    '[_TOKEN_]'
                );
                $text_replace = array(
                    base_url(route_to('testimonial.view', $testimonial->token_view)),
                    $testimonial->token_view
                );

                if(!empty($form->mail_approved)){
                    $mail = new Mail();
                    $mail->receiver = $this->request->getVar("email");
                    $mail->name = $this->request->getVar("firstname") . ' ' . $this->request->getVar("lastname");
                    $mail->subject = "Freischaltung Mitgliederportrait BEBV";
                    $mail->text = str_replace($text_find, $text_replace, $form->mail_approved);
                    $mail->type = "queue";
                    model("MailModel")->save($mail);
                }
            }

            
            if ($testimonial->hasChanged()){
                $testimonialModel = new TestimonialModel();
                if (! $testimonialModel->save($testimonial)){
                    return redirect()->back()->withInput()->with('msg_errors', $testimonialModel->errors());
                }
                return redirect()->route('testimonial.index')->with('msg_success', lang('Das Formular wurde erfolgreich übermittelt. Vielen Dank.'));
            }

            return redirect()->route('testimonial.index')->with('msg_info', lang('Es wurden keine Änderungen erkannt.'));
        }

        return view('testimonial/edit', [
            'testimonial'  => $testimonial,
            'formFields' => cache('testimonial_'.$form->id.'_raw'),
            'log' => cache('testimonial_'.$form->id.'_log')
        ]);
    }

    public function view($token){
        $testimonialModel = new TestimonialModel();
        $testimonial = $testimonialModel->where('token_view', $token)->first();
        if(!$testimonial or $testimonial->active != 2){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $formModel = new TestimonialFormModel();
        $form = $formModel->find($testimonial->form);
        if(!$form){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $testimonial->dataArray = json_decode($testimonial->data, true);

        return view('testimonial/public/index',[
            'testimonial' => $testimonial,
            'formFields' => cache('testimonial_'.$form->id.'_fields'),
            'preview' => false
        ]);
    }

    public function preview($token){
        $testimonialModel = new TestimonialModel();
        $testimonial = $testimonialModel->where('token_view', $token)->first();
        if(!$testimonial or !auth()->user()->can("testimonial.preview")){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $formModel = new TestimonialFormModel();
        $form = $formModel->find($testimonial->form);
        if(!$form){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $testimonial->dataArray = json_decode($testimonial->data, true);

        return view('testimonial/public/index',[
            'testimonial' => $testimonial,
            'formFields' => cache('testimonial_'.$form->id.'_fields'),
            'preview' => true
        ]);
    }
}

