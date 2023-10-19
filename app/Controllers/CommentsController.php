<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Entities\Invoice;
use App\Models\CommentModel;
use App\Entities\Comment;
use App\Models\WebsiteModel;
use App\Entities\Website;
use App\Models\CustomerModel;
use App\Models\ProjectModel;

class CommentsController extends BaseController
{
    

    public function add()
    {

        $websiteModel = new WebsiteModel();
        $websites = $websiteModel->findAll();

        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();

        $projectModel = new ProjectModel();
        $projects = $projectModel->findAll();

        $selected = [];
        if($this->request->getGet('websiteId')){
            $choosedWebsite = $websiteModel->find($this->request->getGet('websiteId'));
            $selected['customer'] = ($choosedWebsite && $choosedWebsite->customer_id) ? $customerModel->find($choosedWebsite->customer_id)->id : 0;
            $selected['website'] = ($choosedWebsite) ? $choosedWebsite->id: 0;
            $selected['project'] = 0;
            $ref = base_url().route_to('website.show', $selected['website']);
        }
        if($this->request->getGet('projectId')){
            $choosedProject = $projectModel->find($this->request->getGet('projectId'));
            $selected['customer'] = ($choosedProject && $choosedProject->customer_id) ?
                $customerModel->find($choosedProject->customer_id)->id : 0;
            $selected['project'] = ($choosedProject)? $choosedProject->id : 0;
            $selected['website'] = 0;
            $ref = base_url().route_to('project.show', $selected['project']);
        }
        if($this->request->getGet('customerId')){
            $choosedCustomer = $customerModel->find($this->request->getGet('customerId'));
            $selected['customer'] = ($choosedCustomer) ? $choosedCustomer->id : 0;
            $selected['project'] = 0;
            $selected['website'] = 0;
            $ref = base_url().route_to('customer.show', $selected['customer']);
        }

        $customer = $customerModel->find($selected['customer']);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'comment' => 'required',
                'customer_id' => 'required'
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Bitte alle erforderlichen Felder ausfüllen');
            }

            $comment = new Comment($this->request->getPost());

            $commentModel = new CommentModel();
            $commentModel->save($comment);

            session()->setFlashdata('msg_success', 'Kommentar gespeichert.');
            return redirect()->to($ref);

        }


        return view('comment/add', [
            'projects' => $projects,
            'customers' => $customers,
            'websites' => $websites,
            'selected' => $selected,
            'customer' => $customer,
            'tomselectProject' => true,
            'tomselectWebsite' => true,
            'ref' => $ref
        ]);
    }

    public function edit($id)
    {
        $commentModel = new CommentModel();
        $comment = $commentModel->find($id);

        $websiteModel = new WebsiteModel();
        $websites = $websiteModel->findAll();

        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();

        $projectModel = new ProjectModel();
        $projects = $projectModel->findAll();

        $customer = $customerModel->find($comment->customer_id);

        if($this->request->getGet('ref') == 'website'){
            $ref = base_url() . route_to('website.show', $comment->website_id);
        }
        if($this->request->getGet('ref') == 'project'){
            $ref = base_url() . route_to('project.show', $comment->project_id);
        }
        if($this->request->getGet('ref') == 'customer'){
            $ref = base_url() . route_to('customer.show', $comment->customer_id);
        }
    


        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'comment' => 'required',
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Bitte alle erforderlichen Felder ausfüllen');
            }

            $comment->comment = $this->request->getPost('comment');
            $comment->comment_typ = $this->request->getPost('comment_typ');

            $commentModel = new CommentModel();
            if($comment->hasChanged()){
                $commentModel->save($comment);
                session()->setFlashdata('msg_success', 'Kommentar gespeichert.');
            } else {
                session()->setFlashdata('msg_info', 'Es wurden keine änderungen erkannt.');
            }
            

            return redirect()->to($ref)->with('msg_success', 'Kommentar gespeichert');

        }


        return view('comment/edit', [
            'projects' => $projects,
            'customers' => $customers,
            'websites' => $websites,
            'comment' => $comment,
            'customer' => $customer
        ]);
    }

    public function apiDelete($id){
        $data = array();
        $data['success'] = 0;
        $data['token'] = csrf_hash();

        $commentModel = new CommentModel();
        $comment = $commentModel->find($id);

        if(empty($comment)){
            $data['error'] = "Kommentar wurde nicht gefunden.";
        } else {
            $deleted = $commentModel->delete($comment->id);
            if($deleted){
                $data['success'] = 1;
            } else {
                $data['error'] = "Fehler beim Lsöchen des Kommentar";
            }
        }


        return $this->response->setJSON($data);
    }


}