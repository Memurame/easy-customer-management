<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Models\CommentModel;
use App\Models\WebsiteModel;
use App\Models\CustomerModel;
use App\Models\ProjectModel;

class Home extends BaseController
{
    public function index()
    {
        $count = [];

        $websiteModel = new WebsiteModel();
        $count['website'] = $websiteModel->countAllResults();

        $customerModel = new CustomerModel();
        $count['customer'] = $customerModel->countAllResults();

        $projectModel = new ProjectModel();
        $count['project'] = $projectModel->countAllResults();

        $invoiceModel = new InvoiceModel();
        $count['invoice'] = $invoiceModel->countAllResults();

        return view('home', [
            'count' => $count
        ]);
    }
}