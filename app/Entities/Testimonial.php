<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Models\TestimonialFormModel;

class Testimonial extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getFormTitle(){

        $formModel = model(TestimonialFormModel::class);

        $form = $formModel->find($this->form);

        return ($form) ? $form->title : null;
    }
}
