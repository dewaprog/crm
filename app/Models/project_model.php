<?php

namespace App\Models;

use CodeIgniter\Model;

class Project_model extends Model
{
    protected $table = 'project';

    protected $allowedFields = ['project_name', 'created_by', 'updated_by', 'approval_member', 'project_member', 'is_approval', 'default_view', 'company_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getProject($project_id = false)
    {
        if ($project_id == false) return $this->where('created_by', user_id())->findAll();
        return $this->where(['project_id' => $project_id])->first();
    }
}
