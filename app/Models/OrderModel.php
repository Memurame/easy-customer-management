<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Customer;

class OrderModel extends Model
{

    public $table = 'orders';
    protected $db;
    protected $allowedFields = [
        "customer_id",
        "status",
        "name",
        "date_offer",
        "date_order",
        "date_finish",
        'notes'
    ];

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $returnType = Order::class;
    protected $useSoftDeletes = true;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

}