<?php

namespace App\Controllers\API;

use App\Models\DishModel;
use App\Models\DishSupplementModel;
use App\Models\OrderDishModel;
use App\Models\OrderDishSupplementModel;
use App\Models\OrderModel;
use App\Models\RestaurantModel;
use App\Models\SupplementModel;
use App\Models\TaulaModel;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class APIOrderController extends ResourceController
{
    public function index()
    {
        //
    }

    public function getAllOrders($id_responable)
    {
        $orderModel = new OrderModel();
        $orders = $orderModel->selectOrders($id_responable);

        if (!empty($orders)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'Order data found',
                'data' => $orders
            ];
        } else {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'No order found',
                'data' => []
            ];
        }

        return $this->respond($response);
    }
    /** 
     * Checks if the user is currently logged in
     * 
     * Checks if the token is still valid and the user currently exists, then sends a refresh token
     * 
     * URL: localhost:80/api/validate
     * 
     * * Method: POST
     * 
     * Parameters introduced by the User (sended by JSON or a form-data):
     * 
     * * $email: string
     * 
     * This is email of the user
     * * $token_data: mixed
     * 
     * This is the JWT_Token that contains the information encrypted of the user and allows him to use functions of the API if this one has the permissions to do so
     * @return mixed It returns a refresh token if everything goes right, if there is any error in the procedure it will return that error
     */

    /**
     * Creates an order
     * 
     * Creates the order that the user did and stores the data in the database
     * 
     * URL: localhost:80/api/order/create 
     * 
     * * Method: POST
     * 
     * Parameters introduced by the User (sended by JSON or a form-data):
     * 
     * 
     * * $token_data: mixed
     * This is the JWT_Token that contains the information encrypted of the user and allows him to use functions of the API if this one has the permissions to do so
     * 
     * 
     * * $order: string
     * This is the order that the web/phone application sends when the user finishes the order it contains: the id of the restaurant, the id of the user doing the order, the id of the table (offline/online) that they are occupying, number of people (diners) and the dishes that contain: the id of the dish, quantity, observation of the user, id of the supplement
     */

    public function createOrder()
    {
        $token_data = json_decode($this->request->header("token-data")->getValue());
        $userModel = new UserModel();

        if (!empty($token_data) && !empty($userModel->getUserByMailOrUsername($token_data->email))) {
            //Check data

            $rules = [
                'order' => 'required'
            ];

            //Validation of the general fields of the form
            if (!$this->validate($rules)) {
                $response = [
                    'status' => 400,
                    "error" => true,
                    'messages' => 'Error with the general fields',
                    'errors' => $this->validator->getErrors(),
                ];
                return $this->respond($response);
            }

            $order = json_decode($this->request->getVar('order'), true);

            $restModel = new RestaurantModel();
            $taulaModel = new TaulaModel();
            $dishModel = new DishModel();
            $orderModel = new OrderModel();
            $supplementModel = new SupplementModel();

            $checkRest = $restModel->checkRestaurantByID($order["id_rest"]);
            $checkUser = $userModel->getUserByID($order["id_client"]);
            $checkTaula =  $taulaModel->checkTaula($order["id_rest"], $order["id_taula"]);

            if (!empty($checkRest) && !empty($checkUser) && !empty($checkTaula)) {

                $date = getdate(date("U"));
                $time = $date['year'] . "-" . $date['mon'] . "-" . $date['mday'] . " " . $date['hours'] . ":" . $date['minutes'] . ":" . $date['seconds'];
                $id = $orderModel->createOrder($order["id_rest"], $order["id_client"], $order["id_taula"], null);
                $check = $orderModel->checkOrder($id);

                if (!empty($check)) {
                    //The order has been created
                    $taulaModel->occupyTable($order["id_taula"]);

                    $dishes = $order["dishes"];

                    foreach ($dishes as $dish) {
                        if (!empty($dishModel->getDish($dish['id_dish']))) {
                            //The dish exists in the database

                            $dishOrderModel = new OrderDishModel();
                            $dishSuplementModel = new DishSupplementModel();

                            $idDishOrder = $dishOrderModel->createOrderDish($id, $dish['id_dish'], $dish['quantity'], $dish['observation']);

                            if (!empty($dishOrderModel->checkOrderDish($idDishOrder))) {
                                if (!empty($supplementModel->checkSupplement($dish['id_supplement']))) {
                                    if(!empty($dishSuplementModel->check($dish['id_dish'],$dish['id_supplement']))) {

                                        $dishOrderSupplementModel = new OrderDishSupplementModel();
                                        
                                        $idDishOrderSupplement = $dishOrderSupplementModel->createOrderDishSupplement($idDishOrder, $dish['id_supplement']);
                                        
                                        if (empty($dishOrderSupplementModel->checkOrderDishSupplement($idDishOrderSupplement))) {
                                            $response = [
                                                'status' => 500,
                                                "error" => true,
                                                'messages' => "There's been an error with the supplements",
                                                'data' => []
                                            ];
                                            return $this->respond($response);
                                        } else {
                                            $response = [
                                                'status' => 200,
                                                "error" => false,
                                                'messages' => "Order saved succesfully",
                                                'data' => []
                                            ];
                                        }
                                    } else {
                                        $response = [
                                            'status' => 500,
                                            "error" => true,
                                            'messages' => "This supplement doesn't correspond with the dish",
                                            'data' => []
                                        ];
                                        return $this->respond($response);
                                    }
                                } else {
                                    $response = [
                                        'status' => 200,
                                        "error" => false,
                                        'messages' => "Order saved succesfully",
                                        'data' => []
                                    ];
                                }
                            } else {
                                $response = [
                                    'status' => 500,
                                    "error" => true,
                                    'messages' => "There's been an error with the dishes",
                                    'data' => []
                                ];
                                return $this->respond($response);
                            }
                        } else {
                            //The dish doesn't exists in the database
                            $response = [
                                'status' => 500,
                                "error" => true,
                                'messages' => "There's a dish that doesn't exist",
                                'data' => []
                            ];
                            return $this->respond($response);
                        }
                    }
                } else {
                    //The order couldn't be created
                    $response = [
                        'status' => 500,
                        "error" => true,
                        'messages' => 'An unexpected error has occurred',
                    ];
                }
            } else {
                //The ID's don't exist
                $response = [
                    'status' => 404,
                    "error" => true,
                    'messages' => 'Missing data',
                    'data' => []
                ];
            }
        } else {
            //The user doesn't have permissions to be here
            $response = [
                'status' => 401,
                "error" => true,
            ];
        }
        return $this->respond($response);
    }
}
