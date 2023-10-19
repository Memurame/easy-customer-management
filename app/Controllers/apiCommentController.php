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

class apiCommentController extends BaseController
{
    use ResponseTrait;

    public function delete($commentId = null){
        $comment = model('CommentModel')->find($commentId);

        if(!$comment){
            return $this->failNotFound('The comment does not exist');
        }

        model('CommentModel')->delete($comment->id);

        return $this->respondDeleted();


    }

}