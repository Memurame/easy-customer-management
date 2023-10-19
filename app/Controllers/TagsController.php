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
use App\Models\TaglistModel;
use App\Entities\Taglist;

class TagsController extends BaseController
{
    public function index()
    {
        $taglistModel = new TaglistModel();
        $taglist = $taglistModel->orderBy('name')->findAll();


        return view('admin/taglist/index', [
            'taglist' => $taglist
        ]);
    }

    public function add()
    {
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'name' => 'required',
                'class' => 'required'
            ];

            if (! $this->validate($rules))
            {
                session()->setFlashdata('msg_error', 'Bitte fülle die erforderlichen Felder aus');
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $taglist = new Taglist($this->request->getPost(['name', 'class']));
            $taglistModel = new TaglistModel();
            $taglistModel->save($taglist);

            session()->setFlashdata('msg_success', 'Schlagwort erfolgreich angelegt.');
            return redirect()->route('tag.index');

        }

        return view('admin/taglist/add');
    }

    public function edit($id)
    {

        $taglistModel = new TaglistModel();
        $taglist = $taglistModel->find($id);

        if(!$taglist){
            session()->setFlashdata('msg_error', 'Das ausgewählte Schlagwort wurde nicht gefunden.');
            return redirect()->route('tag.index');
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $rules = [
                'name' => 'required',
                'class' => 'required'
            ];

            if (! $this->validate($rules))
            {
                session()->setFlashdata('msg_error', 'Bitte fülle die erforderlichen Felder aus');
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }


            $taglist->name = $this->request->getPost('name');
            $taglist->class = $this->request->getPost('class');


            if($taglist->hasChanged()){
                $taglistModel->save($taglist);
                session()->setFlashdata('msg_success', 'Schlagwort gespeichert.');
            } else {
                session()->setFlashdata('msg_info', 'Es wurden keine änderungen erkannt.');
            }
            

            return redirect()->route('tag.index');

        }

        return view('admin/taglist/edit', [
            'taglist' => $taglist
        ]);
    }


    public function apiDelete($id){
        $data = array();
        $data['success'] = 0;
        $data['token'] = csrf_hash();

        $taglistModel = new TaglistModel();
        $taglist = $taglistModel->find($id);

        if(empty($taglist)){
            $data['error'] = "Schlagwort wurde nicht gefunden.";
        } else {
            $deleted = $taglistModel->delete($taglist->id);
            if($deleted){
                $data['success'] = 1;
            } else {
                $data['error'] = "Fehler beim Löschen des Schlagwort";
            }
        }


        return $this->response->setJSON($data);
    }

}