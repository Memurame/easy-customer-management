<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Website;

class WebsiteModel extends Model
{

    public $table = 'websites';
    protected $db;
    protected $allowedFields = [
        "customer_id",
        "oder_id",
        "website_installed",
        "website_live",
        "website_url",
        "notes"
    ];

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $returnType = Website::class;
    protected $useSoftDeletes = true;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

}