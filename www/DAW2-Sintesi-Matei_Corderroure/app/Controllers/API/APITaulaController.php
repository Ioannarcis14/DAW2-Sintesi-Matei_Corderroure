<?php

namespace App\Controllers\API;

use App\Models\RestaurantModel;
use App\Models\TableModel;
use App\Models\UserRestaurantModel;
use CodeIgniter\RESTful\ResourceController;

class APITaulaController extends ResourceController
{
    public function index()
    {
        //
    }


    /**
     * Creates a table
     * 
     * It creates a table for the restaurant that its specified by the id and if the table can be used as an "on-line table" or an "offline table"
     * 
     * * URL: localhost:80/api/taula/create
     * 
     * * Method: POST
     * 
     * Parameters introduced by the User (sended by JSON or a form-data):
     * 
     * * $token_data: mixed
     * 
     * This is the JWT_Token that contains the information encrypted of the user and allows him to use functions of the API if this one has the permissions to do so
     * * $id_restaurant: int
     * 
     * This is the id of the restaurant that the user owns and the table will be associated with
     * * $toTakeAway: int|null
     * 
     * Its the parameter to indicate if the table will be used on-line or offline
     * 
     * @return mixed It returns a message indicating if the table has been created or an error has occurred
     */
    public function createTable()
    {

        $token_data = json_decode($this->request->header("token-data")->getValue());

        if (!empty($token_data)  && $token_data->group = "responsable") {
            $id_restaurant = $this->request->getVar('id_restaurant');
            $toTakeAway = $this->request->getVar('toTakeAway');

            $userRestModel = new UserRestaurantModel();
            $check = $userRestModel->checkRestaurant($token_data->uid, $id_restaurant);

            if(empty($check)) {
                $response = [
                    'status' => 404,
                    "error" => true,
                    'messages' => 'This restaurant doesn\' exist',
                    'data' => []
                ];
            } else {
                $tabModel = new TableModel();
                $check = $tabModel->createTable($id_restaurant, $toTakeAway);

                if(!empty($check)) {
                    $response = [
                        'status' => 200,
                        "error" => false,
                        'messages' => 'Table created successfully saved',
                        'data' => []
                    ];
                } else {
                    $response = [
                        'status' => 500,
                        "error" => true,
                        'messages' => 'Error creating the user',
                        'data' => []
                    ];
                }
            }
        } else {
            $response = [
                'status' => 401,
                "error" => true,
                "messages" => "You don't have the permission to do this action",
            ];
        }
        return $this->respond($response);
    }

    
}
