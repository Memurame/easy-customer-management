<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Customer;

class CustomerModel extends Model
{

    public $table = 'customers';
    protected $db;
    protected $allowedFields = [
        "customername",
        "addressnumber",
        "phone",
        "mail",
        "street",
        'postcode',
        'city',
        'status',
        'notes',
        'main_contact',
        'billing_contact'
    ];

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $returnType = Customer::class;
    protected $useSoftDeletes = false;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    /* ########################################################
     * Ab hier sind Funktionen für die API
     #########################################################*/

    public function getAllCustomers(){
        $return = [];

        foreach($this->findAll() as $val){
            $return[] = $val->prepareForReturn();
        }

        return $return;
    }

}