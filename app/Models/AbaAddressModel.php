<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Invoice;

class AbaAddressModel extends Model
{

    public $table = 'aba_address';
    protected $db;
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function searchInType(array $ids, array $type){
        $builder = $this->db->table($this->table);
        $builder->select('abacus');
        if(count($ids) > 0){
            $builder->whereIn('abacus', $ids);
        }
        $builder->where('member_typ', $type);
        $query   = $builder->get();
        $result = $query->getResult();

        $a = [];
        foreach($result as $key => $val){
            $a[] = $val->abacus;
        }

        return $a;
    }

}