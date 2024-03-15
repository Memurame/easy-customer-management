<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Testimonial;

class TestimonialModel extends Model
{
    protected $table            = 'testimonials';
    protected $db;
    protected $allowedFields    = [
        "firstname",
        "lastname",
        "email",
        "form",
        "data",
        "notes",
        "active",
        "token_view",
        "token_edit",
        'log'
    ];

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = Testimonial::class;
    protected $useSoftDeletes = false;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
}
