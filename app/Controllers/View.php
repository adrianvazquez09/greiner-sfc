<?php namespace App\Controllers;

class View extends BaseController
{
	public function index()
	{
		return view('view/index');
    }
    
    public function moldShop(){
        $dataMoldScreen = $this->ms->findAll();
        $dataMoldScreenHist = $this->msf->findAll();
        $data = array(
            'moldTable'=>$dataMoldScreen,
            'moldTableHist'=>$dataMoldScreenHist
        );
        // var_dump($data);
        echo view('view/header');
        echo view('view/moldshop',$data);
        echo view('view/footer');

    }

    public function molddetails(){
        $dataMoldScreen = $this->ms->findAll();
        $dataMoldScreenHist = $this->msh->findAll();

        $data = array(
            'moldTable'=>$dataMoldScreen,
            'moldTableHist'=>$dataMoldScreenHist
        );
        var_dump($data);
        echo view('view/header');
        echo view('view/details',$data);
        echo view('view/footer');


    }

	//--------------------------------------------------------------------

}
