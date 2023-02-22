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
                'paid' => 'required'
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
                'paid' => 'required'
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
        $invoices = $invoiceModel->where('paid', 0)->findAll();

        $paymentTerm = strtotime('-30 days');
       

        foreach($invoices as $key => $invoice){
            $invoiceDate = strtotime($invoice->invoice);
            if($invoiceDate <= $paymentTerm){
                $invoice->paid = 3;
                $invoiceModel->save($invoice);

                // SEND MAIL TO USERS
            }
        }



    }


}