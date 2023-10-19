<?php

namespace App\Controllers;

use App\Models\WebsiteModel;
use App\Models\CustomerModel;
use App\Models\ProjectModel;
use App\Models\TaglistModel;
use App\Entities\Website;
use App\Entities\WebsiteTag;
use App\Models\CommentModel;

class WebsitesController extends BaseController
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

        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();

        $taglistModel = new TaglistModel();
        $taglist = $taglistModel->findAll();

        $projectModel = new ProjectModel();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'customer_id' => 'required',
                'website_url' => 'required'
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Bitte alle erforderlichen Felder ausfüllen');
            }

            $exists_customer = $customerModel->find($this->request->getPost('customer_id'));
            if(!$exists_customer){
                session()->setFlashdata('msg_error', 'Ausgewählter Kunde existiert nicht.');
                return redirect()->back()->withInput();
            }
            if($this->request->getPost('project_id')) {
                $exists_project = $projectModel->find($this->request->getPost('project_id'));
                if (!$exists_project) {
                    session()->setFlashdata('msg_error', 'Ausgewähltes Projekt existiert nicht.');
                    return redirect()->back()->withInput();
                }
            }

            $website = new Website($this->request->getPost());
            $website->website_installed = $this->request->getPost('website_installed') ?: null;
            $website->website_live = $this->request->getPost('website_live') ?: null;

            $websiteModel = new WebsiteModel();
            $websiteModel->save($website);
            
            session()->setFlashdata('msg_success', 'Webseite erfolgreich angelegt.');

            $website = $websiteModel->find($websiteModel->insertID());
            $website->removeAllTags();
            if($this->request->getPost('tags') !== null){
                
                foreach($this->request->getPost('tags') as $tag){
                    $website->addTagToWebsite($tag);
                }
            }
        

            return redirect()->route('website.index');

        }

        return view('website/add', [
            'customers' => $customers,
            'taglist' => $taglist,
            'tomselectProject' => true
        ]);
    }

    public function edit($id)
    {
        $websiteModel = new WebsiteModel();
        $website = $websiteModel->find($id);

        if(!$website){
            session()->setFlashdata('msg_error', 'Die ausgewählte Webseite wurde nicht gefunden.');
            return redirect()->route('website.index');
        }

        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();

        $projectModel = new ProjectModel();
        $projects = $projectModel->where('customer_id', $website->customer_id)->findAll();

        $taglistModel = new TaglistModel();
        $taglist = $taglistModel->findAll();


        if($_SERVER['REQUEST_METHOD'] == 'POST'){


            $rules = [
                'customer_id' => 'required',
                'website_url' => 'required'
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Bitte alle erforderlichen Felder ausfüllen');
            }

            $exists_customer = $customerModel->find($this->request->getPost('customer_id'));
            if(!$exists_customer){
                session()->setFlashdata('msg_error', 'Ausgewählter Kunde existiert nicht.');
                return redirect()->back()->withInput();
            }
            if($this->request->getPost('project_id')){
                $exists_project = $projectModel->find($this->request->getPost('project_id'));
                if($this->request->getPost('project_id') > 0 AND !$exists_project){
                    session()->setFlashdata('msg_error', 'Ausgewähltes Projekt existiert nicht.');
                    return redirect()->back()->withInput();
                }
            }

            //die( $this->request->getPost('website_live'));

            $website->website_installed = $this->request->getPost('website_installed') ?: null;
            $website->website_live = $this->request->getPost('website_live') ?: null;
            $website->website_url = $this->request->getPost('website_url');
            $website->customer_id = $this->request->getPost('customer_id');
            $website->project_id = $this->request->getPost('project_id');
            $website->notes = $this->request->getPost('notes');

            if($website->hasChanged()){
                $websiteModel->save($website);
                session()->setFlashdata('msg_success', 'Webseite gespeichert.');
            } else {
                session()->setFlashdata('msg_info', 'Es wurden keine änderungen erkannt.');
            }
            

            $website->removeAllTags();
            if($this->request->getPost('tags') !== null){
                
                foreach($this->request->getPost('tags') as $tag){
                    $website->addTagToWebsite($tag);
                }
            }
            

            return redirect()->route('website.show', [$id]);

        }

        return view('website/edit', [
            'website' => $website,
            'customers' => $customers,
            'projects' => $projects,
            'taglist' => $taglist,
            'tomselectProject' => true
        ]);
    }

    public function show($id)
    {
        $websiteModel = new WebsiteModel();
        $website = $websiteModel->find($id);
        
        if(!$website){
            session()->setFlashdata('msg_error', 'Die ausgewählte Webseite wurde nicht gefunden.');
            return redirect()->route('website.index');
        }

        $commentModel = new CommentModel();
        $comments = $commentModel->where('website_id', $website->id)->orderBy('id', 'desc')->findAll();

        return view('website/show', [
            'website' => $website,
            'comments' => $comments
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