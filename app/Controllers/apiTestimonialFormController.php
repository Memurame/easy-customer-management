<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class apiTestimonialFormController extends BaseController
{
    use ResponseTrait;

    public function delete($id = null){
        $form = model('TestimonialFormModel')->find($id);

        if(!$form){
            return $this->failNotFound('The form does not exist');
        }


        model('TestimonialFormModel')->delete($form->id, true);

        return $this->respondDeleted();


    }

}