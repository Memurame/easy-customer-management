<?php

namespace App\Entities;

use CodeIgniter\Entity;

class Mail extends Entity
{
    /**
     * @var array
     */
    protected $datamap = [];

    /**
     * @var string[]
     */
    protected $dates = ["created_at", "updated_at", "deleted_at"];

    /**
     * @var array
     */
    protected $casts = [];

    public $data;
}