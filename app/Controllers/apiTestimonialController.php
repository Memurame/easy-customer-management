<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class apiTestimonialController extends BaseController
{
    use ResponseTrait;

    public function delete($id = null){
        $testimonial = model('TestimonialModel')->find($id);

        if(!$testimonial){
            return $this->failNotFound('The tag does not exist');
        }


        model('TestimonialModel')->delete($testimonial->id, true);

        return $this->respondDeleted();


    }

}