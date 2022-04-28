<?php

namespace App\Controllers;

use App\Models\OtpModel;
use CodeIgniter\Controller;
use App\Models\UserModel;

class SignupController extends Controller
{
    public function index()
    {
        helper(['form']);
        $data = [];
        echo view('signup', $data);
    }

    public function store()
    {
        print_r('test');
        die;
        helper(['form']);
        $rules = [
            'phone' => 'required|min_length[10]|max_length[10]|is_unique[users.phone]'
        ];

        if ($this->validate($rules)) {
            $userModel = new UserModel();
            $data = [
                'phone'     => $this->request->getVar('phone'),
            ];
            $userModel->save($data);

            return redirect()->to('/signin');
        } else {
            $data['validation'] = $this->validator;

            echo view('signup', $data);
        }
    }

    public function verifyUser()
    {
        helper(['form']);
        $rules = [
            'phone' => 'required|min_length[10]|max_length[10]',
            'userType' => 'required',
        ];
        
        if (!$this->validate($rules)) {
            $validation = $this->validator->getErrors();
        
            $response['data']['success'] = 400;
            $response['data']['message'] = $validation;

            return json_encode($response);
        }

        $model = new UserModel();
        $user = $model->getUsersByPhone($this->request->getVar('phone'), $this->request->getVar('userType'));

        if (!$user) {
            $response['data']['success'] = 400;
            $response['data']['message'] = ['user not found'];
            return json_encode($response);
        }

        $isSent = $this->sendOtp($this->request->getVar('phone'));

        $response['data'] = array();

        if ($isSent) {
            $response['data']['success'] = 200;
            $response['data']['message'] = ['otp sent successfully to user'];
        } else {
            $response['data']['success'] = 400;
            $response['data']['message'] = ['Something went wrong please try again'];
        }

        if ($user) {
            return json_encode($response);
        }

        //If user not found save user details
        $data = [
            'phone' => $this->request->getVar('phone'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $model->save($data);

        return json_encode($response);
    }

    public function sendOtp($phoneNo)
    {
        $otpModel = new OtpModel();

        $otpUser = $otpModel->getUsersByPhone($phoneNo);

        $otp = $this->get_sms_token();

        //curl to send sms

        if ($otpUser) {
            $data = array(
                'otp' => $otp,
                'updated_at' => date('Y-m-d H:i:s')
            );

            $otpModel->sendOtp(array('phone' => $phoneNo), $data);
        } else {
            $otpData = [
                'phone' => $phoneNo,
                'otp' => $otp,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $otpModel->save($otpData);
        }

        return true;
    }

    public function verifyOtp()
    {

        helper(['form']);
        $rules = [
            'otp' => 'required|min_length[4]|max_length[4]'
        ];

        $response['data'] = array();
        
        if ($this->validate($rules)) {
            $verifyOtpModel = new OtpModel();
            $isValid = $verifyOtpModel->getVerifiedOtp(
                $this->request->getVar('phone'),
                $this->request->getVar('otp')
            );
            if ($isValid && ($isValid->otp == $this->request->getVar('otp'))) {

                $session = session();
                $userModel = new UserModel();
                $phone = $this->request->getVar('phone');

                $data = $userModel->where('phone', $phone)->first();

                $ses_data = [
                    'id' => $data['id'],
                    'phone' => $data['phone'],
                    'type' => $data['type'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                
                $response['data']['success'] = 200;
                $response['data']['message'] = ['Otp verified successfully'];

                return json_encode($response);

            } else {
                $response['data']['success'] = 400;
                $response['data']['message'] = ['Incorrect Otp'];
            }

            return json_encode($response);
   
        } else {
            $validation = $this->validator->getErrors();
        
            $response['data']['success'] = 400;
            $response['data']['message'] = $validation;

            return json_encode($response);
        }
    }

    function get_sms_token($length = 4)
    {
        return rand(
            ((int) str_pad(1, $length, 0, STR_PAD_RIGHT)),
            ((int) str_pad(9, $length, 9, STR_PAD_RIGHT))
        );
    }
}
