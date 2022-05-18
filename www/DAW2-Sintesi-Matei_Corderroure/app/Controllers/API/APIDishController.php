<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\DishModel;

class APIDishController extends ResourceController
{
    public function getAll()
    {
        $dishModel = new DishModel();
        $dishes = $dishModel->getAllDishes();

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

    public function getAllDishesFromARestaurant($id_restaurant)
    {
        $dishModel = new DishModel();
        $dishes = $dishModel->getAllDishesSpecfic();

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
