<?php

namespace App\Controllers;

class Capture extends BaseController
{

	public function index()
	{
		if (!$this->session->logged_in) {
			return redirect()->to(base_url() . '/');
		}

		$StatusModel = new \App\Models\StatusModel();
		$statusData = $StatusModel->findAll();

		$data = array(
			"status" => $statusData,
			"view" => 'capture/index',
			"session" => $this->session
		);
		$dataHeader = array(
			"title" => 'Captura Trabajo Moldes'
		);
		$dataFooter = array();


		echo view('header_overlay', $dataHeader);
		echo view('overlay', $data);
		echo view('footer_overlay', $dataFooter);
	}

	public function insertData()
	{
		if (!$this->session->logged_in) {
			return redirect()->to(base_url() . '/');
		}
		//Obtenemos la información del post
		$data = $this->request->getPostGet();
		//Obtenemos el id del molde
		$mold = $this->mold->where('qr', $data['mold_qr'])->find();
		if(!count($mold)>0){
			$rcmdata = $this->rcm->where('qr',$data['mold_qr'])->find();
			$mold_id = $rcmdata[0]['data'];
		} else {
			$mold_id = $mold[0]['id'];
		}

		//Validar si existe una orden con el número de molde
		$order = $this->order->where('mold_id', $mold_id)->where('status', '1')->find();

		if (count($order) > 0) {
			//Obtiene el status actual con la lectura mas reciente de esa captura
			$lastcapture = $this->capture->where('order_id', $order[0]['id'])->orderBy('create_date', 'desc')->first();
			$currentstatus = $lastcapture['status_qr'];

			//Traer el siguiente estatus
			$thisstatus = $this->status->where('qr', $currentstatus)->first();
			if ($thisstatus['amount'] < 74) {

				$nextstatus = $this->status->where('id', $thisstatus['id'] + 1)->first();

				//Inserta el siguiente estatus en capture
				$data['status_qr'] = $nextstatus['qr'];
				$data['order_id'] = $lastcapture['order_id'];
				$data['type_work_qr'] = $lastcapture['type_work_qr'];
				$data['priority_qr'] = $lastcapture['priority_qr'];
				$this->capture->insert($data);
				$this->com->moldChangeStatus($order[0]['id'], $nextstatus['name']);
			} else {
				$nextstatus = $this->status->where('id', $thisstatus['id'] + 1)->first();
				// echo "se pone en 100 y termina el proceso";
				//Inserta el siguiente estatus en capture
				$data['status_qr'] = $nextstatus['qr'];
				$data['order_id'] = $lastcapture['order_id'];
				$data['type_work_qr'] = $lastcapture['type_work_qr'];
				$data['priority_qr'] = $lastcapture['priority_qr'];
				$this->com->moldChangeStatus($order[0]['id'], $nextstatus['name']);
				//Si ya es el ultimo estatus, hay que cerrar la orden
				$this->order->set('status', 3)->where('id', $order[0]['id'])->update();
				$this->com->closeOrder($order[0]['id']);
				$this->capture->insert($data);
				$this->capture->finishAnOrder($order[0]['id']);
			}
		} else {
			//Genera una nueva orden
			// echo "No hay";
			/**Datos que se necesitan apra la nueva orden
			 */
			$orderdata['service_type'] = 'Moldes';
			$orderdata['department_req'] = 'Produccion';
			$orderdata['name_req'] = 'Sistema SFC';
			$orderdata['date_req'] = date('y-m-d');
			$orderdata['hour_req'] = date('h:m');
			$orderdata['area_req'] = 'Produccion';
			$orderdata['shift_req'] = 'Sistema SFC'; //Sistema lo da de alta
			$orderdata['machine_no'] = 'Solo Molde (SFC)'; //Sistema lo da de alta
			$orderdata['mold_id'] = $mold_id;
			$orderdata['machine_type_id'] = "Inyeccion";
			$orderdata['symptom'] = 'Agregado por Sistema SFC';
			$orderdata['status'] = '1'; //Always start a new order in open status
			$orderdata['username'] = $this->session->email;

			$this->order->insert($orderdata);
			$lastid = $this->order->insertid();
			$this->com->openOrder($lastid);
			$data['order_id'] = $lastid;
			$status_data = $this->status->where('amount', '0')->first(); //Buscamos el estatus de arranque, cuando esta en 0%
			$data['status_qr'] = $status_data['qr'];
			// var_dump($data);
			$this->capture->insert($data);
		}

		//Si existe se actualiza el estatus del molde

		//Si no existe se genera la orden del molde

		//Insertamos la captura en capture



		//echo "<script>alert('Reporte guardado correctamente')</script>";
		//$this->index();
		return redirect()->to(base_url() . '/capture');
	}

	public function viewData()
	{
		$data = array(
			"moldData" => $this->mold->findAll(),
			"statusData" => $this->status->findAll(),
			"technicianData" => $this->tech->findAll(),
		);
	}


	//---------------------------VALIDATIONS-----------------------------------------


	public function moldValidation($mold_qr)
	{
		$data = $this->mold->where('qr', $mold_qr)->find();
		$machine = $this->machine->where('qr',$mold_qr)->find();

		if (count($data) > 0 || count($machine)>0) {
			return '1';
		} else {
			$rv = $this->rcm->where('qr', $mold_qr)->find();
			if (count($rv) > 0) {
				return '1';
			} else {
				$dept = $this->department->where('qr',$mold_qr)->find();
				if (count($dept)> 0) {
					return '2';
				} else {
					return '0';
				}
			}
		}
	}

	
	public function moldValidationOwner($mold_qr)
	{
		$data_mold = $this->mold->where('qr', $mold_qr)->first();
		$data_machine = $this->machine->where('qr',$mold_qr)->first();
		$data = $this->order->where('mold_id',$data_mold['id'])->where('status',1)->find();
		$machine = $this->order->where('machine_no',$data_machine['id'])->where('status',1)->find();

		if (count($data) > 0 || count($machine)>0) {
			return '1';
		} else {
			$rv = $this->rcm->where('qr', $mold_qr)->find();
			if (count($rv) > 0) {
				return '1';
			} else {
				$dept = $this->department->where('qr',$mold_qr)->find();
				if (count($dept)> 0) {
					return '2';
				} else {
					return '0';
				}
			}
		}
	}

	public function technicianValidation($mold_qr, $tech_qr)
	{
		$data = $this->tech->where('qr', $tech_qr)->find();
		$moldData = $this->mold->where('qr', $mold_qr)->find();
		if(!count($moldData)>0){
			$moldData = $this->rcm->where('qr',$mold_qr)->find();
			$orderData = $this->order->where('mold_id',$moldData[0]['data'])->where('status',1)->find();
		} else{
		$orderData = $this->order->where('mold_id', $moldData[0]['id'])->where('status', 1)->find();
		}

		if ($orderData != NULL) {
			$captureData = $this->capture->where('order_id', $orderData[0]['id'])->orderby('create_date','asc')->find();
		}

		if (count($data) > 0) { //Existe ese qr
			if (isset($captureData)) { //Existe una orden
				if ($captureData[0]['technician_qr'] == $tech_qr) {
					return '1'; //all good
				} else {
					return '2'; //Wrong technician qr not related to the order
				}
			} else {
				return '1';
			}
		} else {
			return '0'; //No qr found in technician
		}
	}

	public function typeWorkValidation($type_work_qr)
	{
		$data = $this->type_work->where('qr', $type_work_qr)->find();

		if (count($data) > 0) {
			return '1';
		} else {
			return '0';
		}
	}

	public function priorityValidation($priority_qr)
	{
		$data = $this->priority->where('qr', $priority_qr)->find();

		if (count($data) > 0) {
			return '1';
		} else {
			return '0';
		}
	}

	public function hasActiveOrder($mold_qr)
	{
		$mold_data = $this->mold->where('qr', $mold_qr)->first();
		$order = $this->order->where('mold_id', $mold_data['id'])->where('status', 1)->find();
		if (count($order) > 0) {
			return $order[0]['id'];
		} else return '0';
	}

	public function changeResponsible()
	{
		if (!$this->session->logged_in) {
			return redirect()->to(base_url() . '/');
		}

		$statusData = $this->status->findAll();

		$data = array(
			"status" => $statusData,
			"view" => 'capture/responsible',
			"session" => $this->session
		);
		$dataHeader = array(
			"title" => 'Cambio de responsable'
		);
		$dataFooter = array();


		echo view('header_overlay', $dataHeader);
		echo view('overlay', $data);
		echo view('footer_overlay', $dataFooter);
	}

	public function changeOwner(){
		if (!$this->session->logged_in) {
			return redirect()->to(base_url() . '/');
		}
		//Obtenemos la información del post
		$data = $this->request->getPostGet();
		
		//Buscar orden de trabajo activo
		$mold_data = $this->mold->where('qr',$data['mold_qr'])->first();
		$machine_data = $this->machine->where('qr',$data['mold_qr'])->first();

		if($mold_data){
			$data_ot = $this->order->where('mold_id',$mold_data['id'])->where('status',1)->orderBy('date_added','desc')->first();
		} else {
			$data_ot = $this->order->where('machine_no',$machine_data['id'])->where('status',1)->orderBy('date_added','desc')->first();
		}	
		//Cambia los datos de la ultima captura
		$capture_data = $this->capture->where('order_id',$data_ot['id'])->orderBy('create_date','desc')->first();
		$this->capture->set('technician_qr', $data['technician_qr'])->where('id',$capture_data['id'])->update();

		$tech_data = $this->tech->where('qr',$data['technician_qr'])->first();
		//Introduce comentario a la orden
		if($tech_data){
			$fullname = $tech_data['firstname']." ".$tech_data['lastname'];
		} else {
			$fullname = ' ';
		}
		$user_data = $this->user->where('username',$this->session->username)->first();;
		$this->comment->moldChangeOwner($data_ot['id'],$fullname,$data['comments'], $user_data['username']);

		//Regresar al formato original
		$this->changeResponsible();
		
	}

	public function validateTechnician($tech_qr){
		if (!$this->session->logged_in) {
			return redirect()->to(base_url() . '/');
		}
		$tech_data = $this->tech->where('qr',$tech_qr)->find();

		if(count($tech_data)>0){
			return '1';
		} else {return '0';}
	}

}
