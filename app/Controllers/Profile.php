<?php namespace App\Controllers;

class Profile extends BaseController
{

	public function index()
	{
        $tech = '';
        if(!$this->session->logged_in){
            return redirect()->to(base_url().'/');
        }
        $user = $this->user->where('username',$this->session->username)->first();
        $tech_val = $this->tech->where('employee_no',$user['employee_no'])->find();

        if(count($user)>0){
            $tech = 'Tecnico';
        }
		$data = array(
            "user"=> $user,
            "status" => $this->status->findAll(),
            "profile"=> $this->profile->where('user_id',$user['id'])->first(),
            "tech"=> $tech,
            "view" => 'profile/index',
            "tech" => $tech,
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
