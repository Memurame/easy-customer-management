<?php

namespace App\Controllers;

use App\Models\WebsiteModel;
use App\Models\CustomerModel;
use App\Models\ProjectModel;
use App\Models\TaglistModel;
use App\Entities\Website;
use App\Entities\WebsiteTag;
use App\Models\CommentModel;

class apiWebsitesController extends BaseController
{
    

    public function getWebsites(){
        $data = array();
        $data['success'] = 0;

        $json = $this->request->getVar();

        $db      = \Config\Database::connect();
        $builder = $db->table('websites');
        $builder->where('deleted_at', null);
        if($json){
            foreach($json as $key => $val){
                $builder->where($key, $val);
            }
        }
        

        $query = $builder->get();
        $websites = $query->getResultArray();

        

        if(!$websites){
            $data['message'] = "Keine Webseiten gefunden.";
        } else {
            $data['success'] = 1;
            $data['data'] = $websites;
        }

        return $this->response->setJSON($data);
    }
}