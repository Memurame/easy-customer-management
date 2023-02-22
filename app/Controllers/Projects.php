<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Entities\Invoice;
use App\Models\WebsiteModel;
use App\Entities\Website;
use App\Models\ProjectModel;
use App\Entities\Project;
use App\Models\CustomerModel;

class Projects extends BaseController
{
    public function index()
    {
        $projectsModel = new ProjectModel();
        $projects = $projectsModel->findAll();


        return view('projects/index', [
            'projects' => $projects
        ]);
    }

    public function add()
    {
        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'name' => 'required',
                'status' => 'required',
                'customer_id' => 'required'
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $project = new Project($this->request->getPost(['name', 'status', 'customer_id', 'notes']));
            $project->date_offer = $this->request->getPost('date_offer') ?: null;
            $project->date_order = $this->request->getPost('date_order') ?: null;
            $project->date_finish = $this->request->getPost('date_finish') ?: null;


            $projectModel = new ProjectModel();
            $projectModel->save($project);

            return redirect()->route('project.index');

        }

        return view('projects/add', [
            'customers' => $customers
        ]);
    }

    public function edit($id)
    {

        $projectModel = new ProjectModel();
        $project = $projectModel->find($id);

        if(!$project){
            return redirect()->route('project.index');
        }


        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'name' => 'required',
                'status' => 'required',
                'customer_id' => 'required'
            ];

            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }


            $project->name = $this->request->getPost('name');
            $project->status = $this->request->getPost('status');
            $project->customer_id = $this->request->getPost('customer_id');
            $project->notes = $this->request->getPost('notes');
            $project->date_order = $this->request->getPost('date_order') ?: null;
            $project->date_offer = $this->request->getPost('date_offer') ?: null;
            $project->date_order = $this->request->getPost('date_order') ?: null;
            $project->date_finish = $this->request->getPost('date_finish') ?: null;


            $projectModel = new ProjectModel();
            if($project->hasChanged()){
                $projectModel->save($project);
            }
            

            return redirect()->route('project.index');

        }

        return view('projects/edit', [
            'customers' => $customers,
            'project' => $project
        ]);
    }

    public function show($id)
    {
        $projectModel = new ProjectModel();
        $project = $projectModel->find($id);
        
        if(!$project){
            return redirect()->route('website.index');
        }
        return view('projects/show', [
            'project' => $project
        ]);
    }

    public function apiDelete($id){
        $data = array();
        $data['success'] = 0;
        $data['token'] = csrf_hash();

        $projectModel = new ProjectModel();
        $project = $projectModel->find($id);

        if(empty($project)){
            $data['error'] = "Projekt wurde nicht gefunden.";
        } else {
            $deleted = $projectModel->delete($project->id);
            if($deleted){
                $data['success'] = 1;
            } else {
                $data['error'] = "Fehler beim Lsöchen des Projekts";
            }
        }


        return $this->response->setJSON($data);
    }

}