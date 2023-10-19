<?php

namespace App\Controllers;

use App\Entities\CustomerContact;
use App\Models\CommentModel;
use App\Models\CustomerContactModel;
use App\Models\CustomerModel;
use App\Entities\Customer;

class CustomersContactController extends BaseController
{

    public function add()
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($this->request->getGet('customerId'));
        if(!$customer){
            session()->setFlashdata('msg_error', 'Der ausgewählte Kunde wurde nicht gefunden.');
            return redirect()->route('customer.index');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'firstname' => 'required',
                'lastname' => 'required',
                'typ' => 'required'
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Bitte alle erforderlichen Felder ausfüllen');
            }

            $customerContact = new CustomerContact($this->request->getPost());
            $customerContact->customer_id = $this->request->getGet('customerId');

            $customerContactModel = new CustomerContactModel();
            $customerContactModel->save($customerContact);

            session()->setFlashdata('msg_success', 'Kontakt erfolgreich angelegt.');

            return redirect()->route('customer.show', [$customer->id]);

        }

        return view('customer_contact/add', [
            'customer' => $customer
        ]);
    }

    public function edit($id)
    {
        $customerContactModel = new CustomerContactModel();
        $customerContact = $customerContactModel->find($id);

        if(!$customerContact){
            session()->setFlashdata('msg_error', 'Der ausgewählte Kontakt wurde nicht gefunden.');
            return redirect()->route('customer.show', [$id]);
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'firstname' => 'required',
                'lastname' => 'required',
                'typ' => 'required'
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Bitte alle erforderlichen Felder ausfüllen');
            }


            $customerContact->firstname = $this->request->getPost('firstname');
            $customerContact->lastname = $this->request->getPost('lastname');
            $customerContact->street = $this->request->getPost('street');
            $customerContact->postcode = $this->request->getPost('postcode');
            $customerContact->city = $this->request->getPost('city');
            $customerContact->mail = $this->request->getPost('mail');
            $customerContact->phone = $this->request->getPost('phone');
            $customerContact->typ = $this->request->getPost('typ');
            if($customerContact->hasChanged()){
                $customerContactModel->save($customerContact);
            } else {
                session()->setFlashdata('msg_info', 'Es wurden keine änderungen erkannt.');
            }


            session()->setFlashdata('msg_success', 'Kontakt erfolgreich gespeichert.');

            return redirect()->route('customer.show', [$customerContact->customer_id]);

        }

        return view('customer_contact/edit', [
            'contact' => $customerContact
        ]);
    }

    public function apiDelete($id){
        $data = array();
        $data['success'] = 0;
        $data['token'] = csrf_hash();

        $customerContactModel = new CustomerContactModel();
        $customerContact = $customerContactModel->find($id);

        if(empty($customerContact)){
            $data['message'] = "Kontakt wurde nicht gefunden.";
        } else {
            if($customerContact->isMainContact() OR $customerContact->isBillingContact()){
                $data['message'] = "Der Hauptkontakt und Rechnungskontakt können nicht gelöscht werden.";
            } else {
                $deleted = $customerContactModel->delete($customerContact->id);
                if($deleted){
                    $data['success'] = 1;
                } else {
                    $data['message'] = "Fehler beim Löschen des Kontaktes";
                }
            }




        }


        return $this->response->setJSON($data);
    }

    
}
