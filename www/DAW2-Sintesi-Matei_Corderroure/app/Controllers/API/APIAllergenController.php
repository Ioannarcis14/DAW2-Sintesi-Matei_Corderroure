<?php

namespace App\Controllers\API;

use App\Models\AllergenModel;
use CodeIgniter\RESTful\ResourceController;

class APIAllergenController extends ResourceController
{
     /**
     * Gets all the allergens that the dish has
     * 
     * It returns all the allergens that are in an specific dish
     * 
     * URL: localhost:80/api/allergens/getAll/(:any)
     * 
     * * Mètode: GET
     *
     * @param int $id_dish This is the id of the dish
     * @return mixed It returns the name of the allergens that are related with that dish
     */
    public function getAllAllergens($id_dish) {
        
        $allergenModel = new AllergenModel();
        $list = $allergenModel->getDishAllergen($id_dish);

        if (!empty($list)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'Allergen data found',
                'data' => $list
            ];
        } else {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'No allergens found',
                'data' => []
            ];
        }
        return $this->respond($response);
    }
}
