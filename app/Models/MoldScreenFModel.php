<?php namespace App\Models;

use CodeIgniter\Model;

class MoldScreenFModel extends Model
{
    protected $table      = 'tb_shop_screen_f';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','priority', 'mold','work_type','responsable','entry_date','delivery_date','comments','status','progress'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}