<?php 
namespace App\Controllers;

use App\Models\OtpModel;
use CodeIgniter\Controller;
  
class OtpController extends Controller
{
    public function index()
    {
        $table = new \CodeIgniter\View\Table();

        $template = array(
            'table_open' => '<table border="1" class="table" cellpadding="2" cellspacing="1">',
        );

        $table->setTemplate($template);

        $table->setHeading("Phone Number", "OTP");

        $model = new OtpModel();

        $otpInfo = $model->getOtplist();

        foreach ($otpInfo as $otpIn) :
            $table->addRow($otpIn->phone, $otpIn->otp);
        endforeach;

        $html = $table->generate();

        $data['table'] = $html;

        return view('otp_section', $data);
    }
}