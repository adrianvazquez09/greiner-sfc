<?php

namespace App\Controllers;

use TCPDF;

class Order extends BaseController
{
    public function index() //Listado de ordenes de trabajo
    {
        if (!$this->session->logged_in) {
            return redirect()->to(base_url() . '/');
        }
        $orders = $this->order->orderby('id', 'desc')->findAll();

        for ($i = 0; $i < count($orders); $i++) {
            $status = $this->ot_status->where('id', $orders[$i]['status'])->first();
            $orders[$i]['status'] = $status['name'];
        }

        for ($i = 0; $i < count($orders); $i++) {
            if ($orders[$i]['machine_no'] != 'Solo Molde (SFC)') {
                $machine = $this->machine->where('id', $orders[$i]['machine_no'])->first();
                $orders[$i]['machine_no'] = $machine['name'];
            }
        }


        $data = array(
            "view" => 'order/index',
            "orders" => $orders,
            "session" => $this->session
        );
        $dataHeader = array(
            "title" => 'Ordenes de Servicio'
        );
        $dataFooter = array();


        echo view('header_overlay', $dataHeader);
        echo view('overlay', $data);
        echo view('footer_overlay', $dataFooter);
    }

    //--------------------------------------------------------------------

    /***
     * Genera ordenes de trabajo con los siguientes campos:
     * 
     * <Datos del solicitante>
     * Tipo de servicio (Checkbox)
     * Departamento solicitante (Select)
     * Nombre (Text field)
     * Fecha
     * Hora
     * Area (Me lo ahorro si ya tengo registrado al usuario)
     * Turno (Me lo ahorro si ya tengo registrado al usuario)
     * 
     * No. Maquina (Number field)
     * No. Molde (Text field)
     * Tipo de maquina 
     * Sintoma/Problema/Servicio
     * 
     * 
     * <Departamento de servicio>
     * Fecha aviso (Generada automaticamente al generar el reporte)
     * Hora aviso (Generada automaticamente al generar el reporte)
     * 
     * Fecha inicio (Date field)
     * Hora Inicio (Text Field)
     * Fecha Finalización (Date Field)
     * Hora Finalización (Text field)
     * 
     * Condiciones en que se recibe: (Text Area)
     * 
     * <Firma de conformidad> 
     * Firma Solicitante
     * Firma Responsable
     * 
     * 
     * <Entrega del molde>
     * Caras del molde limpias y sin contaminación o exceso de grasa: Limpieza general adecuada, Observaciones.
     * 
     * 
     * Create date  (Timestamp)
     * Date de la firma
     */
    public function new()
    { //Agregar nueva orden de trabajo

        if (!$this->session->logged_in) {
            return redirect()->to(base_url() . '/');
        }

        $data = array(
            "view" => 'order/new',
            "session" => $this->session
        );
        $dataHeader = array(
            "title" => 'Requisición de Servicio'
        );
        $dataFooter = array();


        echo view('header_overlay', $dataHeader);
        echo view('overlay', $data);
        echo view('footer_overlay', $dataFooter);
    }

    public function addOrder()
    {
        $data = $this->request->getPost();
        $data['username'] = $this->session->email;
        $this->order->insert($data);
    }

    public function view($order_id)
    {
        
        $order = $this->order->where('id', $order_id)->first();
        $user = $this->user->where('email', $order['username'])->first();
        if (!empty($user)) {
            $profile = $this->profile->where('user_id', $user['id'])->first();
            $order['username'] = $profile['firstname'] . " " . $profile['lastname']; //Getting the first and lastname of the user that report in the platform
        }
        $status = $this->ot_status->where('id', $order['status'])->first();
        $order['status'] = $status['name'];

        $comment_order = $this->com->where('order_id', $order['id'])->find();

        $mold = $this->mold->where('id', $order['mold_id'])->first();
        $mold_owner = $this->partner->where('id', $mold['partner_id'])->first();

        for ($i = 0; $i < count($comment_order); $i++) {
            $user_data = $this->user->where('id', $comment_order[$i]['user'])->first();
            $comment_order[$i]['user'] = $user_data['username'];
        }

        if ($order['machine_no'] != 'Solo Molde (SFC)') {
            $machine = $this->machine->where('id', $order['machine_no'])->first();
            $order['machine_no'] = $machine['name'];
        }

        $data = array(
            "view" => 'order/view',
            "session" => $this->session,
            "order" => $order,
            "owner" => $mold_owner,
            "mold" => $mold,
            "comment_order" => $comment_order
        );
        $dataHeader = array(
            "title" => 'Orden de trabajo ' . $order_id
        );
        $dataFooter = array();


        echo view('header_overlay', $dataHeader);
        echo view('overlay', $data);
        echo view('footer_overlay', $dataFooter);
    }
    public function addComment()
    {

        $data = $this->request->getPostGet();
        $user = $this->session->email;

        $user_id = $this->user->where('email', $user)->first();
        $comdata['order_id'] =  $data['order_id'];
        $comdata['comment'] = $data['comments'];
        $comdata['user'] = $user_id['id'];
        $this->com->insert($comdata);

        return redirect()->to('view/' . $data['order_id']);
    }
    public function generatePDF($order_id = '1')
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator('Greiner OT System');
        $pdf->SetAuthor('Adrian Vazquez');
        $pdf->SetTitle('Orden de trabajo #' . $order_id);
        $pdf->SetSubject('Orden de trabajo #' . $order_id);
        $pdf->SetKeywords('Orden de trabajo, OT, Greiner, GAM');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('times', 'BI', 12);

        // add a page
        $pdf->AddPage();

        // set some text to print
        $txt = PHP_EOL . "Orden de trabajo #" . $order_id . PHP_EOL . PHP_EOL . "Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods." . PHP_EOL;

        // print a block of text using Write()
        $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

        $pdf->SetXY(21, 7);
        $pdf->Write(0, "hello", '', 0, 'C', true, 0, false, false, 0);

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('example_003.pdf', 'd');

        //============================================================+
        // END OF FILE
        //============================================================+

    }
}
