<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\CustomerContact;

class CustomerContactModel extends Model
{

    public $table = 'customers_contacts';
    protected $db;
    protected $allowedFields = [
        "firstname",
        "lastname",
        "mail",
        "addressnumber",
        "customer_id",
        "street",
        'postcode',
        'city',
        'typ',
        'phone',
        'billingcontact'

    ];

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $returnType = CustomerContact::class;
    protected $useSoftDeletes = true;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

}