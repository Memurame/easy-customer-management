<?php

namespace App\Controllers;

use App\Models\WebsiteModel;
use App\Models\CustomerModel;
use App\Models\ProjectModel;
use App\Entities\Website;
use App\Entities\WebsiteTag;
use CodeIgniter\API\ResponseTrait;

class apiWebsitesController extends BaseController
{
    use ResponseTrait;

    public function index(){

        $json_data = $this->request->getJSON('array');
        $websites = model('WebsiteModel')
            ->getAllWebsites($json_data);

        if(!$websites){
            return $this->failNotFound("No websites found");
        }

        return $this->respond($websites, 200);
    }

    public function show(int $websiteId = null){

        $website = model('WebsiteModel')
            ->find($websiteId);

        if(!$website){
            return $this->failNotFound("No website found");
        }

        return $this->respond($website->prepareForReturn(), 200);
    }

    public function update(int $customerId = null){

        $error = [];
        $json_data = $this->request->getJSON('array');

        $website = model('WebsiteModel')
            ->find($customerId);

        if(!$website){
            return $this->failNotFound("No website found");
        }

        if(isset($json_data['customer'])){
            if(empty($json_data['customer']))
                $error['customer'] = 'The customer is a required field.';
            else if(!model('CustomerModel')->find($json_data['customer']))
                $error['customer'] = 'This customer does not exist.';
            $website->customer_id = $json_data['customer'];
        }
        if(isset($json_data['project'])) {
            if(!model('ProjectModel')->find($json_data['project']))
                $error['url'] = 'This project does not exist.';
            $website->project_id = $json_data['project'];
        }
        if(isset($json_data['url'])) {
            if(empty($json_data['url'])) $error['url'] = 'The URL is a required field.';
            $website->website_url = $json_data['url'];
        }
        if(isset($json_data['live'])) {
            $website->website_live = $json_data['live'] ?? null;
        }
        if(isset($json_data['installed'])) {
            $website->website_installed = $json_data['installed'] ?? null;
        }
        if(isset($json_data['notes'])) {
            $website->notes = $json_data['notes'];
        }

        if(!$error) {
            if ($website->hasChanged()) {
                model(WebsiteModel::class)->save($website);
            }
            return $this->respond($website->prepareForReturn(), 200);
        } else {
            return $this->failValidationErrors($error);
        }
    }

    public function create(){

        $error = [];
        $json_data = $this->request->getJSON('array');

        $rules = [
            'customer' => 'required',
            'url' => 'required'
        ];

        if (! $this->validate($rules))
        {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $website = new Website();

        if(!model('CustomerModel')->find($json_data['customer']))
            $error['customer'] = 'This customer does not exist.';
        $website->customer_id = $json_data['customer'];

        if(!model('ProjectModel')->find($json_data['project']))
            $error['url'] = 'This project does not exist.';
        $website->project_id = $json_data['project'];

        $website->website_url = $json_data['url'];
        $website->website_live = $json_data['live'] ?? null;
        $website->website_installed = $json_data['installed'] ?? null;
        $website->notes = $json_data['notes'];



        model('WebsiteModel')->save($website);


        /*
         * Loads the just entered team
         */
        $lastInsertID = model('WebsiteModel')->getInsertID();
        $website = model('WebsiteModel')->find($lastInsertID);

        return $this->respond($website->prepareForReturn(), 200);
    }

    public function delete($websiteId = null){
        $website = model('WebsiteModel')->find($websiteId);

        if(!$website){
            return $this->failNotFound('The website does not exist');
        }

        model('WebsiteModel')->delete($website->id);

        return $this->respondDeleted();


    }
}