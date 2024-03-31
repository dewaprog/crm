<?php

namespace App\Models;

use CodeIgniter\Model;

class Company_model extends Model
{
    protected $table = 'company';

    protected $allowedFields = ['company_name', 'created_by', 'updated_by', 'user_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getCompany($company_id = false)
    {
        if ($company_id == false) return $this->where('user_id', user_id())->findAll();
        return $this->where(['company_id' => $company_id])->first();
    }
}
