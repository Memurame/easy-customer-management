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

    public function edit($id)
    {
        $websiteModel = new WebsiteModel();
        $website = $websiteModel->find($id);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){


            $rules = [
                'update_abo' => 'required',
                'website_url' => 'required',
                'license_popularfx' => 'required',
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $website->website_installed = $this->request->getPost('website_installed');
            $website->website_live = $this->request->getPost('website_live');
            $website->website_url = $this->request->getPost('website_url');
            $website->license_popularfx = $this->request->getPost('license_popularfx');
            $website->update_abo = $this->request->getPost('update_abo');
            $website->notes = $this->request->getPost('notes');

            $websiteModel->save($website);

            return redirect()->route('website.show', [$id]);

        }

        return view('website/edit', [
            'website' => $website
        ]);
    }

    public function show($id)
    {
        $websiteModel = new WebsiteModel();
        $website = $websiteModel->find($id);
        

        return view('website/show', [
            'website' => $website
        ]);
    }

    public function apiDelete($id){
        $data = array();
        $data['success'] = 0;
        $data['token'] = csrf_hash();

        $websiteModel = new WebsiteModel();
        $website = $websiteModel->find($id);

        if(empty($website)){
            $data['error'] = "Webseite wurde nicht gefunden.";
        } else {
            $deleted = $websiteModel->delete($website->id);
            if($deleted){
                $data['success'] = 1;
            } else {
                $data['error'] = "Fehler beim Lsöchen der Webseite";
            }
        }


        return $this->response->setJSON($data);
    }
}
