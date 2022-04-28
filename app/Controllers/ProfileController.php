<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
  
class ProfileController extends Controller
{
    public function index()
    {
        $session = session();
        helper(['form']);
        $data = [];

        if ($session->get('type') == 'admin') {
            echo view('add_users', $data);
        }else{
            echo view('add_users_documents', $data);
        }

    }
}