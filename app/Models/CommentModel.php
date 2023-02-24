<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Comment;

class CommentModel extends Model
{

    public $table = 'comments';
    protected $db;
    protected $allowedFields = [
        "website_id",
        "customer_id",
        "project_id",
        "comment",
        "comment_typ"
    ];

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $returnType = Comment::class;
    protected $useSoftDeletes = true;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

}