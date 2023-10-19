<?php

namespace App\Models;

use App\Entities\Group;
use CodeIgniter\Model;

class GroupModel extends Model
{
    protected $db;
    protected $table            = 'auth_groups';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = Group::class;
    protected $useSoftDeletes = false;

    protected $allowedFields    = [
        'name',
        'title',
        'description',
        'id_admin',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }


}
