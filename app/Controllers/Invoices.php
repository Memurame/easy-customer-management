<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Entities\Invoice;
use App\Models\WebsiteModel;
use App\Entities\Website;
use App\Models\CustomerModel;
use App\Models\ProjectModel;

class Invoices extends BaseController
{
    public function index()
    {
        $invoiceModel = new InvoiceModel();
        $invoices = $invoiceModel->findAll();


        return view('invoice/index', [
            'invoices' => $invoices
        ]);
    }

    public function add()
    {

        $websiteModel = new WebsiteModel();
        $websites = $websiteModel->findAll();

        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();

        $projectModel = new ProjectModel();
        $projects = $projectModel->findAll();


        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'invoice' => 'required',
                'website_id' => 'required',
                'renew' => 'required',
                'paid' => 'required',
                'amount' => 'required'
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $invoice = new Invoice($this->request->getPost());
            $invoice->invoice = $this->request->getPost('invoice') ?: null;

            $invoiceModel = new InvoiceModel();
            $invoiceModel->save($invoice);

            return redirect()->route('invoice.index');

        }


        return view('invoice/add', [
            'projects' => $projects,
            'customers' => $customers,
            'websites' => $websites
        ]);
    }

    public function edit($id)
    {
        $invoiceModel = new InvoiceModel();
        $invoice = $invoiceModel->find($id);

        if(!$invoice){
            return redirect()->route('invoice.index');
        }

        $websiteModel = new WebsiteModel();
        $websites = $websiteModel->findAll();

        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();

        $projectModel = new ProjectModel();
        $projects = $projectModel->findAll();


        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'invoice' => 'required',
                'website_id' => 'required',
                'renew' => 'required',
                'paid' => 'required',
                'amount' => 'required'
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $invoice->invoice = $this->request->getPost('invoice') ?: null;
            $invoice->description = $this->request->getPost('description');
            $invoice->renew = $this->request->getPost('renew');
            $invoice->renew_interval = $this->request->getPost('renew_interval');
            $invoice->customer_id = $this->request->getPost('customer_id');
            $invoice->project_id = $this->request->getPost('project_id');
            $invoice->website_id = $this->request->getPost('website_id');
            $invoice->paid = $this->request->getPost('paid');
            $invoice->amount = $this->request->getPost('amount');
            $invoice->notes = $this->request->getPost('notes');


            if($invoice->hasChanged()){
                $invoiceModel->save($invoice);
            }
           

            return redirect()->route('invoice.index');

        }


        return view('invoice/edit', [
            'projects' => $projects,
            'customers' => $customers,
            'websites' => $websites,
            'invoice' => $invoice
        ]);
    }

    public function show($id)
    {
        $invoiceModel = new InvoiceModel();
        $invoice = $invoiceModel->find($id);
        
        if(!$invoice){
            return redirect()->route('invoice.index');
        }
        return view('invoice/show', [
            'invoice' => $invoice
        ]);
    }

    public function apiDelete($id){
        $data = array();
        $data['success'] = 0;
        $data['token'] = csrf_hash();

        $invoiceModel = new InvoiceModel();
        $invoice = $invoiceModel->find($id);

        if(empty($invoice)){
            $data['error'] = "Rechnung wurde nicht gefunden.";
        } else {
            $deleted = $invoiceModel->delete($invoice->id);
            if($deleted){
                $data['success'] = 1;
            } else {
                $data['error'] = "Fehler beim Lsöchen des Projekts";
            }
        }


        return $this->response->setJSON($data);
    }

    public function cron(){
        $invoiceModel = new InvoiceModel();
        

        $paymentTerm = strtotime('-30 days');
       
        /*
         * Auf überfällige Rechnungen prüfen
         */
        $invoices = $invoiceModel
            ->where('paid', 0)
            ->findAll();
        foreach($invoices as $key => $invoice){
            $invoiceDate = strtotime($invoice->invoice);
            if($invoiceDate <= $paymentTerm){
                $invoice->paid = 3;
                if($invoice->hasChanged()){
                    $invoiceModel->save($invoice);
                }
                /*$email = \Config\Services::email();
                $email->setTo('');
                $email->setSubject("Überfällige Rechnung - " . $invoice->description);
                $email->setMessage(view('email/overdue.php', [
                    'invoice' => $invoice]));
                $email->send();*/
            }
        }

         /*
         * Rechnungen welche automatisch Monatlich erneuert werden generieren und auf pendent setzen
         */
        $invoices = $invoiceModel
            ->where('renew', 1)
            ->where('renew_interval', 1)
            ->where('renewed', 0)
            ->findAll();

        foreach($invoices as $key => $invoice){
            $invoiceDate = strtotime($invoice->invoice);
            if(time() >= strtotime('+14 days', $invoiceDate)){

                $invoice->renewed = 1;
                if($invoice->hasChanged()){
                    $invoiceModel->save($invoice);
                }

                $invoice->id = null;
                $invoice->paid = 2;
                $invoice->renewed = 0;
                $invoice->invoice = date('Y.m.d', strtotime($invoice->invoice. '+1 months'));
                $invoiceModel->insert($invoice);


            }
        }

         /*
         * Rechnungen welche automatisch auf den 1. im Monat fällig sind generieren und auf pendent setzen
         */
        $invoices = $invoiceModel
            ->where('renew', 1)
            ->where('renew_interval', 2)
            ->where('renewed', 0)
            ->findAll();

        foreach($invoices as $key => $invoice){
            $invoiceDate = strtotime($invoice->invoice);
            if(date('d', time()) >= 14 && date('m', $invoiceDate) == date('m', time())){

                $invoice->renewed = 1;
                if($invoice->hasChanged()){
                    $invoiceModel->save($invoice);
                }

                $invoice->id = null;
                $invoice->paid = 2;
                $invoice->renewed = 0;
                $invoice->invoice = date('Y.m', strtotime($invoice->invoice. '+1 months')) . '.1';
                $invoiceModel->insert($invoice);

            }
        }

        /*
         * Rechnungen welche automatisch Jährlich erneuert werden generieren und auf pendent setzen
         */
        $invoices = $invoiceModel
            ->where('renew', 1)
            ->where('renew_interval', 3)
            ->where('renewed', 0)
            ->findAll();

        foreach($invoices as $key => $invoice){
            $invoiceDate = strtotime($invoice->invoice);
            if(time() >= strtotime('+335 days', $invoiceDate)){

                $invoice->renewed = 1;
                if($invoice->hasChanged()){
                    $invoiceModel->save($invoice);
                }

                $invoice->id = null;
                $invoice->paid = 2;
                $invoice->renewed = 0;
                $invoice->invoice = date('Y.m.d', strtotime($invoice->invoice. '+1 year'));
                $invoiceModel->insert($invoice);


            }
        }

         /*
         * Rechnungen welche automatisch auf den 1. im Jahr fällig sind generieren und auf pendent setzen
         */
        $invoices = $invoiceModel
            ->where('renew', 1)
            ->where('renew_interval', 4)
            ->where('renewed', 0)
            ->findAll();

        foreach($invoices as $key => $invoice){
            $invoiceDate = strtotime($invoice->invoice);
            if(date('d', time()) >= 1 && date('m', time()) == 12 && date('Y', $invoiceDate) == date('Y', time())){

                $invoice->renewed = 1;
                if($invoice->hasChanged()){
                    $invoiceModel->save($invoice);
                }

                $invoice->id = null;
                $invoice->paid = 2;
                $invoice->renewed = 0;
                $invoice->invoice = date('Y.m', strtotime($invoice->invoice. '+1 year')) . '.1';
                $invoiceModel->insert($invoice);

            }
        }



    }


}