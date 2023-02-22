<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentOrderModel extends Model
{
    protected $DBGroup = 'orders';
    protected $table      = 'tb_comments_orders';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'order_id', 'user', 'comment'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function openOrder($id)
    {
        $text = "Se generó la orden";
        $data['order_id'] = $id;
        $data['comment'] = $text;
        $data['user'] = '0';
        $this->insert($data);
    }

    public function changeStatus($id, $status)
    {
        $text = "Se cambió la orden a " . $status;
        $data['order_id'] = $id;
        $data['comment'] = $text;
        $data['user'] = '0';
        $this->insert($data);
    }

    public function closeOrder($id)
    {
        $text = "Se cerró la orden";
        $data['order_id'] = $id;
        $data['comment'] = $text;
        $data['user'] = '0';
        $this->insert($data);
    }

    public function moldChangeStatus($id, $status)
    {
        $text = "Se cambió el molde a " . $status;
        $data['order_id'] = $id;
        $data['comment'] = $text;
        $data['user'] = '0';
        $this->insert($data);
    }

    public function moldChangeOwner($id, $owner, $reason, $user)
    {
        $text = "Se cambió el responsable de molde a " . $owner . ".";
        if ($reason != '') {
            $text .= "Razón: " . $reason;
        }
        $data['order_id'] = $id;
        $data['comment'] = $text;
        $data['user'] = $user;
        $this->insert($data);
    }

    public function machineChangeStatus($id, $status)
    {
        $text = "Se cambió la maquina a " . $status;
        $data['order_id'] = $id;
        $data['comment'] = $text;
        $data['user'] = '0';
        $this->insert($data);
    }

    public function machineChangeOwner($id, $owner, $reason, $user)
    {
        $text = "Se cambió el responsable de maquina a " . $owner . ".";
        if ($reason != '') {
            $text .= "Razón: " . $reason;
        }
        $data['order_id'] = $id;
        $data['comment'] = $text;
        $data['user'] = $user;
        $this->insert($data);
    }
}
