<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Comment extends Entity
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

    public $data;

    /* ########################################################
 * Ab hier sind Funktionen für die API
 #########################################################*/
    public function prepareForReturn(){
        $r = model('CustomerModel')->find($this->id);

        $return = [];
        $return['id'] = $r->id;
        $return['assign']['customer'] = $r->customer_id;
        $return['assign']['project'] = $r->project_id ?? null;
        $return['url'] = $r->website_url;
        $return['live'] = $r->website_live;
        $return['installed'] = $r->website_installed;
        $return['notes'] = $r->notes;
        $return['tags'] = [];

        return $return ?? null;
    }
}