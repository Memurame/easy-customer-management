<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AbaNewsletterController extends BaseController
{
    public function index()
    {
        $addressModel = model('AbaAddressModel');

        $addresses = $addressModel
            ->where('newsletter_active', 1)
            ->where('email IS NOT', NULL)
            ->groupBy('email')
            ->findAll();

        

       


        return view('newsletter/index', [
            'addresses'  => $addresses
        ]);
    }

    public function edit($id){
        $abaAddressModel = model('AbaAddressModel');

        $address = $abaAddressModel->find($id);

        if(!$address){
            session()->setFlashdata('msg_error', 'Der ausgewählte Empfänger wurde nicht gefunden.');
            return redirect()->route('bewsletter.index');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'email' => 'required'
            ];

            if (! $this->validate($rules))
            {
                session()->setFlashdata('msg_error', 'Bitte fülle die erforderlichen Felder aus');
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }


            $address->email = $this->request->getPost('email');
            $address->firstname = $this->request->getPost('firstname') ?? NULL;
            $address->lastname = $this->request->getPost('lastname') ?? NULL;


            if($address->hasChanged()){
                $abaAddressModel->save($address);
                session()->setFlashdata('msg_success', 'Empfänger gespeichert.');
            } else {
                session()->setFlashdata('msg_info', 'Es wurden keine änderungen erkannt.');
            }
            

            return redirect()->route('newsletter.index');

        }


        return view('newsletter/edit', [
            'address'  => $address
        ]);
    }
}
