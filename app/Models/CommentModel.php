<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    // Table name
    protected $table = 'comments';

    // Primary key
    protected $primaryKey = 'id';

    // Allowed fields for mass assignment
    protected $allowedFields = ['document_id', 'user_id', 'comment', 'created_at'];

    // Use timestamps (if you want to automatically manage created_at and updated_at)
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // No updated_at field in this table

    // Validation rules
    protected $validationRules = [
        'document_id' => 'required|numeric',
        'user_id'     => 'required|numeric',
        'comment'     => 'required|min_length[5]|max_length[1000]',
    ];

    // Validation messages
    protected $validationMessages = [
        'document_id' => [
            'required' => 'The document ID is required.',
            'numeric'  => 'The document ID must be a number.',
        ],
        'user_id' => [
            'required' => 'The user ID is required.',
            'numeric'  => 'The user ID must be a number.',
        ],
        'comment' => [
            'required'   => 'The comment is required.',
            'min_length' => 'The comment must be at least 5 characters long.',
            'max_length' => 'The comment cannot exceed 1000 characters.',
        ],
    ];

    // Relationships (if needed)
    public function getUserComments($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }

    public function getDocumentComments($documentId)
    {
        return $this->where('document_id', $documentId)
                   ->join('users', 'users.id = comments.user_id')
                   ->select('comments.*, users.name as user_name')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }
}