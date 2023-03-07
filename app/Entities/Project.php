<?php

namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\ProjectModel;

class Project extends Entity
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

    protected $team_name;

    public $data;

    public function getCustomerInfo($field){

        if($this->customer_id){
            $customerModel = model(CustomerModel::class);

            $customer = $customerModel->find($this->customer_id);

            $val = null;
            if($customer){
                if($field == 'company'){
                    if(empty($customer->{$field})){
                        return $customer->contact_lastname . ' ' . $customer->contact_firstname;
                    }
                }

                return $customer->{$field};
            }

            return null;

            
        }

        return null;
        
    }
}