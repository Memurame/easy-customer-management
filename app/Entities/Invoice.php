<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Models\WebsiteModel;
use App\Models\ProjectModel;
use App\Models\CustomerModel;
use App\Models\CustomerContactModel;
use App\Models\InvoicePositionModel;

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

    public float $mwst_total = 0;

    public array $address = [];

    public function getWebsiteInfo($field){

        $result = null;
        if($this->website_id){
            $websiteModel = model(WebsiteModel::class);
            $result = $websiteModel->find($this->website_id);
        }

        return $result ? $result->{$field} : null;

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

    public function getPositions(){

        $invoicePositionModel = model(InvoicePositionModel::class);
        $result = $invoicePositionModel->where('invoice_id', $this->id)->orderBy('ord')->findAll();

        return $result ?: [];
        
    }

    public function getTotal($inkl = true, $round = true){
        $positions = $this->getPositions();
        $total = 0;

        foreach($positions as $position){
            $total = $total + $position->getPositionTotal(false);
        }


        if($inkl){
            $total = $total + $this->getMwstTotal();
        }

        return ($round) ? round($total * 20) / 20 : $total;
    }

    public function getMwst(){
        $this->mwst_total = 0;
        $invoicePositionModel = model(InvoicePositionModel::class);
        $found = $invoicePositionModel->getDiverentMwst($this->id);
        foreach($found as $key => $mwst){

            $found[$key]['value'] = 0;
            $positions = $invoicePositionModel
                ->where('invoice_id', $this->id)
                ->where('mwst', $mwst['mwst'])
                ->findAll();
            foreach($positions as $position){
                $found[$key]['value'] = $found[$key]['value'] + $position->getPositionTotal(false);
            }

            $found[$key]['value'] = round(($found[$key]['value'] / 100) * $mwst['mwst'], 2);
            $this->mwst_total = $this->mwst_total + $found[$key]['value'];
        }
        return $found;


    }

    public function getMwstTotal(){
        $this->getMwst();
        return $this->mwst_total;
    }

    public function getBillingAddress(){
        $customerModel = model(CustomerModel::class);
        $customer = $customerModel->find($this->customer_id);

        $this->address['name'] = $customer->customername;
        $this->address['street'] = $customer->street;
        $this->address['postcode'] = $customer->postcode;
        $this->address['city'] = $customer->city;

        if($customer->billing_contact){
            $customerContactModel = model(CustomerContactModel::class);
            $customerContact = $customerContactModel->find($customer->billing_contact);

            if($customerContact){
                $this->address['name'] = $customerContact->firstname . ' ' . $customerContact->lastname;
                $this->address['street'] = $customerContact->street;
                $this->address['postcode'] = $customerContact->postcode;
                $this->address['city'] = $customerContact->city;
            }

        }

        return $this->address;
    }

    /* ########################################################
     * Ab hier sind Funktionen für die API
     #########################################################*/
     public function prepareForReturn(){
        $r = model('InvoiceModel')
            ->find($this->id);

        $return = [];
        $return['id'] = $r->id;
        $return['date_invoice'] = $r->invoice;
        $return['paid'] = $r->paid;
        $return['renew'] = $r->renew;
        $return['intervall'] = $r->renew_intervall;
        $return['renewed'] = $r->renewed;
        $return['description'] = $r->description;
        $return['note']['top'] = $r->notes_top;
        $return['note']['bottom'] = $r->notes_bottom;
        $return['contact']['name'] = $r->contact_name;
        $return['contact']['phone'] = $r->contact_phone;
        $return['contact']['mail'] = $r->contact_mail;

        return $return ?? null;
    }
}