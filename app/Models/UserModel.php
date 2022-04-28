<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';

    protected $allowedFields = [
        'name',
        'email',
        'phone',
        'type',
        'is_verified',
        'status',
        'created_at',
        'updated_at'
    ];

    public function getUsersByPhone($phone, $type)
    {
        $sql = "SELECT * FROM users WHERE phone = ? AND type = ?";
       
        $query = $this->db->query($sql, array($phone, $type));
         
        return $query->getRow();
    }

    public function getUserslist() {     

		$query = $this->db->table($this->table)->where('type', 'user')->get();
        
		return $query->getResult();
    }
}
