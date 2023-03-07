<?php

namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\CustomerModel;
use App\Entities\Customer;

class Customers extends BaseController
{
    public function index()
    {
        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();


        return view('customer/index', [
            'customers' => $customers
        ]);
    }

    public function add()
    {
        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'contact_mail' => 'required',
                'contact_lastname' => 'required',
                'contact_firstname' => 'required',
                'status' => 'required',
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Bitte alle erforderlichen Felder ausfüllen');
            }

            $customer = new Customer($this->request->getPost());

            $customerModel = new CustomerModel();
            $customerModel->save($customer);

            session()->setFlashdata('msg_success', 'Kunde erfolgreich angelegt.');

            return redirect()->route('customer.index');

        }

        return view('customer/add', [

        ]);
    }

    public function edit($id)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if(!$customer){
            return redirect()->route('customer.index');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){


            $rules = [
                'contact_mail' => 'required',
                'contact_lastname' => 'required',
                'contact_firstname' => 'required',
                'status' => 'required',
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Bitte alle erforderlichen Felder ausfüllen');
            }

            $customer->company = $this->request->getPost('company');
            $customer->contact_firstname = $this->request->getPost('contact_firstname');
            $customer->contact_lastname = $this->request->getPost('contact_lastname');
            $customer->contact_mail = $this->request->getPost('contact_mail');
            $customer->contact_tel = $this->request->getPost('contact_tel');
            $customer->street = $this->request->getPost('street');
            $customer->postcode = $this->request->getPost('postcode');
            $customer->city = $this->request->getPost('city');
            $customer->customernumber = $this->request->getPost('customernumber');
            $customer->status = $this->request->getPost('status');
            $customer->notes = $this->request->getPost('notes');

            if($customer->hasChanged()){
                $customerModel->save($customer);
                session()->setFlashdata('msg_success', 'Kunde gespeichert.');
            } else {
                session()->setFlashdata('msg_info', 'Es wurden keine änderungen erkannt.');
            }
            

            return redirect()->route('customer.show', [$id]);

        }

        return view('customer/edit', [
            'customer' => $customer
        ]);
    }

    public function show($id)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);
        
        if(!$customer){
            return redirect()->route('customer.index');
        }

        $commentModel = new CommentModel();
        $comments = $commentModel->where('customer_id', $customer->id)->orderBy('id', 'desc')->findAll();

        return view('customer/show', [
            'customer' => $customer,
            'comments' => $comments
        ]);
    }

    public function apiDelete($id){
        $data = array();
        $data['success'] = 0;
        $data['token'] = csrf_hash();

        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if(empty($customer)){
            $data['error'] = "Kunde wurde nicht gefunden.";
        } else {
            $deleted = $customerModel->delete($customer->id);
            if($deleted){
                $data['success'] = 1;
            } else {
                $data['error'] = "Fehler beim Lsöchen der Webseite";
            }
        }


        return $this->response->setJSON($data);
    }

    
}
