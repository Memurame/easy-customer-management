<?php

namespace App\Models;

use App\Entities\GroupPermission;
use CodeIgniter\Model;

class GroupPermissionModel extends Model
{
    protected $db;
    protected $table            = 'auth_permissions_groups';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = GroupPermission::class;
    protected $useSoftDeletes = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'group_id',
        'permission',
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
