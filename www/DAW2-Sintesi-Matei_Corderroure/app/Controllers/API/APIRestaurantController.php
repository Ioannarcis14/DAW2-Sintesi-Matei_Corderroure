<?php

namespace App\Controllers\API;

use App\Models\RestaurantModel;
use App\Models\UserModel;
use App\Models\UserRestaurantModel;
use App\Models\ValorationsModel;
use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourceController;

class APIRestaurantController extends ResourceController
{

    /** 
     * Get all restaurants in the database
     * 
     * It shows all the restaurants that are discharged
     * 
     * * URL: localhost:80/api/restaurants/getAll
     * 
     * * Method: POST
     * 
     * Parameters introduced by the User (sended by JSON or a form-data):
     * 
     * $login = string
     * 
     * This parameter can be used to put the email or the username, so the user can put one of those parameters for loggin in
     * $password = mixed
     * 
     * The password of the user
     * @return mixed It returns a token with information about the user if everything goes right, if there is any error it will return that error
     */
    public function getAllRestaurants()
    {

        $RestaModel = new RestaurantModel();
        $list = $RestaModel->getAllRestaurants();

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


    public function getAllRestaurantsWithReviews()
    {

        $RestaModel = new RestaurantModel();
        $list = $RestaModel->getRatedRestaurants();

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
    public function getSpecificRestaurant($id_restaurant)
    {

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
     * Get an specific restaurant
     * 
     * 
     * 
     */
    public function getAllRestaurantsFromUsers()
    {

        $token_data = json_decode($this->request->header("token-data")->getValue());

        if (!empty($token_data)  && $token_data->group = "responsable") {
            $RestaModel = new RestaurantModel();
            $restaurant = $RestaModel->getAllRestaurantsFromResponsable($token_data->uid);

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


    /**
     * Creates a restaurant
     * 
     * 
     * 
     */
    public function addRestaurant()
    {

        $token_data = json_decode($this->request->header("token-data")->getValue());
        $userModel = new UserModel();

        if (!empty($token_data) && !empty($userModel->getUserByMailOrUsername($token_data->email)) && in_array("responsable", json_decode(json_encode($token_data->group), true))) {
            //Check data
            $rules = [
                'descriptionRestaurant' => 'required',
                'nameRestaurant' => 'required',
                'cityRestaurant' => 'required',
                'streetRestaurant' => 'required',
                'phoneRestaurant' => 'required|min_length[9]|max_length[9]',
                'postal_codeRestaurant' => 'required',
                'twitterRestaurant' => 'valid_url_strict[https]',
                'facebookRestaurant' => 'valid_url_strict[https]',
                'instagramRestaurant' => 'valid_url_strict[https]',
            ];

            //Validation of the general fields of the form and the profile img
            if (!$this->validate($rules)) {
                $response = [
                    'status' => 400,
                    "error" => true,
                    'messages' => 'Error with the general fields',
                    'errors' => $this->validator->getErrors(),
                ];
                return $this->respond($response);
            }

            $restModel = new RestaurantModel();
            $restUserModel = new UserRestaurantModel();

            $id = $restModel->addRestaurant(
                $this->request->getPost('nameRestaurant'),
                $this->request->getPost('cityRestaurant'),
                $this->request->getPost('streetRestaurant'),
                $this->request->getPost('postal_codeRestaurant'),
                $this->request->getPost('phoneRestaurant'),
                $this->request->getPost('descriptionRestaurant'),
                $this->request->getPost('twitterRestaurant'),
                $this->request->getPost('instagramRestaurant'),
                $this->request->getPost('facebookRestaurant')
            );


            $check = $restModel->checkRestaurant($id);

            if (!empty($check)) {
                $files = $this->request->getFiles();
                $fileNames = "";
                if (!empty($files)) {
                    foreach ($files['userfile'] as $img) {
                        if ($img->isValid() && !$img->hasMoved()) {
                            $filepath = WRITEPATH . 'uploads/' . $img->store("restaurant/" . $check['id'] . "/");
                            $Filetest = new File($filepath);
                        } else {
                            $response = [
                                'status' => 400,
                                "error" => true,
                                'messages' => 'Error with the files',
                            ];
                            return $this->respond($response);
                        }
                        $file = explode("restaurant/" . $check['id'] . "/", $Filetest, 2);
                        $fileNames .= "," . $file[1];
                    }

                    $restModel->insertGallery(
                        $id,
                        $fileNames
                    );
                }

                $restUserModel->addUserRestaurant($token_data->uid, $check['id']);

                $check = $restUserModel->checkUserRestaurant($token_data->uid, $check['id']);

                if (!empty($check)) {
                    $response = [
                        'status' => 200,
                        "error" => false,
                        'messages' => "Succesfully added",
                        'data' => []
                    ];
                } else {
                    $response = [
                        'status' => 500,
                        "error" => true,
                        'messages' => "There\'s been an error",
                        'data' => []
                    ];
                }
            } else {
                $response = [
                    'status' => 500,
                    "error" => false,
                    'messages' => "There\'s been an error in the process of adding the restaurant",
                    'data' => []
                ];
            }
        } else {
            $response = [
                'status' => 401,
                "error" => true
            ];
        }

        return $this->respond($response);
    }

    /**
     * Updates a restaurant
     * 
     * 
     * 
     */
    public function updateRestaurant($id_restaurant)
    {
        $token_data = json_decode($this->request->header("token-data")->getValue());
        $userModel = new UserModel();

        if (!empty($token_data) && !empty($userModel->getUserByMailOrUsername($token_data->email)) && in_array("responsable", json_decode(json_encode($token_data->group), true))) {
            //Check data
            $rules = [
                'phone' => 'min_length[9]|max_length[9]',
                'postal_code' => 'required',
                'twitter' => 'valid_url_strict[https]',
                'facebook' => 'valid_url_strict[https]',
                'instagram' => 'valid_url_strict[https]',
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

            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'LEts go',
                'data' => [$this->request->getPost()],
            ];
            return $this->respond($response);

            $restModel = new RestaurantModel();

            $restModel->updateRestaurant($id_restaurant, $this->request->getPost());

            $files = $this->request->getFiles();
            $fileNames = "";

            if (!empty($files)) {
                foreach ($files['userfile'] as $img) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $filepath = WRITEPATH . 'uploads/' . $img->store("restaurant/" . $id_restaurant . "/");
                        $Filetest = new File($filepath);
                    } else {
                        $response = [
                            'status' => 400,
                            "error" => true,
                            'messages' => 'Error with the files',
                        ];
                        return $this->respond($response);
                    }
                    $file = explode("restaurant/" . $id_restaurant . "/", $Filetest, 2);
                    $fileNames .= "," . $file[1];
                }

                $restModel->updateGallery(
                    $id_restaurant,
                    $fileNames
                );
            }

            $response = [
                'status' => 200,
                "error" => false,
                'messages' => "Succesfully updated",
                'data' => []
            ];
        } else {
            $response = [
                'status' => 401,
                "error" => true
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
    public function getReviews($id_restaurant)
    {
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
