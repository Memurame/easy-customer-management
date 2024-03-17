<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Entities\Invoice;
use App\Models\WebsiteModel;
use App\Entities\Website;
use App\Models\CustomerModel;
use App\Models\ProjectModel;
use CodeIgniter\Shield\Models\UserModel;
use Sprain\SwissQrBill as QrBill;

class InvoicesController extends BaseController
{
    public function index()
    {

        $filter = $this->request->getGet('filter');
        $filterArray = ['all','future','open','draft','overdue','pending'];
        if(!$filter || !in_array($filter, $filterArray)){
            $filter = 'future';
        }

        $invoiceModel = new InvoiceModel();
        if($filter == 'future'){
            $invoices = $invoiceModel->whereIn('paid', [0,2,3,4,5])->whereNotIn('customer_id', [0])->findAll();
        } else if($filter == 'open'){
            $invoices = $invoiceModel->whereIn('paid', [0,4])->whereNotIn('customer_id', [0])->findAll();
        } else if($filter == 'draft'){
            $invoices = $invoiceModel->where('paid', 5)->whereNotIn('customer_id', [0])->findAll();
        } else if($filter == 'overdue'){
            $invoices = $invoiceModel->where('paid', 3)->whereNotIn('customer_id', [0])->findAll();
        } else if($filter == 'pending'){
            $invoices = $invoiceModel->where('paid', 2)->whereNotIn('customer_id', [0])->findAll();
        } else{
            $invoices = $invoiceModel->whereNotIn('customer_id', [0])->findAll();
        }





        return view('invoice/index', [
            'invoices' => $invoices,
            'filter' => $filter
        ]);
    }

    public function add()
    {

        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();


        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'description' => 'required',
                'invoice' => 'required',
                'customer_id' => 'required',
                'renew' => 'required',
                'paid' => 'required'
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Bitte alle erforderlichen Felder ausfüllen');
            }

            $invoice = new Invoice($this->request->getPost());
            $invoice->invoice = $this->request->getPost('invoice') ?: null;

            $invoiceModel = new InvoiceModel();
            $invoiceModel->save($invoice);

            session()->setFlashdata('msg_success', 'Rechnung erfolgreich angelegt.');

            return redirect()->route('invoice.show', [$invoiceModel->getInsertID()]);

        }


        return view('invoice/add', [
            'customers' => $customers,
            'tomselectProject' => true,
            'tomselectWebsite' => true
        ]);
    }

    public function edit($id)
    {

        if($id == setting('App.invoiceTemplateId')) {
            return redirect()->route('invoice.show', [$id])->with('msg_error', 'Die Vorlage kann nicht bearbeitet werden. Es können nur die Positionen bearbeitet werden.');
        }
        
        $invoiceModel = new InvoiceModel();
        $invoice = $invoiceModel->find($id);

        if(!$invoice){
            session()->setFlashdata('msg_error', 'Die ausgewählte Rechnung wurde nicht gefunden.');
            return redirect()->route('invoice.index');
        }

        $websiteModel = new WebsiteModel();
        $websites = $websiteModel->where('customer_id', $invoice->customer_id)->findAll();

        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();

        $projectModel = new ProjectModel();
        $projects = $projectModel->where('customer_id', $invoice->customer_id)->findAll();


        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'invoice' => 'required',
                'customer_id' => 'required',
                'renew' => 'required',
                'paid' => 'required'
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Bitte alle erforderlichen Felder ausfüllen');
            }

            $parser = new \Parsedown();

            $invoice->invoice = $this->request->getPost('invoice') ?: null;
            $invoice->description = $this->request->getPost('description');
            $invoice->renew = $this->request->getPost('renew');
            $invoice->renew_interval = $this->request->getPost('renew_interval');
            $invoice->customer_id = $this->request->getPost('customer_id');
            $invoice->project_id = $this->request->getPost('project_id');
            $invoice->website_id = $this->request->getPost('website_id');
            $invoice->paid = $this->request->getPost('paid');
            $invoice->amount = $this->request->getPost('amount');
            $invoice->notes_top = $this->request->getPost("notes_top");
            $invoice->notes_bottom = $this->request->getPost("notes_bottom");
            $invoice->notes = $this->request->getPost('notes');
            $invoice->contact_name = $this->request->getPost('contact_name');
            $invoice->contact_phone = $this->request->getPost('contact_phone');
            $invoice->contact_mail = $this->request->getPost('contact_mail');
            $invoice->payment_terms = $this->request->getPost('payment_terms');




            if($invoice->hasChanged()){
                $invoiceModel->save($invoice);
                session()->setFlashdata('msg_success', 'Rechnung gespeichert.');
            } else {
                session()->setFlashdata('msg_info', 'Es wurden keine änderungen erkannt.');
            }
           
            if($this->request->getGet('ref') == 'show'){
                return redirect()->route('invoice.show', [$id]);
            } else {
                return redirect()->route('invoice.index');
            }


        }


        return view('invoice/edit', [
            'projects' => $projects,
            'customers' => $customers,
            'websites' => $websites,
            'invoice' => $invoice,
            'tomselectProject' => true,
            'tomselectWebsite' => true
        ]);
    }

    public function show($id)
    {
        if($id == setting('App.invoiceTemplateId') AND !auth()->user()->can('invoice.template')){
            session()->setFlashdata('msg_error', 'Du hast keine Berechtigung Vorlagen zu bearbeiten.');
            return redirect()->route('invoice.index');
        }

        $invoiceModel = new InvoiceModel();
        $invoice = $invoiceModel->find($id);
        
        if(!$invoice){
            session()->setFlashdata('msg_error', 'Die ausgewählte Rechnung wurde nicht gefunden.');
            return redirect()->route('invoice.index');
        }
        $parser = new \Parsedown();
        $invoice->notes_md = $parser->setBreaksEnabled(true)->text($invoice->notes);

        return view('invoice/show', [
            'invoice' => $invoice
        ]);
    }

    public function export($id)
    {
        $invoiceModel = new InvoiceModel();
        $invoice = $invoiceModel->find($id);

        if(!$invoice){
            session()->setFlashdata('msg_error', 'Die ausgewählte Rechnung wurde nicht gefunden.');
            return redirect()->route('invoice.show', [$id]);
        }

        $parser = new \Parsedown();
        $invoice->notes_md = $parser->setBreaksEnabled(true)->text($invoice->notes);

        $invoice->getBillingAddress();

        if((setting('Company.invoice_qr') == 'iban'  AND !empty(setting('Company.iban'))) OR (setting('Company.invoice_qr') == 'qr-iban' AND !empty(setting('Company.qriban')) AND !empty(setting('Company.qriban_reference')))){
            
            $date = new \DateTime($invoice->invoice);

            $qrBill = QrBill\QrBill::create();
            $qrBill->setCreditor(
                QrBill\DataGroup\Element\CombinedAddress::create(
                    setting('Company.name'),
                    setting('Company.street'),
                    setting('Company.postcode') . ' ' . setting('Company.city'),
                    'CH'
                )
            );

            if(!empty($invoice->address['name']) AND !empty($invoice->address['street']) AND !empty($invoice->address['postcode']) AND !empty($invoice->address['city'])){
                $qrBill->setUltimateDebtor(
                    QrBill\DataGroup\Element\StructuredAddress::createWithStreet(
                        $invoice->address['name'],
                        $invoice->address['street'],
                        '',
                        $invoice->address['postcode'],
                        $invoice->address['city'],
                        'CH'
                    )
                );
            }
            
            $qrBill->setPaymentAmountInformation(
                QrBill\DataGroup\Element\PaymentAmountInformation::create(
                    'CHF',
                    $invoice->getTotal()
                )
            );

            $qrBill->setAdditionalInformation(
                QrBill\DataGroup\Element\AdditionalInformation::create(
                    'RE-' . str_pad($invoice->id,5,0,STR_PAD_LEFT)
                )
            );

            if(setting('Company.invoice_qr') == 'iban'  AND !empty(setting('Company.iban'))){
                $qrBill->setCreditorInformation(
                    QrBill\DataGroup\Element\CreditorInformation::create(
                        setting('Company.iban')
                    )
                );
                $qrBill->setPaymentReference(
                    QrBill\DataGroup\Element\PaymentReference::create(
                        QrBill\DataGroup\Element\PaymentReference::TYPE_NON
                    )
                );
            }
            elseif(setting('Company.invoice_qr') == 'qr-iban' AND !empty(setting('Company.qriban')) AND !empty(setting('Company.qriban_reference'))){
                $qrBill->setCreditorInformation(
                    QrBill\DataGroup\Element\CreditorInformation::create(
                        setting('Company.qriban')
                    )
                );
                $qrBill->setPaymentReference(
                    QrBill\DataGroup\Element\PaymentReference::create(
                        QrBill\DataGroup\Element\PaymentReference::TYPE_QR,
                        setting('Company.qriban_reference')
                    )
                );
            }
            

            if(setting('Company.invoice') == 2){
                try {
                    $qrBill->getQrCode()->writeFile(WRITEPATH . '/invoice/'.$invoice->id.'_qr.png');
                    $qrBill->getQrCode()->writeFile(WRITEPATH . '/invoice/' .$invoice->id. '_qr.svg');
        
                    $output = new QrBill\PaymentPart\Output\HtmlOutput\HtmlOutput($qrBill, 'de');
        
                    $html = $output
                        ->setPrintable(false)
                        ->getPaymentPart();
                
                } catch (Exception $e) {
                    foreach ($qrBill->getViolations() as $violation) {
                        //print $violation->getMessage()."\n";
                    }
                    exit;
                }
            }
        }


        return view('invoice/export', [
            'invoice' => $invoice,
            'qr' => $html ?? null
        ]);
    }

    public function cron(){
        



    }


}