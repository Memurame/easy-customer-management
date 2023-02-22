<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Taglist;

class TaglistModel extends Model
{

    public $table = 'taglist';
    protected $db;
    protected $allowedFields = [
        "name",
        "class"
    ];

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $returnType = Taglist::class;
    protected $useSoftDeletes = true;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    

}