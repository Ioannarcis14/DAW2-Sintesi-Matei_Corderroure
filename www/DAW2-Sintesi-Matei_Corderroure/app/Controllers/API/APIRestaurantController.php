<?php

namespace App\Controllers\API;

use App\Models\RestaurantModel;
use App\Models\ValorationsModel;
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
    public function getAllRestaurants() {
        
        $RestaModel = new RestaurantModel();
        $list = $RestaModel->getAllRestaurantsDischarged();

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
    public function getSpecificRestaurant($id_restaurant) {

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
    public function getAllRestaurantsFromUsers() {

        $token_data = json_decode($this->request->header("token-data")->getValue());

        if(!empty($token_data)  && $token_data->group = "responsable") {
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
                'status' => 404,
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
    public function createRestaurant() {

        $token_data = json_decode($this->request->header("token-data")->getValue());

        if (!empty($token_data) && $token_data->group = "responsable") {

        $rules = [
            'name' => 'required',
            'city' => 'required',
            'street' => 'required',
            'postal_code' => 'required',
            'description' => '',
            'twitter' => 'valid_url_strict[https]',
            'facebook' => 'valid_url_strict[https]',
            'instagram  ' => 'valid_url_strict[https]',
            'phone' => 'required|min_length[9]|max_length[9]',
            'img_gallery' => [
                'label' => 'Image File',
                'rules' => 'uploaded[img_gallery]'
                    . '|is_image[img_gallery]'
                    . '|mime_in[img_gallery,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_dims[img_gallery,1024,768]',
            ],
        ];

        $restaModel = new RestaurantModel();

        $name = $this->request->getPost('name');
        $city = $this->request->getPost('city');
        $street = $this->request->getPost('street');
        $postal_code = $this->request->getPost('postal_code');
        $twitter = $this->request->getPost('twitter');
        $facebook = $this->request->getPost('facebook');
        $instagram = $this->request->getPost('instagram');
        $phone = $this->request->getPost('phone');


        //Validation of the general fields of the form and the profile img
        if (!$this->validate($rules)) {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'Error with the general fields',
                'errors' => $this->validator->getErrors()
            ];
            return $this->respond($response);
        }

        
    } else {
        $response = [
            'status' => 200,
            "error" => false,
            'messages' => 'The user cannot create a restaurant',
            'data' => []
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

    }

    /**
     * Deletes a restaurant
     * 
     * 
     * 
     */
    public function deleteRestaurant($id_restaurant)
    {

    }

    /**
     * Get the valorations of an specific restaurant
     * 
     * 
     * 
     */
    public function getReviews($id_restaurant) {
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

    public function createReviews()
    {

    }

}
