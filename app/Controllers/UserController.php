<?php

namespace App\Controllers;

use App\Models\OtpModel;
use CodeIgniter\Controller;
use App\Models\UserModel;

class UserController extends Controller
{
    public function index()
    {
        $session = session();
        helper(['form']);
        $data = [];

        if ($session->get('type') != 'admin') {
            return redirect()->to('/users/console');
        } else {
            $table = new \CodeIgniter\View\Table();

            $template = array(
                'table_open' => '<table border="1" class="table" cellpadding="2" cellspacing="1">',
            );

            $table->setTemplate($template);

            $table->setHeading("Phone Number", "User's Name", "Email", "Verified", "View documents", "Created at");

            $model = new UserModel();

            $usersInfo = $model->getUserslist();

            foreach ($usersInfo as $userInfo) :
                $table->addRow($userInfo->phone, $userInfo->name, $userInfo->email, $userInfo->status, "<a href='documents/$userInfo->id' class='btn btn-sm btn-primary'>View document</a>", $userInfo->created_at);
            endforeach;

            $html = $table->generate();

            $data['table'] = $html;

            return view('usersListView', $data);
        }
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

    public function storeUser()
    {
        helper(['form']);
        $rules = [
            'phone' => 'required|min_length[10]|max_length[10]|is_unique[users.phone]',
            'name' => 'required|min_length[2]|max_length[50]',
            'email' => 'required|min_length[4]|max_length[100]|valid_email',
        ];

        if ($this->validate($rules)) {

            $storeUsermodel = new UserModel();
            $data = [
                'phone' => $this->request->getVar('phone'),
                'name' => $this->request->getVar('name'),
                'email' => $this->request->getVar('email'),
                'type' => 'user',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $storeUsermodel->save($data);

            $response['data']['success'] = 200;
            $response['data']['message'] = 'User saved successfully';

            return json_encode($response);
        } else {

            // $data['validation'] = $this->validator;
            $validation = $this->validator->getErrors();

            $response['data']['success'] = 400;
            $response['data']['message'] = $validation;

            return json_encode($response);
        }
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
                'phone'     => $phoneNo,
                'otp'     => $otp,
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
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);

                $response['data']['success'] = 200;
                $response['data']['message'] = 'Otp verified successfully';

                return json_encode($response);
            } else {
                $response['data']['success'] = 400;
                $response['data']['message'] = 'Incorrect Otp';
            }

            return json_encode($response);
        } else {
            $data['validation'] = $this->validator;
            return 'no';
        }
    }

    function get_sms_token($length = 4)
    {

        return rand(
            ((int) str_pad(1, $length, 0, STR_PAD_RIGHT)),
            ((int) str_pad(9, $length, 9, STR_PAD_RIGHT))
        );
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
