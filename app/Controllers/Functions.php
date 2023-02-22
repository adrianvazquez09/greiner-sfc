<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Functions extends BaseController
{

    public function index()
    {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    //-------------------------------------------------------------------- Operaciones Adrian

    public function oneMinuteCron()
    {
        $this->calculateScreenWO();
        $this->calculateScreenWOF();
    }
    public function fiveMinuteCron()
    {
    }
    public function thirtyMinuteCron()
    {
    }
    public function sixtyMinuteCron()
    {
    }
    public function dailyMinuteCron()
    {
    }
    public function WeeklyMinuteCron()
    {
    }
    public function monthlyMinuteCron()
    {
    }

    public function calculationsMoldScreen() //Logic without order
    {
        $result = array(); //I will introduce everything into this variable
        echo "Starting to calculate the data ...<br>";

        //Get current captured data that is different to finished
        echo "Getting the current captured data.... <br>";
        $dataCapture = $this->capture->where('finished', null)->findAll();
        echo "Data obtained...<br>";
        // var_dump($dataCapture);

        for ($i = 0; $i < count($dataCapture); $i++) {
            //#
            $result[$i]['id'] = $i + 1;
            //Priority
            $result[$i]['priority'] = $this->getPriorityFromQR($dataCapture[$i]['priority_qr']);
            //Mold

            $result[$i]['mold'] = $this->getMoldFromQR($dataCapture[$i]['mold_qr']);

            //Type of Work
            $result[$i]['work_type'] = $this->getWorkTypeFromQR($dataCapture[$i]['type_work_qr']);
            //Responsable
            $result[$i]['responsable'] = $this->getTechnicianFromQR($dataCapture[$i]['technician_qr']);
            //Entry Date -- La fecha de la recepción del primer estatus
            $result[$i]['entry_date'] = $this->getDeliveryDate($dataCapture[$i]['create_date'], 1);
            //Expected Delivery Date -- Logica dependiendo del tiempo que llego y la cantidad segun la prioridad
            $result[$i]['delivery_date'] = '';
            //Comments
            $result[$i]['comments'] = $dataCapture[$i]['comments'];
            //Status
            $result[$i]['status'] = '';
            //Progress -- Logica dependiendo del tiempo que lleve desde el arranque
            $result[$i]['progress'] = $this->calculateProgress($dataCapture[$i]['status_qr'], $result[$i]['priority'], $result[$i]['delivery_date']);;
        }

        //Store the data in the required database
        var_dump($result);
        //END

        echo "<br><br><br> fin";
    }

    public function getPriorityFromQR($qr)
    {
        $priority_id = $this->priority->where('qr', $qr)->first();
        return $priority_id['name'];
    }

    public function getWorkTypeFromQR($qr)
    {
        $wt_id = $this->type_work->where('qr', $qr)->first();
        return $wt_id['name'];
    }

    public function getTechnicianfromQR($qr)
    {
        $tech_id = $this->tech->where('qr', $qr)->first();
        $full_name = $tech_id['firstname'] . " " . $tech_id['lastname'];
        return $full_name;
    }
    public function getMoldFromQR($qr)
    {
        $mold_data_final = '';
        $mold_data = $this->mold->where('qr', $qr)->find();
        if (count($mold_data) > 0) {
            $mold_data_final = $mold_data[0];
        } else {
            $mold_id = $this->rcm->where('qr', $qr)->find();
            $mold_data_new = $this->mold->where('id', $mold_id[0]['data'])->find();
            $mold_data_final = $mold_data_new[0];
        }
        $partner_data = $this->partner->where('id', $mold_data_final['partner_id'])->find();
        $partner_name = $partner_data[0]['name'];
        return trim($mold_data_final['name'] . ' ' . $mold_data_final['description'] . ' ' . $partner_name);
    }

    public function getMachineFromQR($qr)
    {
        $machine_data_final = '';
        $machine_data = $this->machine->where('qr', $qr)->find();
        if (count($machine_data) > 0) {
            $machine_data_final = $machine_data[0];
        } else {
            $machine_id = $this->rcm->where('qr', $qr)->find();
            $machine_data_new = $this->machine->where('id', $machine_id[0]['data'])->find();
            $machine_data_final = $machine_data_new[0];
        }
        return trim($machine_data_final['name'] . ' ' . $machine_data_final['description']);
    }
    public function getStatusFromQR($qr)
    {
        $status_data = $this->status->where('qr', $qr)->find();

        return $status_data[0]['name'];
    }

    public function getDeliveryDate($entry_date, $priority_qr)
    {
        if ($entry_date == '') {
            return '';
        }
        //It´s calculated depending of the entry date + the priority time
        $priority_data = $this->priority->where('qr', $priority_qr)->find();
        $str_data = '+' . $priority_data[0]['hours'] . ' hours';
        $new_time = date('Y-m-d H:i:s', strtotime($entry_date . $str_data));

        return $new_time;
    }

    public function getProgress($order_id)
    {
        //Obtener prioridad
        $ultimaCaptura = $this->capture->where('order_id', $order_id)->orderby('create_date', 'desc')->first();
        $prioridad = $this->priority->where('qr', $ultimaCaptura['priority_qr'])->first();
        //obtener cuantas horan han pasado desde que se dio de alta
        $orderData = $this->order->where('id', $order_id)->first();
        $dateone = date('Y-m-d H:i:s'); //NOW
        $datetwo = date('Y-m-d H:i:s', strtotime($orderData['date_added'])); //The date that was created the order
        $horasPasadas = (strtotime($dateone) - strtotime($datetwo)) / 60 / 60;
        //Dividir las horas que han pasado 
        $avgtime = (($horasPasadas * 100) / $prioridad['hours']); //-3 para darle un poco de margen al calculo del % que deberian de llevar

        // var_dump($avgtime);echo "<br>";
        // var_dump($dateone);echo "<br>";
        // var_dump($datetwo);echo "<br>";
        // var_dump($horasPasadas);

        //Si la division es mayor que 100, rojo directo
        if ($avgtime > 100) {
            $progress = $this->progress->where('id', 3)->first();
            return $progress['name'];
        }
        //Si la division es menor que el % actual, pero abajo de 100, es amarillo
        $avgactual = $this->status->where('qr', $ultimaCaptura['status_qr'])->first();
        if ($avgtime > $avgactual['amount']) {
            $progress = $this->progress->where('id', 2)->first();
            return $progress['name'];
        }
        //Si la division es mayor que el %, verde
        if ($avgtime < $avgactual['amount']) {
            $progress = $this->progress->where('id', 1)->first();
            return $progress['name'];
        }
    }

    public function calculateProgress($status, $priority, $delivery_date)
    {
        //It´s calculated depending of the remaining time of the delivery date vs the status %
        if ($status == '' || $priority == '' || $delivery_date == '') {
            return '';
        }
        $progress_data = $this->progress->findall();
        $status_data = $this->status->where('qr', $status)->find();

        $priority_data = $this->priority->where('name', $priority)->find();


        //Cuanto debe durar
        $totalhours = $priority_data[0]['hours'];
        echo "Total horas de etapas vale " . $totalhours . "<br>";
        //Cuanto dura cada etapa
        $totalhours_each = $totalhours / 4;
        echo "Cada etapa dura " . $totalhours_each . "<br>";
        //Cual etapa va
        $current_each = $status_data[0]['id'] - 1;
        echo "La etapa actual es la " . $current_each . "<br>";
        //Faltan
        echo date('YdmHis') . "<br>";

        $delivery_date = str_replace(" ", "", $delivery_date);
        $delivery_date = str_replace("-", "", $delivery_date);
        $delivery_date = str_replace(":", "", $delivery_date);
        echo $delivery_date - date('YdmHis') . "<br>";

        //Cual es el tiempo actual en etapa vs la etapa que va

    }

    public function logicQR($type = "mold", $op = 'gen', $id = '0')
    { //Type se enfoca en mandar a segun lo que se generara, ID se enfoca en un numero de identificacion especifico OP se enfoca en si generara (gen) la imagen con el qr o si solo almacenara el qr(md5)

        //Logica de generación de QRs moldes
        if ($type == 'mold') {
            $resultado = '';
            $dataMold = $this->mold->findall(); //Información de todos los moldes

            for ($i = 0; $i < count($dataMold); $i++) {
                $resultado_name = $dataMold[$i]['id'] . "-" . $dataMold[$i]['name']." - ".$dataMold[$i]['partner_id'];  //Genero el string con el que se formara el md5
                $resultado = $dataMold[$i]['id'] . "-" . $dataMold[$i]['name'];  //Genero el string con el que se formara el md5
                //Genero MD5
                $datomd5 = md5($resultado);
                echo $resultado . " - " . $datomd5 . "<br>";
                if ($op == 'gen') {
                    //Mando ese md5 a la base de datos
                    //$this->mold->set(['qr' => $datomd5])->where('id', $dataMold[$i]['id'])->update();
                }
                if ($op == 'print') {
                    //Mando ese MD5 a que se genere el qr //Descomentar el codigo para habilitar la funcionalidad de abrir en otra ventana
                    echo "<script>";
                    $url = "http://localhost/moldsfc/qr/code.php?level=h&size=6&data=" . urlencode($datomd5) . "&name=" . urlencode($resultado_name);
                    echo "window.open('$url');" . PHP_EOL;
                    echo "</script>";
                }
            }
        }
        //Logica de generación de QR usuarios
        if ($type == 'tech') {
            $datatech = $this->tech->findall();
            for ($i = 0; $i < count($datatech); $i++) {
                $qrtext = $datatech[$i]['employee_no'] . "-" . $datatech[$i]['firstname'] . $datatech[$i]['lastname'];
                $datomd5 = md5($qrtext);
                echo $qrtext . "-" . $datomd5 . "<br>";

                if ($op == 'gen') {
                    $this->mold->set(['qr' => $datomd5])->where('id', $dataMold[$i]['id'])->update();
                }
                if ($op == 'print') {
                    //Mando ese MD5 a que se genere el qr //Descomentar el codigo para habilitar la funcionalidad de abrir en otra ventana
                    echo "<script>";
                    $url = "http://localhost/moldsfc/qr/code.php?level=h&size=6&data=" . urlencode($datomd5) . "&name=" . urlencode($qrtext);
                    echo "window.open('$url');" . PHP_EOL;
                    echo "</script>";
                }
            }
        }
        //Logica de generación de QR prioridad
        if ($type == 'priority') {
            $datapriority = $this->priority->findall();
            for ($i = 0; $i < count($datapriority); $i++) {
                $qrtext = $datapriority[$i]['id'] . "-" . $datapriority[$i]['name'];
                $datomd5 = md5($qrtext);
                if ($op == 'gen') {
                    $this->priority->set(['qr' => $datomd5])->where('id', $datapriority[$i]['id'])->update();
                }
                if ($op == 'print') {
                    //Mando ese MD5 a que se genere el qr //Descomentar el codigo para habilitar la funcionalidad de abrir en otra ventana
                    echo "<script>";
                    $url = "http://localhost/moldsfc/qr/code.php?level=h&size=6&data=" . urlencode($datomd5) . "&name=" . urlencode($qrtext);
                    echo "window.open('$url');" . PHP_EOL;
                    echo "</script>";
                }
            }
        }
        //Logica de generación de QR status
        if ($type == 'status') {
            $datastatus = $this->status->findall();
            for ($i = 0; $i < count($datastatus); $i++) {
                $qrtext = $datastatus[$i]['id'] . "-" . $datastatus[$i]['name'];
                $datomd5 = md5($qrtext);
                if ($op == 'gen') {
                    $this->status->set(['qr' => $datomd5])->where('id', $datastatus[$i]['id'])->update();
                }
                if ($op == 'print') {
                    //Mando ese MD5 a que se genere el qr //Descomentar el codigo para habilitar la funcionalidad de abrir en otra ventana
                    echo "<script>";
                    $url = "http://localhost/moldsfc/qr/code.php?level=h&size=6&data=" . urlencode($datomd5) . "&name=" . urlencode($qrtext);
                    echo "window.open('$url');" . PHP_EOL;
                    echo "</script>";
                }
            }
        }
        if ($type == 'worktype') {
            $datawt = $this->type_work->findall();

            for ($i = 0; $i < count($datawt); $i++) {
                $qrtext = $datawt[$i]['id'] . "-" . $datawt[$i]['name'];
                $datomd5 = md5($qrtext);
                if ($op == 'gen') {
                    $this->type_work->set(['qr' => $datomd5])->where('id', $datawt[$i]['id'])->update();
                }
                if ($op == 'print') {
                    //Mando ese MD5 a que se genere el qr //Descomentar el codigo para habilitar la funcionalidad de abrir en otra ventana
                    echo "<script>";
                    $url = "http://localhost/moldsfc/qr/code.php?level=h&size=6&data=" . urlencode($datomd5) . "&name=" . urlencode($qrtext);
                    echo "window.open('$url');" . PHP_EOL;
                    echo "</script>";
                }
            }
        }

        if ($type == 'machine') {
            $datamac = $this->machine->findAll();
            for ($i = 0; $i < count($datamac); $i++) {
                $qrtext = $datamac[$i]['id'] . "-" . $datamac[$i]['name'];
                $datomd5 = md5($qrtext);
                if ($op == 'gen') {
                    var_dump($datomd5);
                    $this->machine->set(['qr' => $datomd5])->where('id', $datamac[$i]['id'])->update();
                }
                if ($op == 'print') {
                    //Mando ese MD5 a que se genere el qr //Descomentar el codigo para habilitar la funcionalidad de abrir en otra ventana
                    echo "<script>";
                    $url = "http://localhost/moldsfc/qr/code.php?level=h&size=6&data=" . urlencode($datomd5) . "&name=" . urlencode($qrtext);
                    echo "window.open('$url');" . PHP_EOL;
                    echo "</script>";
                }
            }
        }
        if ($type == 'random') {
            $limit = '10';

            for ($i = 0; $i < $limit; $i++) {
                $qrtext = $i . "-" . rand() . "-" . rand() . "-" . rand();
                $datomd5 = md5($qrtext);
                $data = array(
                    'qr' => $datomd5,
                    'qr_text' => $qrtext,
                );
                if ($op == 'gen') {
                    $this->rcm->insert($data);
                }
                if ($op == 'print') {
                    //Mando ese MD5 a que se genere el qr //Descomentar el codigo para habilitar la funcionalidad de abrir en otra ventana
                    $info = $this->rcm->where('printed', 0)->findAll();

                    for ($i = 0; $i < count($info); $i++) {
                        $this->rcm->set('printed', '1')->where('id', $info[$i]['id'])->update();

                        echo "<script>";
                        $url = "http://localhost/moldsfc/qr/code.php?level=h&size=6&data=" . urlencode($info[$i]['qr']) . "&name=" . urlencode($info[$i]['qr_text']);
                        echo "window.open('$url');" . PHP_EOL;
                        echo "</script>";
                    }
                    echo "Finish";
                    die();
                }
            }
        }
    }

    public function calculateScreenWO() //Mold Screen
    {
        echo "Start WO <br>";
        $this->ms->truncate();
        $ordenes = $this->order->where('status', 1)->where('service_type','moldes')->findAll(); //Ordenes de moldes
        $screenData = array();
        if (count($ordenes) > 0) {
            for ($i = 0; $i < count($ordenes); $i++) {
                $comments    = $this->comment->where('order_id', $ordenes[$i]['id'])->orderBy('id', 'desc')->first();
                $lastCapture = $this->capture->where('order_id', $ordenes[$i]['id'])->orderby('id', 'desc')->first();
                //ID
                $screenData[$i]["id"] = $ordenes[$i]['id'];
                //Prioridad
                $screenData[$i]['priority'] = $this->getPriorityFromQR($lastCapture['priority_qr']);
                //Mold
                $screenData[$i]['mold'] = $this->getMoldFromQR($lastCapture['mold_qr']);
                //Work Type
                $screenData[$i]['work_type'] = $this->getWorkTypeFromQR($lastCapture['type_work_qr']);
                //Responsable
                $screenData[$i]['responsable'] = $this->getTechnicianfromQR($lastCapture['technician_qr']);
                //Entry Date
                $screenData[$i]['entry_date'] = $ordenes[$i]['date_added'];
                //Delivery Date
                $screenData[$i]['delivery_date'] = $this->getDeliveryDate($ordenes[$i]['date_added'], $lastCapture['priority_qr']);
                //Comments
                $screenData[$i]['comments'] = $comments['comment'];
                //status
                $screenData[$i]['status'] = $this->getStatusFromQR($lastCapture['status_qr']);
                //progress
                $screenData[$i]['progress'] = $this->getProgress($ordenes[$i]['id']);

                $this->ms->insert($screenData[$i]);
            }
        }
        echo "Finished WO <br>";
        $this->calculateScreenMtto();
    }

    public function calculateScreenWOF() //Mold Screen Finished
    {
        echo "Start WOF <br>";
        $screenData = array();
        $datos = '';
        $this->msf->truncate();
        $status = $this->status->where('amount', 100)->first();
        $captures = $this->capture->where('status_qr', $status['qr'])->where('finished', 1)->where('machine_qr',NULL)->where('create_date >', Time::yesterday())->findAll();
        if (count($captures) > 0) {
            for ($i = 0; $i < count($captures); $i++) {
                $datos .= $captures[$i]['id'] . ",";
            }

            $datos = substr($datos, 0, -1);
            $datos_ar = explode(',', $datos);

            if (count($datos_ar) > 0) {
                echo "entro";
                for ($i = 0; $i < count($datos_ar); $i++) {
                    $order_id = $this->capture->where('id', $datos_ar[$i])->first();
                    $orden = $this->order->where('id', $order_id['order_id'])->first();
                    $comments    = $this->comment->where('order_id', $orden['id'])->orderBy('id', 'desc')->first();
                    $lastCapture = $this->capture->where('order_id', $orden['id'])->orderby('id', 'desc')->first();
                    //ID
                    $screenData[$i]["id"] = $orden['id'];
                    //Prioridad
                    $screenData[$i]['priority'] = $this->getPriorityFromQR($lastCapture['priority_qr']);
                    //Mold
                    $screenData[$i]['mold'] = $this->getMoldFromQR($lastCapture['mold_qr']);
                    //Work Type
                    $screenData[$i]['work_type'] = $this->getWorkTypeFromQR($lastCapture['type_work_qr']);
                    //Responsable
                    $screenData[$i]['responsable'] = $this->getTechnicianfromQR($lastCapture['technician_qr']);
                    //Entry Date
                    $screenData[$i]['entry_date'] = $lastCapture['create_date'];
                    //Delivery Date
                    $screenData[$i]['delivery_date'] = $this->getDeliveryDate($orden['date_added'], $lastCapture['priority_qr']);
                    //Comments
                    $screenData[$i]['comments'] = '';
                    //status
                    $screenData[$i]['status'] = $this->getStatusFromQR($lastCapture['status_qr']);
                    //progress
                    $screenData[$i]['progress'] = 'DONE';

                    
                    $this->msf->insert($screenData[$i]);
                }
            }
        }
        
        echo "Finished WOF <br>";
        $this->calculateScreenWOFMTTO();
    }

    public function totalOrders()
    {
    }

    public function email()
    {
        echo "hi";
        $email = \Config\Services::email();

        $email->setFrom('your@example.com', 'Your Name');
        $email->setTo('a.vazquez@greiner-assistec.com');
        $email->setBCC('hackbro@gmail.com');

        $email->setSubject('Email Test');
        $email->setMessage('Testing the email class.');

        $email->send();
    }
    public function calculateScreenMtto() //Mold Screen
    {
        echo "Start WO MTTO <br>";
        $ordenes = $this->order->where('status', 1)->where('service_type','mantenimiento')->findAll(); //Ordenes de mantenimiento
        $screenData = array();
        if (count($ordenes) > 0) {
            for ($i = 0; $i < count($ordenes); $i++) {
                $comments    = $this->comment->where('order_id', $ordenes[$i]['id'])->orderBy('id', 'desc')->first();
                $lastCapture = $this->capture->where('order_id', $ordenes[$i]['id'])->orderby('id', 'desc')->first();
                //ID
                $screenData[$i]["id"] = $ordenes[$i]['id'];
                //Prioridad
                $screenData[$i]['priority'] = $this->getPriorityFromQR($lastCapture['priority_qr']);
                //Mold
                $screenData[$i]['mold'] = $this->getMachineFromQR($lastCapture['machine_qr']);
                //Work Type
                $screenData[$i]['work_type'] = $this->getWorkTypeFromQR($lastCapture['type_work_qr']);
                //Responsable
                $screenData[$i]['responsable'] = $this->getTechnicianfromQR($lastCapture['technician_qr']);
                //Entry Date
                $screenData[$i]['entry_date'] = $ordenes[$i]['date_added'];
                //Delivery Date
                $screenData[$i]['delivery_date'] = $this->getDeliveryDate($ordenes[$i]['date_added'], $lastCapture['priority_qr']);
                //Comments
                $screenData[$i]['comments'] = $comments['comment'];
                //status
                $screenData[$i]['status'] = $this->getStatusFromQR($lastCapture['status_qr']);
                //progress
                $screenData[$i]['progress'] = $this->getProgress($ordenes[$i]['id']);

                $this->ms->insert($screenData[$i]);
            }
        }
        echo "Finished WO MTTO <br>";
    }

    public function calculateScreenWOFMTTO() //Mold Screen Finished
    {
        echo "Start WOF MTTO<br>";
        $screenData = array();
        $datos = '';
        $status = $this->status->where('amount', 100)->first();
        $captures = $this->capture->where('status_qr', $status['qr'])->where('finished', 1)->where('mold_qr',NULL)->where('create_date >', Time::yesterday())->findAll();
        if (count($captures) > 0) {
            for ($i = 0; $i < count($captures); $i++) {
                $datos .= $captures[$i]['id'] . ",";
            }

            $datos = substr($datos, 0, -1);
            $datos_ar = explode(',', $datos);
            if (count($datos_ar) > 0) {
                for ($i = 0; $i < count($datos_ar); $i++) {
                    $order_id = $this->capture->where('id', $datos_ar[$i])->first();
                    $orden = $this->order->where('id', $order_id['order_id'])->first();
                    $comments    = $this->comment->where('order_id', $orden['id'])->orderBy('id', 'desc')->first();
                    $lastCapture = $this->capture->where('order_id', $orden['id'])->orderby('id', 'desc')->first();
                    //ID
                    $screenData[$i]["id"] = $orden['id'];
                    //Prioridad
                    $screenData[$i]['priority'] = $this->getPriorityFromQR($lastCapture['priority_qr']);
                    //Mold
                    $screenData[$i]['mold'] = $this->getMachineFromQR($lastCapture['machine_qr']);
                    //Work Type
                    $screenData[$i]['work_type'] = $this->getWorkTypeFromQR($lastCapture['type_work_qr']);
                    //Responsable
                    $screenData[$i]['responsable'] = $this->getTechnicianfromQR($lastCapture['technician_qr']);
                    //Entry Date
                    $screenData[$i]['entry_date'] = $lastCapture['create_date'];
                    //Delivery Date
                    $screenData[$i]['delivery_date'] = $this->getDeliveryDate($orden['date_added'], $lastCapture['priority_qr']);
                    //Comments
                    $screenData[$i]['comments'] = '';
                    //status
                    $screenData[$i]['status'] = $this->getStatusFromQR($lastCapture['status_qr']);
                    //progress
                    $screenData[$i]['progress'] = 'DONE';

                    $this->msf->insert($screenData[$i]);
                }
            }
        }
        
        echo "Finished WOF MTTO<br>";
    }
}
