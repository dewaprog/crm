<?php

namespace App\Controllers;

use App\Models\Member_model;

class Home extends BaseController
{
    private $member;
    public function __construct()
    {
        $this->member = new Member_model();
    }
    public function index()
    {
        $m =  $this->member->where('is_default', 1)->first();


        $m = $m['company_member'];
        // die($m);
        $data = [
            'title' => 'PROJECT',
            'member' => $m,
            'pager' => $this->member->pager,
        ];
        return view("dashboard", $data);
    }
}
