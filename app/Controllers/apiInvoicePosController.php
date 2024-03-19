<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Entities\Invoice;
use App\Entities\InvoicePosition;

class apiInvoicePosController extends BaseController
{
    use ResponseTrait;

    public function delete($invoicePosId = null){
        if($invoicePosId == setting('App.invoiceTemplateId') AND !auth()->user()->can('invoice.template')){
            return $this->failForbidden('You do not have permission to edit templates');
        }
        
        $invoicePos = model('InvoicePositionModel')->find($invoicePosId);

        if(!$invoicePos){
            return $this->failNotFound('The invoice position does not exist');
        }

        model('InvoicePositionModel')->delete($invoicePos->id);

        return $this->respondDeleted();


    }

    public function saveAsTemplate($id){
        $invoice = model('InvoiceModel')
            ->where('customer_id', 0)
            ->first();
        if(!$invoice){
            $invoice = new Invoice();
            $invoice ->customer_id = 0;
            $invoice ->description = 'Vorlagen';
            $invoice ->paid = 0;
            $invoice ->renew = 0;
            $invoice ->renew_interval = 0;
            $invoice ->amount = 0;
            model('InvoiceModel')->save($invoice);
            $templateId = model('InvoiceModel')->getInsertID();
        } else {
            $templateId = $invoice->id;
        }

        if(!setting('App.invocieTemplateId')){
            service('settings')->set('App.invoiceTemplateId', $templateId);
        }


        $position = model('InvoicePositionModel')
            ->find($id);

        if(!$position){
            return $this->failNotFound('The invoice position does not exist');
        }

        $resultMaxPos = model('InvoicePositionModel')
            ->where('invoice_id', $templateId)
            ->select('max(position) as maxPosition')
            ->first();

        $position->id = null;
        $position->position = $resultMaxPos->maxPosition + 1;
        $position->user_id = user_id();
        $position->invoice_id = $templateId;
        model('InvoicePositionModel')->save($position);
        
        return $this->respondNoContent();
        
    }

    public function addTitle($invoideId){
        $json_data = $this->request->getJSON('array');

        $rules = [
            'title' => 'required'
        ];

        if (! $this->validate($rules))
        {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $invoice = model('InvoiceModel')
            ->where('id', $invoideId)
            ->first();

        $resultMaxOrd = model('InvoicePositionModel')
        ->where('invoice_id', $invoideId)
        ->select('max(ord) as maxOrd')
        ->first();


        $position = new InvoicePosition();;
        $position->ord = $resultMaxOrd->maxOrd + 1;
        $position->user_id = user_id();
        $position->invoice_id = $invoideId;
        $position->type = 2;
        $position->title = $json_data['title'];
        model('InvoicePositionModel')->save($position);
        
        return $this->respondNoContent();
        
    }

    public function moveUp($invoicePosId){
        $invoicePos = model('InvoicePositionModel')->find($invoicePosId);
        $invoicePosList = model('InvoicePositionModel')
        ->where('invoice_id', $invoicePos->invoice_id)
        ->where('ord <', $invoicePos->ord)
        ->orderBy('ord', 'desc')
        ->findAll();

        foreach($invoicePosList as $pos){
            if($pos->ord < $invoicePos->ord){
                $prevPos = $pos->ord;

                $pos->ord = $invoicePos->ord;
                model('InvoicePositionModel')->save($pos);

                $invoicePos->ord = $prevPos;
                model('InvoicePositionModel')->save($invoicePos);
                exit;
            }
        }
        

    }

    public function moveDown($invoicePosId){
        $invoicePos = model('InvoicePositionModel')->find($invoicePosId);
        $invoicePosList = model('InvoicePositionModel')
        ->where('invoice_id', $invoicePos->invoice_id)
        ->where('ord >', $invoicePos->ord)
        ->orderBy('ord')
        ->findAll();

        foreach($invoicePosList as $pos){
            if($pos->ord > $invoicePos->ord){
                $prevPos = $pos->ord;

                $pos->ord = $invoicePos->ord;
                model('InvoicePositionModel')->save($pos);

                $invoicePos->ord = $prevPos;
                model('InvoicePositionModel')->save($invoicePos);
                exit;
            }
        }
        

    }
}