<?php namespace App\Models;

use CodeIgniter\Model;

class UserRoleModel extends Model
{
    protected $table      = 'tb_role';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','name','description'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function finishAnOrder($order_id){
        $this->set('finished',1)->where('order_id',$order_id)->update();
    }
}