<?php

namespace App\Controllers;

class Help extends BaseController
{
    public function index()
    {

        if (!$this->session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $data = array(
            "view" => 'admin/index',
            "session" => $this->session
        );
        $dataHeader = array(
            "title" => 'Admin Index'
        );
        $dataFooter = array();


        echo view('header_overlay', $dataHeader);
        echo view('overlay', $data);
        echo view('footer_overlay', $dataFooter);
    }
}