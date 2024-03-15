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
        'message_success',
        'mail_confirmation',
        'mail_approved',
        'mail_rejected',
        'mail_new',
        'notify'
    ];

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $returnType = TestimonialForm::class;
    protected $useSoftDeletes = false;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

}
