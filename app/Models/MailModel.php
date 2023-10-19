<?php

namespace App\Models;

use App\Entities\Mail;
use CodeIgniter\Model;

class MailModel extends Model
{
    public $table = "mails";
    protected $db;
    protected $allowedFields = [
        "user_id",
        "queue_id",
        "type",
        "name",
        "reply_to",
        "receiver",
        "subject",
        "text",
        "error",
        "error_retries",
        "sent_at",
    ];

    protected $primaryKey = "id";
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $dateFormat = "int";

    protected $returnType = Mail::class;
    protected $useSoftDeletes = false;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
}