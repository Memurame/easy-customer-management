<?php

namespace App\Controllers;

use App\Models\WebsiteModel;
use App\Models\CustomerModel;
use App\Models\ProjectModel;
use App\Models\TaglistModel;
use App\Entities\Website;
use App\Entities\WebsiteTag;
use App\Models\CommentModel;
use CodeIgniter\API\ResponseTrait;

class apiInvoiceController extends BaseController
{
    use ResponseTrait;


    public function show(int $invoiceId = null){

        $invoice = model('InvoiceModel')
            ->find($invoiceId);

        if(!$invoice){
            return $this->failNotFound("No invoice found");
        }

        $customer = model('CustomerModel')->find($invoice->customer_id);
        $positions = model('InvoicePositionModel')
            ->where('invoice_id', $invoice->id)
            ->orderBy('ord', 'asc')
            ->findAll();

        $return = $invoice->prepareForReturn();
        $return['customer'] = $customer->prepareForReturn();
        if($positions){
            foreach($positions as $pos){
                $return['positions'][] = $pos->prepareForReturn();
            }
        }else{
            $return['positions'] = [];
        }
        
        return $this->respond($return, 200);
    }

    public function delete($invoiceId = null){
        $invoice = model('InvoiceModel')->find($invoiceId);

        if(!$invoice){
            return $this->failNotFound('The invoice does not exist');
        }

        model('InvoiceModel')->delete($invoice->id);

        return $this->respondDeleted();


    }

}