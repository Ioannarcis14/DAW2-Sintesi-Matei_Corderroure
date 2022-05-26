<?php

namespace App\Models;

use CodeIgniter\Model;

class RestaurantModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'restaurant';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'name', 'city', 'street', 'postal_code', 'description', 'phone', 'twitter', 
    'instagram', 'facebook','img_gallery', 'discharged'];

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


    //Functions to get data

    /**
     * Selects all the restaurants that are discharged  
     * 
     */
    public function getAllRestaurantsDischarged() {
        return $this->where('discharged !=', null)->findAll();
    }

    /**
     * Selects all the restaurants that are not discharged  
     * 
     * 
     */
    public function getAllRestaurantsNotDischarged() {
        return $this->where('discharged', null)->findall();
    }

    /**
     * Selects an specific restaurant
     * 
     * 
     */
    public function getSpecificRestaurant($id_restaurant) {
        return $this->where('id', $id_restaurant)->first();
    }

    public function getAllRestaurantsFromResponsable($id_responsable) {

        $this->select('*');
        $this->join('user_restaurant', 'user_restaurant.id_restaurant =  restaurant.id');
        $this->where('user_restaurant.id_user', $id_responsable);        
        return $this->findAll();
    }

    public function getRatedRestaurants(){

        $this->select(['restaurant.id', 'restaurant.name','restaurant.city','restaurant.street','restaurant.postal_code','AVG(valorations.score) as nota', 'restaurant.img_gallery']);
        $this->join('valorations', 'valorations.id_restaurant = restaurant.id');
        $this->groupBy('restaurant.id');

        return $this->findAll();
        
    }

}
