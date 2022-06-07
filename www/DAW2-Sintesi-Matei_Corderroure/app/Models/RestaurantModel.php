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

    public function getAllRestaurants() {
        return $this->findAll();
    }

    public function dischargeRestaurant($id_restaurant) {
        $data = [
            'discharged' => 1
        ];

        $this->update($id_restaurant,$data);
    }

    /**
     * Selects all the restaurants that are not discharged  
     * 
     * 
     */
    public function getAllRestaurantsNotDischarged() {
        return $this->where('discharged', null)->findAll();
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

        $this->select(['restaurant.id', 'restaurant.name','restaurant.city','restaurant.street','restaurant.postal_code', 'restaurant.phone', 'AVG(valorations.score) as nota', 'restaurant.img_gallery']);
        $this->join('valorations', 'valorations.id_restaurant = restaurant.id', 'left');
        $this->groupBy('restaurant.id');

        return $this->findAll();
        
    }

    public function existsRestaurant($id_restaurant) {

        $check = $this->where('id', $id_restaurant)->first();

        return $check;
        
    }

    public function createRestaurant($name, $city, $street, $postal_code, $phone, $twitter, $instagram, $facebook) {

        $data = [
            'name' => $name, 
            'city' => $city, 
            'street' => $street, 
            'postal_code' => $postal_code, 
            'phone' => $phone, 
            'twitter' => $twitter, 
            'instagram' => $instagram, 
            'facebook' => $facebook
        ];

        $this->insert($data);
        
    }

    public function insertGallery($name, $city, $street, $postal_code, $phone, $img_gallery) {

       $restaurant =  $this->where('name', $name)->where('city', $city)
                           ->where('street', $street)
                           ->where('postal_code', $postal_code)
                           ->where('phone', $phone)
                           ->first();

       $data = [
           'img_gallery' =>  $img_gallery
       ];

       $this->update($restaurant['id'], $data);
    }

    public function checkRestaurant($name, $city, $street, $postal_code, $phone) {

        return $this->where('name', $name)
        ->where('city', $city)
        ->where('street', $street)
        ->where('postal_code', $postal_code)
        ->where('phone', $phone)->first();

    }

    public function addUserRestaurant($id_usuari ,$id_restaurant) {

        $data = [
            'id_user' => $id_usuari,
            'id_restaurant' => $id_restaurant
        ];

        $this->table('user_restaurant')->insert($data);

    }

     /**
     * getByTitleOrText
     * $search
     */
    public function restaurantSearch($search, $order, $act)
    {
        if ($order == "")
            return $this->select('*')->where('discharged', null)->orLike('id', $search, 'both', true)
            ->orLike('name', $search, 'both', true)
            ->orLike('city', $search, 'both', true)
            ->orLike('street', $search, 'both', true)
            ->orLike('postal_code', $search, 'both', true)
            ;
        else if ($act == "") {
            return $this->select('*')->where('discharged', null)->orLike('name', $search, 'both', true)->orderBy($order, "DESC");
        } else if ($act == "a") {
            return $this->select('*')->where('discharged', null)->orLike('name', $search, 'both', true)->orderBy($order, "ASC");
        }
    }

    /**
     * getAllPaged
     * $nElements
     */
    public function restaurantListPager($nElements, $order, $act)
    {
        if ($order == "")
            return $this->select('*')->where('discharged', null)->paginate($nElements);
        else if ($act == "") {
            return $this->select('*')->where('discharged', null)->orderBy($order, "DESC")->paginate($nElements);
        } else if ($act == "a") {
            return $this->select('*')->where('discharged', null)->orderBy($order, "ASC")->paginate($nElements);
        }
    }
}
