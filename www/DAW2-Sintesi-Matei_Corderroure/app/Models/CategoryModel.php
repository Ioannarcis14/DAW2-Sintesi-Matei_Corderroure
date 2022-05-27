<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'category';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_restaurant', 'id_category_parent', 'name', 'observation_msg'];

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

    public function getCategory($id_restaurant)
    {
        $this->select(['category.id', 'category.id_restaurant','category.id_category_parent','category.name','category.observation_msg', 'dish.id as dish_id', 'dish.name as dish_name', 'dish.price as dish_price', 'dish.description as dish_description', 'dish.imgs as imgs', 'dish.short_description as dish_short_description']);
        $this->join('dish_category', 'dish_category.id_category = category.id');
        $this->join('dish', 'dish.id = dish_category.id_dish');
        $this->where('category.id_restaurant ='. $id_restaurant);

        $this->orderBy('category.id');


        return $this->findAll();
    }

}

