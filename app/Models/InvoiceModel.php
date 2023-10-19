<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Invoice;

class InvoiceModel extends Model
{

    public $table = 'invoices';
    protected $db;
    protected $allowedFields = [
        "website_id",
        "customer_id",
        "project_id",
        "invoice",
        "paid",
        "renew",
        "renew_interval",
        "notes",
        "description",
        "amount",
        "renewed",
        "contact_name",
        "contact_phone",
        "contact_mail"
    ];

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $returnType = Invoice::class;
    protected $useSoftDeletes = true;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

}