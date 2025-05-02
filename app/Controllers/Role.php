<?php

namespace App\Controllers;

class Role extends BaseController
{
    public function index()
    {
        $req = $this->request->getVar();
        $data['req'] = $req;

        $roleModel = new \App\Models\RoleModel();
        $data['role'] = $roleModel->roles($req)->paginate(10);
        $data['pager'] = $roleModel->pager;

        return view('role/index', $data);
    }

    public function add_post()
    {
        $roleModel = new \App\Models\RoleModel();
        $data = [
            'role' => $this->request->getVar('role')
        ];
        $roleModel->insert($data);
        return $this->response->setJSON($data);
    }

    public function edit($id)
    {
        $roleModel = new \App\Models\RoleModel();
        $data = $roleModel->find($id);
        return $this->response->setJSON($data);
    }

    public function edit_post($id)
    {
        $roleModel = new \App\Models\RoleModel();
        $data = [
            'role' => $this->request->getVar('role')
        ];
        $update_id = $roleModel->update($id, $data);
        return $this->response->setJSON($update_id);
    }

    public function delete($id)
    {
        $roleModel = new \App\Models\RoleModel();
        // $roleModel->delete($id);
    }
}
