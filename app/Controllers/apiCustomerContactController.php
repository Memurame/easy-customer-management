<?php

namespace App\Controllers;

use App\Models\WebsiteModel;
use App\Models\CustomerModel;
use App\Models\ProjectModel;
use App\Models\TaglistModel;
use App\Entities\Website;
use App\Entities\WebsiteTag;
use App\Models\CommentModel;
use CodeIgniter\API\ResponseTrait;

class apiCustomerContactController extends BaseController
{
    use ResponseTrait;

    public function delete($projectId = null){
        $contact = model('CustomerContactModel')->find($projectId);

        if(!$contact){
            return $this->failNotFound('The contact does not exist');
        }

        model('CustomerContactModel')->delete($contact->id);

        return $this->respondDeleted();


    }

}