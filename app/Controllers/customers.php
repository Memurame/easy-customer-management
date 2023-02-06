<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Entities\Customer;

class Customers extends BaseController
{
    public function index()
    {
        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();


        return view('customer/index', [
            'customers' => $customer
        ]);
    }

    
}
