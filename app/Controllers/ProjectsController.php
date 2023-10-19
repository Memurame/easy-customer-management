<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Entities\Invoice;
use App\Models\WebsiteModel;
use App\Entities\Website;
use App\Models\ProjectModel;
use App\Entities\Project;
use App\Models\CustomerModel;
use App\Models\CommentModel;

class ProjectsController extends BaseController
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
                'customer_id' => 'required|greater_than[0]'
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

            $project = new Project($this->request->getPost(['name', 'status', 'customer_id', 'notes']));
            $project->date_offer = $this->request->getPost('date_offer') ?: null;
            $project->date_order = $this->request->getPost('date_order') ?: null;
            $project->date_finish = $this->request->getPost('date_finish') ?: null;


            $projectModel = new ProjectModel();
            $projectModel->save($project);

            session()->setFlashdata('msg_success', 'Projekt erfolgreich angelegt.');

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
            session()->setFlashdata('msg_error', 'Das ausgewähltes Projekt wurde nicht gefunden.');
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
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('msg_error', 'Bitte alle erforderlichen Felder ausfüllen');
            }

            $exists_customer = $customerModel->find($this->request->getPost('customer_id'));
            if(!$exists_customer){
                session()->setFlashdata('msg_error', 'Ausgewählter Kunde existiert nicht.');
                return redirect()->back()->withInput();
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
                session()->setFlashdata('msg_success', 'Projekt gespeichert.');
            } else {
                session()->setFlashdata('msg_info', 'Es wurden keine änderungen erkannt.');
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
            session()->setFlashdata('msg_error', 'Das ausgewählte Projekt wurde nicht gefunden.');
            return redirect()->route('website.index');
        }

        $commentModel = new CommentModel();
        $comments = $commentModel->where('project_id', $project->id)->orderBy('id', 'desc')->findAll();

        return view('projects/show', [
            'project' => $project,
            'comments' => $comments
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