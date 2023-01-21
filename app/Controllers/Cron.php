<?php

namespace App\Controllers;

class Cron extends BaseController
{
    public function invoice()
    {
        $websiteModel = new WebsiteModel();
        $websites = $websiteModel->findAll();

        foreach($websites as $id => $website){

        }


    }
}
