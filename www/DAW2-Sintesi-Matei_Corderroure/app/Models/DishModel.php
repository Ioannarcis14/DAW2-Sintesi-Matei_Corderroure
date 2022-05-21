<?php

namespace App\Models;

use CodeIgniter\Model;

class DishModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'dish';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'description', 'name', 'price', 'imgs', 'short_description'];

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


    public function getAllDishesSpecific($id_restaurant) {
        $this->select(['dish.id','dish.description','dish.name','price', 'imgs', 'short_description']);
        $this->join('dish_category','dish_category.id_dish = dish.id');
        $this->join('category', 'dish_category.id_category = category.id');
        $this->where('category.id_restaurant ='. $id_restaurant);
        return $this->findAll();
    }


}
