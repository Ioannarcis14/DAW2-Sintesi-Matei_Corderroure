<?php

namespace App\Controllers\API;

use App\Models\SupplementModel;
use CodeIgniter\RESTful\ResourceController;

class APISupplementController extends ResourceController
{
    public function index()
    {

    }

    public function getAllSupplements($id_dish) {
        $supplementModel = new SupplementModel();
        $supplements= $supplementModel->getAllSupplements($id_dish);

        if (!empty($supplements)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'Supplements data found',
                'data' => $supplements
            ];
        } else {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'No supplements found',
                'data' => []
            ];
        }

        return $this->respond($response);
    }
}
