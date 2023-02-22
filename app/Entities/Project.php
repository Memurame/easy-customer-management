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

            return $customerModel->find($this->customer_id)->{$field};
        }

        return null;
        
    }
}