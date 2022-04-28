<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model
{
    protected $table = 'documents';

    protected $allowedFields = [
        'id',
        'user_id',
        'img_name',
        'file',
        'status',
        'created_at',
        'updated_at',
    ];


    public function getUsersByDocuments($id)
    {
        $sql = 'select users.id, users.name, users.phone, documents.img_name, documents.file from users left join documents on users.id=documents.user_id where users.id ='.$id;
        $query =  $this->db->query($sql);
         
        return $query->getResult();
    }
    
}
