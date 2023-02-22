<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderStatusModel extends Model
{
    protected $DBGroup = 'orders';
    protected $table      = 'tb_order_status';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name','order','description','status'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}