<?php

namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\WebsiteModel;

class Invoice extends Entity
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

    public function getInvoiceWebsite($websiteid){
        $websiteModel = new WebsiteModel();
        $website = $websiteModel->find($websiteid);

        return ($website) ? $website : null;

    }
}
