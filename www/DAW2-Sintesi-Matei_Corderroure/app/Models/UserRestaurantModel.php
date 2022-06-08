<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRestaurantModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user_restaurant';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_user', 'id_restaurant'];

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


    public function addUserRestaurant($id_user ,$id_restaurant) {
        $data = [
            'id_user' => $id_user,
            'id_restaurant' => $id_restaurant
        ];

        $this->insert($data);
    }

     public function checkRestaurant($id_user, $id_restaurant) {
         return $this->select('*')->orWhere('id_user', $id_user)->orWhere('id_restaurant', $id_restaurant);
     }

}
