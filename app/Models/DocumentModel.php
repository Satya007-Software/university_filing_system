<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model
{
    public function archiveDocument($documentId)
{
    return $this->update($documentId, ['status' => 'Archived']);
}

public function deleteDocument($documentId)
{
    return $this->delete($documentId);
}
    protected $table = 'documents';
    protected $primaryKey = 'id';
    protected $allowedFields = ['document_name', 'uploaded_by', 'department', 'file_path', 'status', 'created_at'];
}
