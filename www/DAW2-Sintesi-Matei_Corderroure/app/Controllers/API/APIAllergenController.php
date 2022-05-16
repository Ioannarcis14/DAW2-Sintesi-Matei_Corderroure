<?php

namespace App\Controllers\API;

use App\Models\AllergenModel;
use CodeIgniter\RESTful\ResourceController;

class APIAllergenController extends ResourceController
{
    public function getAllAllergens() {
        
        $allergenModel = new AllergenModel();
        $list = $allergenModel->getAllAllergen();

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
