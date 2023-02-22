<?php

namespace App\Controllers;

class SpareParts extends BaseController
{
    public function list()
    {

        if (!$this->session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $spareparts = $this->spareparts->find();
        $data = array(
            "view" => 'spareparts/list',
            "sparepart"=> $spareparts,
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

    public function capture(){ //Capture the required spare parts into the order
        if (!$this->session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $spareparts = $this->spareparts->find();
        $data = array(
            "view" => 'spareparts/capture',
            "sparepart"=> $spareparts,
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

    public function requirements(){ //View the required spareparts that has to be bought
        if (!$this->session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $spareparts = $this->spareparts->find();
        $data = array(
            "view" => 'spareparts/requirements',
            "sparepart"=> $spareparts,
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