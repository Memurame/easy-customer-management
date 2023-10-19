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

class apiProjectController extends BaseController
{
    use ResponseTrait;

    public function delete($projectId = null){
        $project = model('ProjectModel')->find($projectId);

        if(!$project){
            return $this->failNotFound('The project does not exist');
        }

        model('ProjectModel')->delete($project->id);

        return $this->respondDeleted();


    }

}