<?php

namespace App\Controllers;

use App\Entities\Customer;
use App\Models\WebsiteModel;
use App\Models\CustomerModel;
use App\Models\ProjectModel;
use App\Models\TaglistModel;
use App\Entities\Website;
use App\Entities\WebsiteTag;
use App\Models\CommentModel;
use CodeIgniter\API\ResponseTrait;

class apiCustomerController extends BaseController
{
    use ResponseTrait;

    public function index(){

        $customers = model('CustomerModel')
            ->getAllCustomers();

        if(!$customers){
            return $this->failNotFound("No customers found");
        }

        return $this->respond($customers, 200);
    }

    public function show(int $customerId = null){

        $customer = model('CustomerModel')
            ->find($customerId);

        if(!$customer){
            return $this->failNotFound("No customer found");
        }

        return $this->respond($customer->prepareForReturn(), 200);
    }

    public function delete($customerId = null){
        $customer = model('CustomerModel')->find($customerId);

        if(!$customer){
            return $this->failNotFound('The customer does not exist');
        }

        model('CustomerModel')->delete($customer->id);

        return $this->respondDeleted();


    }

    public function create(){

        $error = [];
        $json_data = $this->request->getJSON('array');

        $rules = [
            'name'          => 'required',
            'street'        => 'required',
            'postcode'      => 'required',
            'city'          => 'required',
            'addressnumber' => 'is_unique[customers.addressnumber]',
            'mail'          => 'max_length[254]|valid_email'
        ];

        if (! $this->validate($rules))
        {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $customer = new Customer();
        $customer->customername     = $json_data['name'];
        $customer->addressnumber    = $json_data['addressnumber'];
        $customer->street           = $json_data['street'];
        $customer->postcode         = $json_data['postcode'];
        $customer->city             = $json_data['city'];
        $customer->mail             = $json_data['mail'];
        $customer->phone            = $json_data['phone'];
        $customer->notes            = $json_data['notes'];
        $customer->status           = 1;

        model('CustomerModel')->save($customer);


        /*
         * Loads the just entered team
         */
        $lastInsertID = model('CustomerModel')->getInsertID();
        $customer = model('CustomerModel')->find($lastInsertID);

        return $this->respond($customer->prepareForReturn(), 200);

    }

    public function projects($customerId = null){

        $customer = model('CustomerModel')->find($customerId);

        if(!$customer){
            return $this->failNotFound('The customer does not exist');
        }

        $projects = model('ProjectModel')
            ->getProjectsByCustomer($customerId);

        if(!$projects){
            return $this->failNotFound("No projects found");
        }

        return $this->respond($projects, 200);
    }

    public function websites($customerId = null){

        $customer = model('CustomerModel')->find($customerId);

        if(!$customer){
            return $this->failNotFound('The customer does not exist');
        }

        $websites = model('WebsiteModel')
            ->getWebsitesByCustomer($customer->id);

        if(!$websites){
            return $this->failNotFound("No websitess found");
        }

        return $this->respond($websites, 200);
    }

    public function syncAbacus($customerId = NULL){
        $customer = model('CustomerModel')
            ->find($customerId);

        if(!$customer){
            return $this->failNotFound("No customer found");
        }
        

        if($customer->addressnumber == NULL){
            return $this->failNotFound("No addressnumber set");
        }

        $customer->syncWithAbacus();

        model('CustomerModel')->save($customer);

        return $this->respond(200);
    }
}