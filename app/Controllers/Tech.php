<?php namespace App\Controllers;

class Tech extends BaseController
{
	public function index()
	{
		echo view('technician/header');
		echo view('technician/index');
		echo view('technician/footer');
	}

	public function validateTech($qr){

        $techModel = new \App\Models\TechnicianModel();
        $dataTechnician = $techModel->where('qr',$qr)->findAll();

		var_dump($dataTechnician);
		echo "OK";
        
        echo view('technician/index',$dataTechnician[0]);

	}



	//--------------------------------------------------------------------

}
