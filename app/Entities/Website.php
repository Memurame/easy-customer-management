<?php

namespace App\Entities;

use CodeIgniter\Entity;

class Website extends Entity
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

    public function removeAllTags(){
        
        $websiteTagModel = model(WebsiteTagModel::class);
    
        return $websiteTagModel->removeAllTagsFromWebsite($this->id);
    }

    public function addTagToWebsite($tagId){
        
        $websiteTagModel = model(WebsiteTagModel::class);
    
        return $websiteTagModel->addTagToWebsite($tagId, $this->id);
    }

    public function getTags(){
        $websiteTagModel = model(WebsiteTagModel::class);
    
        return $websiteTagModel->getTagsForWebsite($this->id);
    }

    public function hasTag($tagId){
        $websiteTagModel = model(WebsiteTagModel::class);

        return $websiteTagModel->checkWebsiteTag($this->id, $tagId);
    }

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
    public function getProjectInfo($field){

        $result = null;
        if($this->project_id){
            $projectModel = model(ProjectModel::class);
            $result = $projectModel->find($this->project_id);
        }

        return $result ? $result->{$field} : null;
        
    }
}