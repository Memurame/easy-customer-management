<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Project;

class ProjectModel extends Model
{

    public $table = 'projects';
    protected $db;
    protected $allowedFields = [
        "customer_id",
        "status",
        "name",
        "date_offer",
        "date_order",
        "date_finish",
        'notes'
    ];

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $returnType = Project::class;
    protected $useSoftDeletes = false;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
    /* ########################################################
 * Ab hier sind Funktionen für die API
 #########################################################*/

    public function getProjectsByCustomer($customerId){
        $return = [];
        $projects = $this->where('customer_id', $customerId)->findAll();


        foreach($projects as $val){
            $return[] = $val->prepareForReturn();
        }


        return $return;
    }

    public function getAllProjects(){
        $return = [];
        $projects = $this->findAll();


        foreach($projects as $val){
            $return[] = $val->prepareForReturn();
        }


        return $return;
    }


}