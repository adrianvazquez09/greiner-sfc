<?php

namespace App\Models;

use CodeIgniter\Model;

class MachineTypeModel extends Model
{
    protected $DBGroup = 'orders';
    protected $table      = 'tb_machine_type';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name','description','status'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}