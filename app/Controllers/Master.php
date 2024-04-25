<?php

namespace App\Controllers;

use App\Models\Company_model;
use App\Models\Project_model;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

class Master extends BaseController
{

    private $company;
    private $project;
    public function __construct()
    {
        $this->company = new Company_model();
        $this->project = new Project_model();
    }

    public function company()
    {
        $data = [
            'title' => 'Company',
            // 'company' => $this->company->getCompany(),
            'company' => $this->company->where('user_id', user_id())->paginate(3),
            'pager' => $this->company->pager,
        ];
        return view("company/company_view", $data);
    }

    public function company_save()
    {
        $id = false;
        if ($this->request->getVar('company_id')) $id = $this->request->getVar('company_id');
        if ($id == false) {
            $this->company->save([
                'company_name' => $this->request->getVar('company_name'),
                'created_by' => user_id(),
                'user_id' => user_id(),
            ]);
            $msg = "Success, Data have been Added";
        } else {
            $this->company
                ->where(['company_id' => $id])
                ->set([
                    'company_name' => $this->request->getVar('company_name'),
                    'update_by' => user_id(),
                ])
                ->update();
            $msg = "Success, Data have been Edited";
        }
        session()->setFlashdata('success', $msg);
        return redirect()->to('/company');
    }

    public function company_delete()
    {
        $company_id = $this->request->getVar('company_id');
        $this->company->where(['company_id' => $company_id, 'user_id' => user_id()])->delete();
        session()->setFlashdata('success', 'Success, Data have been Deleted');
        return redirect()->to('/company');
    }

    public function project_save()
    {
        //  dd($this->request->getVar());
        $id = false;
        if ($this->request->getVar('project_id')) $id = $this->request->getVar('project_id');

        if ($id == false) {
            $this->project->save([
                'company_id' => $this->request->getVar('company_id'),
                'project_name' => $this->request->getVar('project_name'),
                'default_view' => $this->request->getVar('default_view'),
                'is_approval' => $this->request->getVar('is_approval'),
                'approval_member' => $this->request->getVar('approval_by'),
                'project_member' => $this->request->getVar('member'),
                'created_by' => user_id(),
            ]);
            $msg = "Success, Data have been Added";
        } else {
            $this->project
                ->where(['project_id' => $id])
                ->set([
                    'project_name' => $this->request->getVar('project_name'),
                    'default_view' => $this->request->getVar('default_view'),
                    'is_approval' => $this->request->getVar('is_approval'),
                    'approval_member' => $this->request->getVar('approval_by'),
                    'project_member' => $this->request->getVar('member'),
                    'created_by' => user_id(),
                ])
                ->update();
            $msg = "Success, Data have been Edited";
        }
        session()->setFlashdata('success', $msg);
        return redirect()->to('/');
    }
}
