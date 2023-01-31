<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Entities\Invoice;
use App\Models\WebsiteModel;
use App\Entities\Website;

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

            $invoiceModel = new InvoiceModel();
            $invoiceModel->save($invoice);

            return redirect()->route('invoice.index');

        }


        return view('invoice/add', [
            'websites' => $websites
        ]);
    }
}
