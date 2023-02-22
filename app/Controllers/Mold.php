<?php

namespace App\Controllers;

class Mold extends BaseController
{
    public function index()
    {
        return view('mold/index');
    }

    public function searchById()
    {
        echo "Search for id";
    }

    public function searchByPartner()
    {
        echo "Search for id";
    }

    //--------------------------------------------------------------------

    public function list() //Listado de ordenes de trabajo
    {
        if (!$this->session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $molds = $this->mold->findAll();
        $partners = $this->partner->findAll();
        for ($i = 0; count($molds) > $i; $i++) {
            $partnerData = $this->partner->where('id', $molds[$i]['partner_id'])->first();
            $molds[$i]['partner'] = trim($partnerData['name']);
        }
        
        $data = array(
            "view" => 'molds/list',
            "mold" => $molds,
            "partners" => $partners,
            "session" => $this->session
        );
        $dataHeader = array(
            "title" => 'Moldes de GAM'
        );
        $dataFooter = array();

        echo view('header_overlay', $dataHeader);
        echo view('overlay', $data);
        echo view('footer_overlay', $dataFooter);
    }
    public function view($mold_id)
    {

        if (!$this->session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $mold_data = $this->mold->where('id', $mold_id)->first(); //Mold data
        $partnerData = $this->partner->where('id', $mold_data['partner_id'])->find(); //Filter to get the partner data (name)
        $commentMold = $this->comment_mold->where('mold_id', $mold_data['id'])->find(); //Filter to get the comments related to that mold
        $orderData = $this->order->where('mold_id', $mold_data['id'])->find(); //Filter to get the orders data related to that mold
        $datashots = $this->shots->selectSum('shots')->where('mold_id', $mold_data['id'])->find(); //Filter to get the current temporal shots of a mold


        if (count($datashots) > 0 && is_null($datashots[0]['shots'])) {
            $shots = '0';
        } else {
            $shots = $datashots[0]['shots'];
        }
        for ($i = 0; $i < count($commentMold); $i++) {
            $user_data = $this->user->where('id', $commentMold[$i]['user'])->first();
            $commentMold[$i]['user'] = $user_data['username'];
        }

        $data = array(
            "view" => 'molds/view',
            "mold" => $mold_data,
            "partners" => $partnerData,
            "comments" => $commentMold,
            "orders" => $orderData,
            "session" => $this->session,
            "shots" => $shots
        );
        $dataHeader = array(
            "title" => $this->title . 'Molde "' . $mold_data['name'] . '" de GAM'
        );
        $dataFooter = array();


        echo view('header_overlay', $dataHeader);
        echo view('overlay', $data);
        echo view('footer_overlay', $dataFooter);
    }
    public function edit($mold_id)
    {
        echo "Mold to edit " . $mold_id;
    }

    public function addComment($mold_id)
    {
        $data = $this->request->getPostGet();
        $user = $this->session->email;
        $user_id = $this->user->where('email', $user)->first();
        $data = array(
            'mold_id' => $mold_id,
            'comment' => $data['comments'],
            'user' => $user_id['id']
        );
        $this->comment_mold->insert($data);
        $this->view($mold_id);
    }

    public function addShots($mold_id, $amount)
    {
        var_dump($mold_id);
        var_dump($amount);
        $data = array(
            'mold_id' => $mold_id,
            'shots' => $amount
        );
        $this->shots->insert($data);
    }

    public function resetShots($mold_id)
    {
        $this->shots->resetShotCounter($mold_id);
    }
}
