<?php

namespace App\Controllers;

use App\Models\WebsiteModel;
use App\Entities\Website;

class Websites extends BaseController
{
    public function index()
    {
        $websiteModel = new WebsiteModel();
        $websites = $websiteModel->findAll();

        return view('website/index', [
            'websites' => $websites
        ]);
    }

    public function add()
    {

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'contact_firstname' => 'required',
                'contact_lastname' => 'required',
                'contact_mail' => 'required',
                'bebv_member' => 'required',
                'update_abo' => 'required',
                'website_url' => 'required',
                'license_popularfx' => 'required',
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $website = new Website($this->request->getPost());

            $websiteModel = new WebsiteModel();
            $websiteModel->save($website);

            return redirect()->route('website.index');

        }

        return view('website/add');
    }

    public function show($id)
    {
        $websiteModel = new WebsiteModel();
        $website = $websiteModel->find($id);
        

        return view('website/show', [
            'website' => $website
        ]);
    }
}
