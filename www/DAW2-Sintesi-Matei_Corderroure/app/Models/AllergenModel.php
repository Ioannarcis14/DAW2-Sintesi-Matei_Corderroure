<?php

namespace App\Models;

use CodeIgniter\Model;

class AllergenModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'allergen';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'name'];

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

    public function getAllAllergen() {
        return $this->findAll();
    }

    public function getDishAllergen($id_dish) {
        $this->select(['allergen.id as id','allergen.name as name']);
        $this->join('dish_allergen','dish_allergen.id_allergen = allergen.id');
        $this->join('dish', 'dish_allergen.id_dish = dish.id');
        $this->where('dish.id ='. $id_dish);
        return $this->findAll();
    }

}
