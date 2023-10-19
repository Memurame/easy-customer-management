<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\InvoicePosition;

class InvoicePositionModel extends Model
{

    public $table = 'invoices_position';
    protected $db;
    protected $allowedFields = [
        "invoice_id",
        "user_id",
        "title",
        "description",
        'price',
        'price_inkl',
        'multiplication',
        'mwst',
        'unit',
        'notes',
        'position'
    ];

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $returnType = InvoicePosition::class;
    protected $useSoftDeletes = true;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getDiverentMwst($invoiceId){
        $found = $this->builder()
            ->select('mwst')
            ->where('invoice_id',$invoiceId)
            ->where('deleted_at =', null)
            ->distinct()
            ->orderBy('mwst')
            ->get()->getResultArray();

        return $found;
    }

}