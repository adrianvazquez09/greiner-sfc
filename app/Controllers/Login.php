<?php

namespace App\Controllers;

class Login extends BaseController
{

    public function index()
    {

        if ($this->session->logged_in) {
            return redirect()->to(base_url() . '/dashboard');
        }

        echo view('head_base');
        echo view('login/index');
        echo view('footer_base');
        unset($_SESSION['msg']);
    }

    public function requestAccess()
    {
        echo view('head_base');
        echo view('login/requestAccess');
        echo view('footer_base');
    }

    public function resetPassword()
    {
        echo view('head_base');
        echo view('login/resetPassword');
        echo view('footer_base');
    }

    public function login()
    {

        $hash = '';
        $request = \Config\Services::request();
        $qrcode = $request->getPost('qrcode');
        if ($qrcode) { //Login con codigo QR
            $techdata = $this->tech->where('qr', $qrcode)->find();
            if (!empty($techdata)) {
                $userData = $this->user->where('employee_no', $techdata[0]['employee_no'])->where('enabled',1)->find();
                $user = $userData[0]['username'];
                $session = session();
                $newdata = [
                    'username'  => $user,
                    'email'     => $userData[0]['email'],
                    'logged_in' => TRUE,
                    'role'=> $userData[0]['role_id']
                ];
                $session->set($newdata);
                if($userData[0]['role_id']== '2' ||$userData[0]['role_id']== '4' ){
                    return redirect()->to(base_url() . '/capture');
                }
                if($userData[0]['role_id']== '3' ||$userData[0]['role_id']== '5'){
                    return redirect()->to(base_url() . '/machine');
                }else {
                        return redirect()->to(base_url() . '/dashboard');
                    }
            } else {
                $session = session();
                $session->setFlashdata('msg', 'Invalid User please try again');
                $this->index();
            }
        } else {//Login regular
            $user = $request->getPost('username');
            $password = $request->getPost('password');

            $userData = $this->user->where('username', $user)->where('enabled',1)->find();
            if (!empty($userData)) {
                $hash = $userData[0]['password'];
            }
            $validation = password_verify($password, $hash);
            if ($validation) {
                $session = session();
                $newdata = [
                    'username'  => $user,
                    'email'     => $userData[0]['email'],
                    'logged_in' => TRUE,
                    'role'=> $userData[0]['role_id']
                ];
                $session->set($newdata);
                return redirect()->to(base_url() . '/dashboard');
            } else {
                $session = session();
                $session->setFlashdata('msg', 'Invalid User please try again');
                $this->index();
            }
        }
    }

    public function newRegistration()
    { //register view

    }

    public function register()
    { //Register operation

    }



    //--------------------------------------------------------------------

}
