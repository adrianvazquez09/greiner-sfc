<?php

namespace App\Models;

use CodeIgniter\Model;

class SparePartsModel extends Model
{
    protected $table      = 'tb_spare_parts';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','concept','description','details','price','provider','amount','min','max','type'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}