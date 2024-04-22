<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Models\InvoicePositionModel;

class InvoicePosition extends Entity
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


    public function getMwstDecimal(){
        return $this->mwst / 100;
    }

    public function getPositionTotal($inkl = true){
        
        $total = $this->price * $this->multiplication;

        if($inkl){
            if(!$this->price_inkl){
                $total = $total * ($this->getMwstDecimal() + 1);
            }
        } else {
            if($this->price_inkl){
                $total = $total / ($this->getMwstDecimal() + 1);
            }
        }
        
        

        return round($total,2);
    }

    public function getPositionUnitprice($inkl = true){

        $total = $this->price;

        if($inkl){
            if(!$this->price_inkl){
                $total = $total * ($this->getMwstDecimal() + 1);
            }
        } else {
            if($this->price_inkl){
                $total = $total / ($this->getMwstDecimal() + 1);
            }
        }


        return round($total,2);
    }

    /* ########################################################
     * Ab hier sind Funktionen für die API
     #########################################################*/
     public function prepareForReturn(){
        $r = model('InvoicePositionModel')
            ->find($this->id);

        $return = [];
        $return['id'] = $r->id;
        $return['position'] = $r->position;
        $return['title'] = $r->title;
        $return['description'] = $r->description;
        $return['price'] = $r->price;
        $return['price_inkl'] = $r->price_inkl;
        $return['amount'] = $r->amount;
        $return['mwst'] = $r->mwst;
        $return['notes'] = $r->notes;
        $return['type'] = $r->type;
        $return['order'] = $r->ord;

        return $return ?? null;
    }
}