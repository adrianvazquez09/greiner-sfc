<?php namespace App\Controllers;


class Operations extends BaseController
{
	public function index()
	{
		if (!$this->session->logged_in) {
			return redirect()->to(base_url() . '/');
		}
        echo "Operations";
	}


    public function randAssign(){
        if (!$this->session->logged_in) {
			return redirect()->to(base_url() . '/');
            
		}
        $molds = $this->mold->findAll();

        $data = array(
			"view" => 'ops/qrAssign',
			"session" => $this->session,
            'molds'=>$molds
		);
		$dataHeader = array(
			"title" => 'Asignación de codigos'
		);
		$dataFooter = array();


		echo view('header_overlay', $dataHeader);
		echo view('overlay', $data);
		echo view('footer_overlay', $dataFooter);
    }

    public function assignQR(){
        if (!$this->session->logged_in) {
			return redirect()->to(base_url() . '/');
		}
		//Obtenemos la información del post
		$data = $this->request->getPostGet();
        $info = array(
            'used_type' => 'mold',
            'data'=> $data['mold_id']
        );
        $this->rcm->set('data',$info['data'])->set('used_type',$info['used_type'])->where('qr',$data['mold_qr'])->update();
    }

    public function thirdParty(){
        if (!$this->session->logged_in) {
			return redirect()->to(base_url() . '/');
            
		}
        $molds = $this->mold->findAll();

        $data = array(
			"view" => 'ops/thirdParty',
			"session" => $this->session,
            'molds'=>$molds
		);
		$dataHeader = array(
			"title" => 'Salida a terceros'
		);
		$dataFooter = array();


		echo view('header_overlay', $dataHeader);
		echo view('overlay', $data);
		echo view('footer_overlay', $dataFooter);
    }


	//--------------------------------------------------------------------


    public function moldValidation($mold_qr){
        $mold = $this->rcm->find('qr',$mold_qr)->find();

        if(count($mold)>0){
            if($mold[0]['data']==NULL){
                return '1'; //Mold ok
            } else {
                return '2'; //Mold already used
            }
        }else {
            return '0'; //Mold not found
        }
        
        
        
    }
}
