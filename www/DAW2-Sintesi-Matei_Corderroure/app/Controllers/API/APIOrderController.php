<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;

class APIOrderController extends ResourceController
{
    public function index()
    {
        //
    }

    public function createOrder() {

        $token_data = json_decode($this->request->header("token-data")->getValue());

        if(!empty($token_data)  && $token_data->group = "responsable") {
            $rules = [
                'order' => 'required'
            ];

            



        } else {
            $response = [
                'status' => 401,
                "error" => true,
                'messages' => 'This user isn\'t a responsable',
                'data' => []
            ];
        }
        return $this->respond($response);


    }
}
