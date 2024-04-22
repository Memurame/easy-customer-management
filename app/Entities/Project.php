<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Models\CustomerModel;

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

    /* ########################################################
     * Ab hier sind Funktionen für die API
     #########################################################*/
    public function prepareForReturn(){
        $r = model('ProjectModel')->find($this->id);

        $return = [];
        $return['id'] = $r->id;
        $return['assign']['customer'] = $r->customer_id;
        $return['name'] = $r->name;
        $return['status'] = $r->status;
        $return['date']['offer'] = $r->date_offer;
        $return['date']['order'] = $r->date_order;
        $return['date']['finish'] = $r->date_finish;
        $return['notes'] = $r->notes;

        return $return ?? null;
    }
}