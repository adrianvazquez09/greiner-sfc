<?php namespace App\Models;

use CodeIgniter\Model;

class ShotsModel extends Model
{
    protected $table      = 'tb_shots';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['mold_id', 'shots'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function resetShotCounter($mold_id){
        $this->where('mold_id',$mold_id)->delete();
        $data = array(
            'mold_id' => $mold_id,
            'shots' => '0'
        );
        $this->insert($data);
    }
}