<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\DishModel;

class APIDishController extends ResourceController
{
    /**
     * Get all dishes from a restaurant
     * 
     * It returns all the dishes that pertain to that restaurant, if there aren't dishes found it will return an error.
     * 
     * URL: localhost:80/api/dish/getAllRestaurant
     * 
     * * Mètode: GET
     *
     * @param int $id_restaurant The id of the restaurant that u want the dishes of.
     * @return mixed It returns the data of the dishes that are found.
     */
    public function getAllDishesFromARestaurant($id_restaurant)
    {
        $dishModel = new DishModel();
        $dishes = $dishModel->getAllDishesSpecific($id_restaurant);

        if (!empty($dishes)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'Dishes data found',
                'data' => $dishes
            ];
        } else {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'No dishes found',
                'data' => []
            ];
        }

        return $this->respond($response);
    }

}
