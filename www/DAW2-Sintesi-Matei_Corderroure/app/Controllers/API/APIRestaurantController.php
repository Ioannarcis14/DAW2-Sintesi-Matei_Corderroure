<?php

namespace App\Controllers\API;

use App\Models\RestaurantModel;
use App\Models\ValorationsModel;
use CodeIgniter\RESTful\ResourceController;

class APIRestaurantController extends ResourceController
{
    public function index()
    {

    }

    /** 
     * Get all restaurants in the database
     * 
     * 
    */
    public function getAllRestaurants() {
        
        $RestaModel = new RestaurantModel();
        $list = $RestaModel->getAllRestaurantsDischarged();

        if (!empty($list)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'Restaurant data found',
                'data' => $list
            ];
        } else {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'No restaurants found',
                'data' => []
            ];
        }
        return $this->respond($response);
    }


    /**
     * Get an specific restaurant
     * 
     * 
     * 
     */
    public function getSpecificRestaurant($id_restaurant) {

        $RestaModel = new RestaurantModel();
        $restaurant = $RestaModel->getSpecificRestaurant($id_restaurant);

        if (!empty($restaurant)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'Restaurant data found',
                'data' => $restaurant
            ];
        } else {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'No restaurant found',
                'data' => []
            ];
        }
        return $this->respond($response);
    }

    /**
     * Get the valorations of an specific restaurant
     * 
     * 
     * 
     */
    public function getReviews($id_restaurant) {
        $ValModel = new ValorationsModel();

        $valorations = $ValModel->getAllValorations($id_restaurant);

        if (!empty($valorations)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'Valorations data found',
                'data' => $valorations
            ];
        } else {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'No valorations found',
                'data' => []
            ];
        }
        return $this->respond($response);

    }


}
