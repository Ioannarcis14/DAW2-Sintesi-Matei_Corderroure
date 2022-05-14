<?php

namespace App\Models;

use CodeIgniter\Model;

class RestaurantModel extends Model
{
    protected $DBGroup          = 'restdb';
    protected $table            = 'restaurants';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'name', 'city', 'street', 'postal_code', 'description', 'phone', 'social_websites',
        'img_gallery', 'discharged'];

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
        return $this->whereNotIn('discharged', null)->all();
    }

    /**
     * Selects all the restaurants that are not discharged  
     * 
     * 
     */
    public function getAllRestaurantsNotDischarged() {
        return $this->where('discharged', null)->all();
    }

    /*
    Selects the restaurants that the responsable owns
    */
    public function getSpecificRestaurants($id_responsable) {

    }

    /*
    Select the specific restaurant
    */
    public function getSpecificRestaurant($id_restaurant) {

    }




}
