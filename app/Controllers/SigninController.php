<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\UserModel;
  
class SigninController extends Controller
{
    public function index()
    {
        helper(['form']);
        echo view('signin');
    } 
  
    public function loginAuth()
    {
        $session = session();
        $userModel = new UserModel();
        $phone = $this->request->getVar('phone');
        $otp = $this->request->getVar('otp');
        
        $data = $userModel->where('phone', $phone)->first();
        
        if($data){
            $verifyOtp = $data['otp'];
            $authenticatePassword = password_verify($verifyOtp, $otp);
            if($authenticatePassword){
                $ses_data = [
                    'id' => $data['id'],
                    'phone' => $data['phone'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/profile');
            
            }else{
                $session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('/signin');
            }
        }else{
            $session->setFlashdata('msg', 'Email does not exist.');
            return redirect()->to('/signin');
        }
    }
}