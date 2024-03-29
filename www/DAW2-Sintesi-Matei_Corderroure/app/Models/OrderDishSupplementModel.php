<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderDishSupplementModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'order_dish_supplement';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_order_dish', 'id_supplement'];

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




    public function createOrderDishSupplement($id_order_dish, $id_supplement) {
        $data = [
            'id_order_dish' => $id_order_dish,
            'id_supplement' => $id_supplement
        ];
        
        return $this->insert($data, true);

    }

    public function checkOrderDishSupplement($id) {
        return $this->where('id', $id)->first();
    }

}
