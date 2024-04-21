<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AbaAddressController extends BaseController
{
    public function index()
    {
        $addressModel = model('AbaAddressModel');

        $groups = model('AbaGroupModel')->orderBy('group_name')->findAll();
        $types = model('AbaListMembertypeModel')->findAll();

        $addressIds = [];
        $request = [];
        if($this->request->is('post')){
            if($this->request->getPost('groups')){
                $search_groups = model('AbaAddressGroupModel')->searchInGroups($this->request->getPost('groups'));
                $addressIds = $search_groups;
            }
            if($this->request->getPost('membertype')){
                $search_groups = model('AbaAddressModel')->searchInType($addressIds, $this->request->getPost('membertype'));
                $addressIds = array_merge($addressIds, $search_groups);
            }

            $addresses = $addressModel->whereIn('abacus',$search_groups)->findAll();

            $request['groups'] = $this->request->getPost('groups');
            $request['membertype'] = $this->request->getPost('membertype');
            
        } else {
            $addresses = $addressModel->where('abacus IS NOT NULL', NULL)->findAll();
        }
        

       


        return view('abacus/index', [
            'addresses'  => $addresses,
            'groups'    => $groups,
            'types'     => $types,
            'request'     => $request
        ]);
    }
}
