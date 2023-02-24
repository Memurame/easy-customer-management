<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Customer;

class CustomerModel extends Model
{

    public $table = 'customers';
    protected $db;
    protected $allowedFields = [
        "company",
        "contact_firstname",
        "contact_lastname",
        "contact_mail",
        "customernumber",
        "street",
        'postcode',
        'city',
        'status',
        'notes'
    ];

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $returnType = Customer::class;
    protected $useSoftDeletes = true;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

}