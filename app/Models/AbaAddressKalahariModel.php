<?php

namespace App\Models;

use CodeIgniter\Model;

class AbaAddressKalahariModel extends Model
{
    public $table = 'aba_address_kalahari';
    protected $db;protected $allowedFields = [
        "kalahari",
        "abacus"
    ];

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function truncateTable(){
        $this->db->query('TRUNCATE ' . $this->table);
    }
}
