<?php

namespace App\Models;

use CodeIgniter\Model;

class AbaGroupModel extends Model
{

    public $table = 'aba_groups';
    protected $db;
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

}