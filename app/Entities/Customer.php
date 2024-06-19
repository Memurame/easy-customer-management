<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Models\CustomerContactModel;

class Customer extends Entity
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

    public $billingContact = [];

    public $mainContact = [];

    public $contacts = [];


    public function mainContact(){

        $customerContactModel = model(CustomerContactModel::class);
        $this->mainContact = $customerContactModel->find($this->main_contact);

        return $this->mainContact;

    }
    public function billingContact(){

        $customerContactModel = model(CustomerContactModel::class);
        $this->billingContact = $customerContactModel->find($this->billing_contact);

        return $this->billingContact;

    }

    public function allContacts(){

        $customerContactModel = model(CustomerContactModel::class);
        $this->contacts = $customerContactModel->where('customer_id', $this->id)->findAll();

        return $this->contacts;
    }

    public function isMainContact(){
        return (bool)$this->main_contact;
    }

    /* ########################################################
     * Ab hier sind Funktionen für die API
     #########################################################*/
    public function prepareForReturn(){
        $r = model('CustomerModel')->find($this->id);

        $return = [];
        $return['id'] = $r->id;
        $return['status'] = $r->status;
        $return['addressnumber'] = $r->addressnumber;
        $return['name'] = $r->customername;
        $return['street'] = $r->street;
        $return['postcode'] = $r->postcode;
        $return['city'] = $r->city;
        $return['mail'] = $r->mail;
        $return['phone'] = $r->phone;
        $return['notes'] = $r->notes;
        $return['main_contact'] = $r->main_contact;
        $return['billing_contact'] = $r->billing_contact;

        return $return ?? null;
    }


    public function syncwithAbacus(){
        $address = model('AbaAddressModel')
                ->where('abacus', $this->addressnumber)
                ->first();

        $name = $address->lastname;
        if($address->firstname) $name .= ' ' . $address->firstname;

        $phone = $address->phone1;
        if(!$phone) $phone = $address->phone2;
        if(!$phone) $phone = $address->mobile;


        $this->customername = $name;
        $this->mail = $address->email;
        $this->street = $address->street;
        $this->postcode = $address->postcode;
        $this->city = $address->city;
        $this->phone = $phone ?? NULL;
        $this->addressnumber_sync = time();

    }

}
