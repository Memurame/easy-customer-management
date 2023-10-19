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

    public function delete($invoiceId = null){
        $invoice = model('InvoiceModel')->find($invoiceId);

        if(!$invoice){
            return $this->failNotFound('The invoice does not exist');
        }

        model('InvoiceModel')->delete($invoice->id);

        return $this->respondDeleted();


    }

}