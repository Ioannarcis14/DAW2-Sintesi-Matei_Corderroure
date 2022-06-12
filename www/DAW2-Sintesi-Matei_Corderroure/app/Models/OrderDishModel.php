<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderDishModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'order_dish';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_order', 'id_dish', 'quantity', 'observation', 'startTime', 'finishedTime', 'state', 'lastTimeAction'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function createOrderDish($id_order, $id_dish, $quantity, $observation) {
        
        $date = getdate(date("U"));
        $time = $date['year']. "-" . $date['mon'] . "-" . $date['mday'] . " " . $date['hours'] . ":" . $date['minutes'] . ":" . $date['seconds'];
        
        $data = [
            'id_order' => $id_order, 
            'id_dish' => $id_dish, 
            'quantity' => $quantity, 
            'observation' => $observation, 
            'startTime' => $time, 
            'id_order' => $id_order, 
            'lastTimeAction' => $time
        ];
        return $this->insert($data, true);
    }

    public function checkOrderDish($id) {
        return $this->where('id', $id)->first();

    }

}
