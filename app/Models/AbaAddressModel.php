<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\abaAddress;

class AbaAddressModel extends Model
{

    public $table = 'aba_address';
    protected $db;
    protected $allowedFields = [
        "firstname",
        "lastname",
        "email",
        "abacus",
        "salutation",
        "street",
        "postcode",
        "city",
        "phone1",
        "phone2",
        "mobile",
        "member_typ",
        "paid_percent",
        "paid_date",
        "bebv_regio",
        "bebv_subregio",
        "inactive",
        "newsletter_active",
        "newsletter_unsubscribeid",
        "sync_done",
    ];
    protected $primaryKey = 'id';
    protected $returnType = abaAddress::class;

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
        $builder->whereIn('member_typ', $type);
        $query   = $builder->get();
        $result = $query->getResult();

        $a = [];
        foreach($result as $key => $val){
            $a[] = $val->abacus;
        }

        return $a;
    }

}