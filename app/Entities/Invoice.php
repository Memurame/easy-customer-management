<?php

namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\WebsiteModel;

class Invoice extends Entity
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

    public function getWebsiteInfo($field){

        $result = null;
        if($this->website_id){
            $websiteModel = model(WebsiteModel::class);
            $result = $websiteModel->find($this->website_id);
        }

        return $result ? $result->{$field} : null;

    }

    public function getCustomerInfo($field){
        $result = null;
        if($this->customer_id){
            $customerModel = model(CustomerModel::class);
            $result = $customerModel->find($this->customer_id);
        }

        return $result ? $result->{$field} : null;
        
    }

    public function getProjectInfo($field){
        $result = null;
        if($this->project_id){
            $projectModel = model(ProjectModel::class);
            $result = $projectModel->find($this->project_id);
        }

        return $result ? $result->{$field} : null;
        
    }
}