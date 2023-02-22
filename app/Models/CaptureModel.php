<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Files;

class CaptureModel extends Model
{
    protected $table      = 'tb_capture';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['technician_qr', 'mold_qr', 'status_qr', 'machine_qr', 'type_work_qr', 'priority_qr', 'order_id', 'comments', 'finished'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function finishAnOrder($order_id)
    {
        $this->set('finished', 1)->where('order_id', $order_id)->update();
    }

    public function getDataCapturedMolds()
    {

        $procedure = $this->db->query("CALL `sp_capture_report`() ");
        $resultado = $procedure->getResultArray();
        // Open a file in write mode ('w')

        $fp = fopen('/var/www/html/moldsfc/writable/captureMold.csv', 'w');

        // Loop through file pointer and a line
        foreach ($resultado as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
        // $file = new \CodeIgniter\Files\File('/var/www/html/moldsfc/writable/capture.csv');
        // $this->response->download('/var/www/html/moldsfc/writable/capture.csv');
        //unlink('capture.csv');

        $file_url = '/var/www/html/moldsfc/writable/captureMold.csv';
        header('Content-Type: application/csv');
        header("Content-Transfer-Encoding: binary");
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
        readfile($file_url);
    }

    public function getDataCapturedMachines()
    {

        $procedure = $this->db->query("CALL `sp_capture_report_machine`() ");
        $resultado = $procedure->getResultArray();
        // Open a file in write mode ('w')

        $fp = fopen('/var/www/html/moldsfc/writable/captureMachines.csv', 'w');

        // Loop through file pointer and a line
        foreach ($resultado as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
        // $file = new \CodeIgniter\Files\File('/var/www/html/moldsfc/writable/capture.csv');
        // $this->response->download('/var/www/html/moldsfc/writable/capture.csv');
        //unlink('capture.csv');

        $file_url = '/var/www/html/moldsfc/writable/captureMachines.csv';
        header('Content-Type: application/csv');
        header("Content-Transfer-Encoding: binary");
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
        readfile($file_url);
    }
}
