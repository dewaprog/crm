<?php

namespace App\Controllers;

use App\Models\Member_model;
use App\Models\Company_model;

class Home extends BaseController
{
    private $member;
    private $company;
    public function __construct()
    {
        $this->member = new Member_model();
        $this->company = new Company_model();
    }
    public function index()
    {
        $project = $this->company->where('user_id', 1)->orderBy('is_default', 'DESC')->findAll();
        $d = $this->company->where('user_id', 1)->orderBy('is_default', 'DESC')->findAll();
        $m =  $this->member->where('is_default', 1)->first();
        $m = $m['company_member'];
        // die($m);
        $data = [
            'title' => 'PROJECT3',
            'member' => $m,
            'pager' => $this->member->pager,
            'company' => $d,
        ];
        return view("dashboard", $data);
    }
}
