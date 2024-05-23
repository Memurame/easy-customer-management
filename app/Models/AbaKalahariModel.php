<?php

namespace App\Models;

use CodeIgniter\Model;

class AbaKalahariModel extends Model
{
    public $table = 'aba_kalahari';
    protected $db;
    protected $allowedFields = [
        "kalahari",
        "phone"
    ];

    protected $primaryKey = 'kalahari';
    protected $useAutoIncrement = false;
 
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
