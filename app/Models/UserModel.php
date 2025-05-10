<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password_hash'];
    
    // Initialize with dynamic allowed fields
    public function __construct()
    {
        parent::__construct();
        
        // Get actual column names from database
        $db = \Config\Database::connect();
        $columns = $db->getFieldNames($this->table);
        
        // Merge with default allowed fields
        $this->allowedFields = array_unique(array_merge(
            $this->allowedFields,
            array_filter($columns, function($field) {
                return !in_array($field, ['id', 'created_at', 'updated_at']);
            })
        ));
    }

    /**
     * Update user password with fallback for email/username
     */
    public function updatePassword($identifier, $hashedPassword)
    {
        $builder = $this->builder();
        
        // Check if email column exists in the users table
        $db = \Config\Database::connect();
        $columns = $db->getFieldNames($this->table);
        $hasEmailColumn = in_array('email', $columns);
        
        // Determine identifier field
        $field = $hasEmailColumn && filter_var($identifier, FILTER_VALIDATE_EMAIL) 
               ? 'email' 
               : 'username';
        
        return $builder->where($field, $identifier)
                      ->update(['password_hash' => $hashedPassword]);
    }
}