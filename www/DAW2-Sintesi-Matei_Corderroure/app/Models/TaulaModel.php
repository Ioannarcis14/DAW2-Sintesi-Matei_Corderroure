<?php

namespace App\Models;

use CodeIgniter\Model;

class TaulaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'taula';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_restaurant', 'toTakeAway', 'state'];

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


    public function createTable($id_restaurant, $toTakeAway) {
        $data = [
            'id_restaurant' => $id_restaurant,
            'toTakeAway' => $toTakeAway,
        ];

        $this->insert($data);

        return $this->db->affectedRows();
    }

    public function getAvailableTables($id_restaurant) {
       return $this->select('*')->
        orWhere('taula.id_restaurant', $id_restaurant)
        ->orWhere('taula.toTakeAway !=', null)
        ->orWhere('order.state', "finished")->findAll();
        
    }
}
