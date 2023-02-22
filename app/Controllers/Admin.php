<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        $session = \Config\Services::session();

        if (!$session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $data = array(
            "view" => 'admin/index',
            "session" => $session
        );
        $dataHeader = array(
            "title" => 'Admin Index'
        );
        $dataFooter = array();


        echo view('header_overlay', $dataHeader);
        echo view('overlay', $data);
        echo view('footer_overlay', $dataFooter);
    }

    public function partner()
    {
        $session = \Config\Services::session();

        if (!$session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $PartnerModel = new \App\Models\PartnerModel();
        $partnerData = $PartnerModel->findAll();

        $data = array(
            "view" => 'admin/partner',
            "session" => $session,
            "partner" => $partnerData
        );
        $dataHeader = array(
            "title" => 'Admin Partner'
        );
        $dataFooter = array();


        echo view('header_overlay', $dataHeader);
        echo view('overlay', $data);
        echo view('footer_overlay', $dataFooter);
    }

    public function mold()
    {
        $session = \Config\Services::session();

        if (!$session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $moldData = $this->mold->findAll();
        $partnerData = $this->partner->findAll();
            for($i=0;$i<count($moldData);$i++){
                $value = $moldData[$i]['partner_id']-1;
                if($value >= 0){
                    $moldData[$i]['partner_id'] = trim($partnerData[$value]['name']);
                }
            }
        $data = array(
            "view" => 'admin/mold',
            "session" => $session,
            "mold" => $moldData,
            "partners" => $partnerData
        );
        $dataHeader = array(
            "title" => 'Admin Molds List'
        );
        $dataFooter = array();

        echo view('header_overlay', $dataHeader);
        echo view('overlay', $data);
        echo view('footer_overlay', $dataFooter);
    }
    public function maintenanceTypes()
    {
        $session = \Config\Services::session();

        if (!$session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $MtypeModel = new \App\Models\MaintenanceTypeModel();

        $mTypeModel = $MtypeModel->findAll();
        $data = array(
            "view" => 'admin/maintenanceTypes',
            "session" => $session,
            "mtype" => $mTypeModel
        );
        $dataHeader = array(
            "title" => 'Admin Maintenance Types'
        );
        $dataFooter = array();


        echo view('header_overlay', $dataHeader);
        echo view('overlay', $data);
        echo view('footer_overlay', $dataFooter);
    }

    public function priorities()
    {
        $session = \Config\Services::session();

        if (!$session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $prioModel = new \App\Models\PriorityModel();

        $prioData = $prioModel->findAll();


        $data = array(
            "view" => 'admin/priorities',
            "session" => $session,
            "priorities" => $prioData
        );
        $dataHeader = array(
            "title" => 'Admin Priorities'
        );
        $dataFooter = array();


        echo view('header_overlay', $dataHeader);
        echo view('overlay', $data);
        echo view('footer_overlay', $dataFooter);
    }

    public function usersList()
    {
        if (!$this->session->logged_in && $this->session->role == '3') {
            return redirect()->to(base_url() . '/');
        }
        $users = $this->user->findAll();
        for($i=0;$i<count($users);$i++){
        
            $role_data = $this->role->where('id',$users[$i]['role_id'])->first();
            $users[$i]['role_id'] = $role_data['name'];
        }
        $data = array(
            "view" => 'admin/users/list',
            "users" => $users,
            "session" => $this->session
        );
        $dataHeader = array(
            "title" => 'Admin Users List'
        );
        $dataFooter = array();


        echo view('header_overlay', $dataHeader);
        echo view('overlay', $data);
        echo view('footer_overlay', $dataFooter);
    }

    public function userView($user_id)
    {
        if (!$this->session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $userData = $this->user->where('id',$user_id)->find();
        $data = array(
            "view" => 'admin/users/index',
            "user" => $userData,
            "session" => $this->session
        );
        $dataHeader = array(
            "title" => 'Admin Users List'
        );
        $dataFooter = array();


        echo view('header_overlay', $dataHeader);
        echo view('overlay', $data);
        echo view('footer_overlay', $dataFooter);
    }

    public function captureData(){ //View
        if (!$this->session->logged_in) {
            return redirect()->to(base_url() . '/');
        }   
        $data = array(
            "view" => 'admin/data/capture',
            "session" => $this->session
        );
        $dataHeader = array(
            "title" => 'Admin Capture Data'
        );
        $dataFooter = array();


        echo view('header_overlay', $dataHeader);
        echo view('overlay', $data);
        echo view('footer_overlay', $dataFooter);

    }

    public function getCapturedDataMolds(){ //Actual function
        $capture = $this->capture->getDataCapturedMolds();
        var_dump($capture);
    }

    public function getCapturedDataMachines(){ //Actual function
        $capture = $this->capture->getDataCapturedMachines();
        var_dump($capture);
    }
    
    /**
     * Adding functions
     */
    public function addMold(){
        if (!$this->session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $data = $this->request->getPostGet();
        $this->mold->insert($data);
        return $this->mold();
    }


   
}
