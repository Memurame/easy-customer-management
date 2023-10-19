<?php

namespace App\Models;

use App\Entities\UserDetails;
use CodeIgniter\Model;
use App\Entities\Invoice;

class UserDetailsModel extends Model
{

    public $table = 'user_details';
    protected $db;
    protected $allowedFields = [
        "firstname",
        "lastname",
        "avatar",
        "department",
        "phone",
        "user_id"
    ];

    protected $primaryKey = 'user_id';
    protected $useAutoIncrement = false;

    protected $returnType = UserDetails::class;
    protected $useSoftDeletes = false;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

}