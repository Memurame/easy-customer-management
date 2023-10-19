<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class apiTagController extends BaseController
{
    use ResponseTrait;

    public function delete($tagId = null){
        $tag = model('TaglistModel')->find($tagId);

        if(!$tag){
            return $this->failNotFound('The tag does not exist');
        }


        model('TaglistModel')->delete($tag->id, true);

        return $this->respondDeleted();


    }

}