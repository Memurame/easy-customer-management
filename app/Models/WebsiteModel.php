<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Website;

class WebsiteModel extends Model
{

    public $table = 'websites';
    protected $db;
    protected $allowedFields = [
        "contact_lastname",
        "contact_firstname",
        "contact_mail",
        "contact_company",
        "bebv_member",
        "update_abo",
        "website_url",
        "website_installed",
        "website_live",
        "invoice_data",
        'invoice_paid',
        'license_popularfx',
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