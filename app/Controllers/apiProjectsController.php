<?php

namespace App\Controllers;

use App\Models\WebsiteModel;
use App\Models\CustomerModel;
use App\Models\ProjectModel;
use App\Models\TaglistModel;
use App\Entities\Website;
use App\Entities\WebsiteTag;
use App\Models\CommentModel;

class apiProjectsController extends BaseController
{
    

    public function getProjects(){
        $data = array();
        $data['success'] = 0;

        $json = $this->request->getVar();

        $db      = \Config\Database::connect();
        $builder = $db->table('projects');
        $builder->where('deleted_at', null);
        if($json){
            foreach($json as $key => $val){
                $builder->where($key, $val);
            }
        }
        

        $query = $builder->get();
        $projects = $query->getResultArray();

        

        if(!$projects){
            $data['message'] = "Keine Projekte gefunden.";
        } else {
            $data['success'] = 1;
            $data['data'] = $projects;
        }

        return $this->response->setJSON($data);
    }
}