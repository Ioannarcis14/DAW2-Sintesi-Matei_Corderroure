<?php

namespace App\Models;

use CodeIgniter\Model;

class ValorationsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'valorations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_restaurant', 'id_user', 'score', 'review'];

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

    /**
     * Get all valorations from an especific restaurant ID
     * 
     * It will return the valorations that the customers put to that restaurant
     */
    public function getAllValorations($id_restaurant){
        return $this->where('id_restaurant', $id_restaurant)->findAll();
    }

    public function createValoration($id_restaurant, $id_user, $rating, $observation) {
        
        $data = [
            'id_restaurant' => $id_restaurant,
            'id_user' => $id_user,
            'score' => $rating,
            'review' => $observation,
        ];

        $this->insert($data);
    }

    public function checkValoration($id_restaurant, $id_user) {

        $valoration = $this->where('id_restaurant',$id_restaurant)->where('id_user', $id_user)->first();

        if(!empty($valoration)) {
            return true;
        } else {
            return false;
        }

    }
}
