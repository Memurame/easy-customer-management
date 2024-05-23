<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class abaAddress extends Entity
{
    /**
     * @var array
     */
    protected $datamap = [];

    /**
     * @var string[]
     */
    protected $dates   = [];

    /**
     * @var array
     */
    protected $casts   = [];

    public $data;
}