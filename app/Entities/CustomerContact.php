<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Models\CustomerModel;

class CustomerContact extends Entity
{
    /**
     * @var array
     */
    protected $datamap = [];

    /**
     * @var string[]
     */
    protected $dates   = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $casts   = [];

    public $data;

    public function isBillingContact(){

        $customerModel = model(CustomerModel::class);
        $customer = $customerModel->find($this->customer_id);

        return ($customer->billing_contact == $this->id) ? true : false;

    }

    public function isMainContact(){

        $customerModel = model(CustomerModel::class);
        $customer = $customerModel->find($this->customer_id);

        return ($customer->main_contact == $this->id) ? true : false;

    }

    public function getCustomerInfo($field){

        if($this->customer_id){
            $customerModel = model(CustomerModel::class);

            $customer = $customerModel->find($this->customer_id);

            $val = null;
            if($customer){
                return $customer->{$field};
            }

            return null;


        }

        return null;

    }


}
