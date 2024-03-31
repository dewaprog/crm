<?php

namespace App\Models;

use CodeIgniter\Model;

class Member_model extends Model
{
    protected $table = 'company';

    public function getCompany($company_id = false)
    {
        if ($company_id == false) return $this->where('user_id', user_id())->findAll();
        return $this->where(['company_id' => $company_id])->first();
    }
}
