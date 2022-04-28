<?php

namespace App\Models;

use CodeIgniter\Model;

class OtpModel extends Model
{
    protected $table = 'otp';

    protected $allowedFields = [
        'id',
        'phone',
        'otp',
        'otp_count',
        'created_at',
        'updated_at',
    ];


    public function getUsersByPhone($phone)
    {
        $sql = 'select * from otp where phone ='.$phone ;
        $query =  $this->db->query($sql);
         
        return $query->getRow();
    }

    public function sendOtp($where, $data) {
        $this->db->table($this->table)->update($data, $where);
        return $this->db->affectedRows();
    }

    public function getVerifiedOtp($phone, $otp)
    {
        $sql = 'select * from otp where phone ='.$phone.' and otp ='.$otp;

        $query =  $this->db->query($sql);
         
        return $query->getRow();
    }

    public function getOtplist() {     

		$query = $this->db->table($this->table)->get();
        
		return $query->getResult();
    }
    
}
