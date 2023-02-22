<?php

namespace App\Controllers;

class Qrcodes extends BaseController
{
    public function index(){
        echo "hi";
    }
    public function validation()
    {
        if (!$this->session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $data = array(
            "view" => 'qrcodes/validation',
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

    public function checkData(){
        //Obtenemos la información del post
		$data = $this->request->getPostGet();
        $mold = $this->mold->where('qr',$data['qr_code'])->find();
        $machine = $this->machine->where('qr',$data['qr_code'])->find();

        if(count($mold)>0){
            echo $mold[0]['id'].", ".$mold[0]['name'].", ".$mold[0]['description'].", ".$mold[0]['part_number'];
            echo '<a href="javascript:history.back()"> back </a>';
        } if(count($machine)>0){
            echo $machine[0]['id'].", ".$machine[0]['name'].", ".$machine[0]['brand'].", ".$machine[0]['sn'];
            echo '<a href="javascript:history.back()"> back </a>';
        } else {echo '<a href="javascript:history.back()"> back </a>';}
    }

    public function checkDataAjax($qr_code){
        $mold = $this->mold->where('qr',$qr_code)->find();
        $machine = $this->machine->where('qr',$qr_code)->find();
        $technician = $this->tech->where('qr',$qr_code)->find();
        $work_type = $this->type_work->where('qr',$qr_code)->find();
        $priority = $this->priority->where('qr',$qr_code)->find();
        if(count($mold)>0){
            return "Mold: ".$mold[0]['id'].", ".$mold[0]['name'].", ".$mold[0]['description'].", ".$mold[0]['part_number'];
        } if(count($machine)>0){
            return "Machine: ".$machine[0]['id'].", ".$machine[0]['name'].", ".$machine[0]['brand'].", ".$machine[0]['sn'];
        } if(count($technician)>0){
            return "Technician, ".$technician[0]['id'].", ".$technician[0]['firstname']." ".$technician[0]['lastname'];
        }if(count($work_type)>0){
            return "Work Type, ".$work_type[0]['name'];
        }if(count($priority)>0){
            return "Priority, ".$priority[0]['name'];
        }else {return 'not found';}
    }
}