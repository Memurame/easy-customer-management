<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\TestimonialForm;

class TestimonialFormModel extends Model
{
    protected $table            = 'testimonials_forms';
    protected $db;
    protected $allowedFields    = [
        "token",
        "title",
        "description",
        "active",
        "data",
    ];

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = TestimonialForm::class;
    protected $useSoftDeletes = false;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
}
