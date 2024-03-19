<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Entities\Invoice;
use App\Models\WebsiteModel;
use App\Entities\Website;
use App\Models\ProjectModel;
use App\Entities\Project;
use App\Models\CustomerModel;
use App\Models\CommentModel;
use App\Models\InvoicePositionModel;
use App\Entities\InvoicePosition;

class InvoicesPositionController extends BaseController
{

    public function add($id)
    {
        $invoiceModel = new InvoiceModel();
        $invoice = $invoiceModel->find($id);
        
        if(!$invoice){
            session()->setFlashdata('msg_error', 'Die ausgewählte Rechnung wurde nicht gefunden.');
            return redirect()->route('invoice.index');
        }

        $resultMaxPos = model('InvoicePositionModel')
            ->where('invoice_id', $invoice->id)
            ->select('max(position) as maxPosition')
            ->first();
        $max['position'] = $resultMaxPos->maxPosition + 1;

        $resultMaxOrd = model('InvoicePositionModel')
        ->where('invoice_id', $invoice->Id)
        ->select('max(ord) as maxOrd')
        ->first();
        $max['ord'] = $resultMaxOrd->maxOrd + 1;


        if($this->request->getGet('template')){
            $template = model('InvoicePositionModel')
                ->where('invoice_id', setting('App.invoiceTemplateId'))
                ->where('id', $this->request->getGet('template'))
                ->first();
        }

        $templates = model('InvoicePositionModel')
            ->where('invoice_id', setting('App.invoiceTemplateId'))
            ->findAll();
            
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'title' => 'required',
                'price' => 'required',
                'multiplication' => 'required',
                'unit' => 'required',
                'mwst' => 'required',
            ];

            if (! $this->validate($rules))
            {
                session()->setFlashdata('msg_error', 'Bitte fülle die erforderlichen Felder aus');
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }



            $invoicePosition = new InvoicePosition($this->request->getPost(['title', 'description', 'price', 'unit', 'multiplication', 'mwst', 'notes', 'position']));
            $invoicePosition->price_inkl = ($this->request->getPost('price_inkl')) ? true : false;
            $invoicePosition->user_id = user_id();
            $invoicePosition->invoice_id = $invoice->id;
            $invoicePosition->ord = $max['ord'];

            $invoicePositionModel = new InvoicePositionModel();
            $invoicePositionModel->save($invoicePosition);


            session()->setFlashdata('msg_success', 'Rechnungsposition erfolgreich angelegt.');
            return redirect()->route('invoice.show', [$invoice->id]);

        }

        return view('invoice_position/add' ,[
            'invoice' => $invoice,
            'max' => $max,
            'currentTemplate' => $template ?? [],
            'templates' => $templates
        ]);
    }

    public function edit($id)
    {

        if($id == setting('App.invoiceTemplateId') AND !auth()->user()->can('invoice.template')){
            session()->setFlashdata('msg_error', 'Du hast keine Berechtigung Vorlagen zu bearbeiten.');
            return redirect()->route('invoice.index');
        }

        $invoicePositionModel = new InvoicePositionModel();
        $invoicePosition = $invoicePositionModel->find($id);
        
        if(!$invoicePosition){
            session()->setFlashdata('msg_error', 'Die ausgewählte Position wurde nicht gefunden.');
            return redirect()->route('invoice.index');
        }

        $invoiceModel = new InvoiceModel();
        $invoice = $invoiceModel->find($invoicePosition->invoice_id);
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            

            $rules = [
                'title' => 'required',
                'position' => 'required',
                'price' => 'required',
                'multiplication' => 'required',
                'unit' => 'required',
                'mwst' => 'required',
            ];

            if (! $this->validate($rules))
            {
                session()->setFlashdata('msg_error', 'Bitte fülle die erforderlichen Felder aus');
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }



            $invoicePosition->user_id = user_id();
            $invoicePosition->title = $this->request->getPost('title');
            $invoicePosition->position = $this->request->getPost('position');
            $invoicePosition->description = $this->request->getPost('description');
            $invoicePosition->price = $this->request->getPost('price');
            $invoicePosition->price_inkl = ($this->request->getPost('price_inkl')) ? true : false;
            $invoicePosition->multiplication = $this->request->getPost('multiplication');
            $invoicePosition->unit = $this->request->getPost('unit');
            $invoicePosition->mwst = $this->request->getPost('mwst');
            $invoicePosition->notes = $this->request->getPost('notes');

            $invoicePositionModel = new InvoicePositionModel();
            if($invoicePosition->hasChanged()){
                $invoicePositionModel->save($invoicePosition);
                session()->setFlashdata('msg_success', 'Rechnungsposition gespeichert.');
            } else {
                session()->setFlashdata('msg_info', 'Es wurden keine änderungen erkannt.');
            }
            


            
            return redirect()->route('invoice.show', [$invoice->id]);

        }

        return view('invoice_position/edit', [
            'position' => $invoicePosition,
            'invoice' => $invoice
        ]);
    }

}