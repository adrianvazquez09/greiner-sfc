<?php

namespace App\Controllers;

class Machine extends BaseController
{

    public function index()
    {
        if (!$this->session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $data = array(
            "status" => $this->status->findAll(),
            "view" => 'captureMachine/index',
            "session" => $this->session
        );
        $dataHeader = array(
            "title" => 'Captura Trabajo Máquinas'
        );
        $dataFooter = array();

        echo view('header_overlay', $dataHeader);
        echo view('overlay', $data);
        echo view('footer_overlay', $dataFooter);
    }

    public function view(){
        if (!$this->session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $machines = $this->machine->findAll();
        $data = array(
            "status" => $this->status->findAll(),
            "view" => 'captureMachine/view',
            "machines" => $machines,
            "session" => $this->session
        );
        $dataHeader = array(
            "title" => $this->title.'Listado de Máquinas'
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
		$machine = $this->machine->where('qr', $data['machine_qr'])->find();
		if(!count($machine)>0){
			$rcmdata = $this->rcm->where('qr',$data['machine_qr'])->find();
			$machine_id = $rcmdata[0]['data'];
		} else {
			$machine_id = $machine[0]['id'];
		}

		//Validar si existe una orden con el número de maquina
		$order = $this->order->where('machine_no', $machine_id)->where('status', '1')->find();

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
				$this->com->machineChangeStatus($order[0]['id'], $nextstatus['name']);
			} else {
				$nextstatus = $this->status->where('id', $thisstatus['id'] + 1)->first();
				// echo "se pone en 100 y termina el proceso";
				//Inserta el siguiente estatus en capture
				$data['status_qr'] = $nextstatus['qr'];
				$data['order_id'] = $lastcapture['order_id'];
				$data['type_work_qr'] = $lastcapture['type_work_qr'];
				$data['priority_qr'] = $lastcapture['priority_qr'];
				$this->com->machineChangeStatus($order[0]['id'], $nextstatus['name']);
				//Si ya es el ultimo estatus, hay que cerrar la orden
				$this->order->set('status', 3)->where('id', $order[0]['id'])->update();
				$this->com->closeOrder($order[0]['id']);
				$this->capture->insert($data);
				$this->capture->finishAnOrder($order[0]['id']);
			}
		} else {
			//Genera una nueva orden
			/**Datos que se necesitan apra la nueva orden
			 */
			$orderdata['service_type'] = 'Mantenimiento';
			$orderdata['department_req'] = 'Produccion';
			$orderdata['name_req'] = 'Sistema MTTO SFC';
			$orderdata['date_req'] = date('y-m-d');
			$orderdata['hour_req'] = date('h:m');
			$orderdata['area_req'] = 'Produccion';
			$orderdata['shift_req'] = 'Sistema SFC'; //Sistema lo da de alta
			$orderdata['machine_no'] = $machine[0]['id']; //Sistema lo da de alta
			$orderdata['mold_id'] = "0";
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
		return redirect()->to(base_url() . '/machine');
	}

    public function machineValidation($machine_qr)
    {
        $data = $this->machine->where('qr', $machine_qr)->find();
        if (count($data) > 0) {
            return '1';
        } else {
            return '0';
        }
    }

	public function hasActiveOrder($machine_qr)
	{
		$machine_data = $this->machine->where('qr', $machine_qr)->first();
		$order = $this->order->where('machine_no', $machine_data['id'])->where('status', 1)->find();
		if (count($order) > 0) {
			return $order[0]['id'];
		} else return '0';
	}

    public function technicianValidation($machine_qr, $tech_qr)
	{
		$data = $this->tech->where('qr', $tech_qr)->find();
		$machineData = $this->machine->where('qr', $machine_qr)->find();
		if(!count($machineData)>0){
			$machineData = $this->rcm->where('qr',$machine_qr)->find();
			$orderData = $this->order->where('mold_id',$machineData[0]['data'])->where('status',1)->find();
		} else{
		$orderData = $this->order->where('mold_id', $machineData[0]['id'])->where('status', 1)->find();
		}

		if ($orderData != NULL) {
			$captureData = $this->capture->where('order_id', $orderData[0]['id'])->find();
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

}
