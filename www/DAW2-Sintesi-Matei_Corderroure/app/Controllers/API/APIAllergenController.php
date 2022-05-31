<?php

namespace App\Controllers\API;

use App\Models\AllergenModel;
use CodeIgniter\RESTful\ResourceController;

class APIAllergenController extends ResourceController
{
     /**
     * Get all Allergens
     * 
     * It returns all the allergens that are in the database, if there aren't allergens found it will return an error
     * 
     * URL: localhost:80/api/allergens/getAll
     * 
     * * Mètode: GET
     *
     * @return mixed It returns the name of the allergens that are found
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
