<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Entities\Invoice;

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

}