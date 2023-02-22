<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
        if(!$this->session->logged_in){
            return redirect()->to(base_url().'/');
        }

		$statusData = $this->status->findAll();

		$data = array(
            "status" => $statusData,
            "view" => 'dashboard/index',
            "session" => $this->session
		);
		$dataHeader = array(
            "title" => 'Dashboard'
        );
		$dataFooter = array();


		echo view('header_overlay', $dataHeader);
		echo view('overlay', $data);
		echo view('footer_overlay', $dataFooter);
	}

	//--------------------------------------------------------------------

}
