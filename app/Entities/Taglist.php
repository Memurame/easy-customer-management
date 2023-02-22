<?php

namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\TaglistModel;

class Taglist extends Entity
{
    /**
     * @var array
     */
    protected $datamap = [];

    /**
     * @var string[]
     */
    protected $dates   = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $casts   = [];

    protected $team_name;

    public $data;
}