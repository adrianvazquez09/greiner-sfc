<?php namespace App\Models;

use CodeIgniter\Model;

class TechnicianModel extends Model
{
    protected $table      = 'tb_technician';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['employe_no', 'firstname','lastname','qr','permissions','enabled'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}