<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplementModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'supplement';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'name', 'description', 'price'];

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

    public function createSupplement($nameSupplement, $descriptionSupplement) {

    }

    public function updateSupplement($idSupplement, $nameSupplement, $descriptionSupplement) {

    }

    public function deleteSupplement($idSupplement) {

    }

    public function getAllSupplements($id_dish) {
        $this->select(['supplement.id as id','supplement.name as name','supplement.description as desc','supplement.price as price']);
        $this->join('dish_supplement','dish_supplement.id_supplement = supplement.id');
        $this->join('dish', 'dish_supplement.id_dish = dish.id');
        $this->where('dish.id ='. $id_dish);
        return $this->findAll();
    }


    public function checkSupplement($id) {
       return $this->where('id', $id)->first();
    }
}
