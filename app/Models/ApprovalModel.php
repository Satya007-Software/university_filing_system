<?php

namespace App\Models;

use CodeIgniter\Model;

class ApprovalModel extends Model
{
    protected $table = 'approvals';
    protected $primaryKey = 'id';
    protected $allowedFields = ['document_id', 'requested_by', 'approved_by', 'status', 'comments', 'created_at'];
}
