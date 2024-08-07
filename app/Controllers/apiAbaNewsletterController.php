<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class apiAbaNewsletterController extends BaseController
{
    use ResponseTrait;

    public function delete($id = null){
        $address = model('AbaAddressModel')->find($id);

        if(!$address && $address->abacus != NULL){
            return $this->failNotFound('The receiver does not exist');
        }

        
        model('AbaAddressModel')->delete($address->id, true);

        return $this->respondDeleted();


    }

}