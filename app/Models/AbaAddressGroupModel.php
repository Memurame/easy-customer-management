<?php

namespace App\Models;

use CodeIgniter\Model;

class AbaAddressGroupModel extends Model
{

    public $table = 'aba_address_groups';
    protected $db;
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function searchInGroups(array $ids){
        $builder = $this->db->table($this->table);
        $builder->select('address_id');
        $builder->whereIn('group_id', $ids);
        $builder->groupBy('address_id');
        $query   = $builder->get();
        $result = $query->getResult();

        $a = [];
        foreach($result as $key => $val){
            $a[] = $val->address_id;
        }

        return $a;
    }

}