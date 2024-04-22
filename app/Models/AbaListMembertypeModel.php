<?php

namespace App\Models;

use CodeIgniter\Model;

class AbaListMembertypeModel extends Model
{

    public $table = 'aba_list_membertypes';
    protected $db;
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

}