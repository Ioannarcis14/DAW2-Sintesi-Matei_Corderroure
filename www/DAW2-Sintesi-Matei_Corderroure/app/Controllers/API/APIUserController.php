<?php

namespace App\Controllers\API;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;

class APIUserController extends ResourceController
{
    protected $helpers = ['auth'];

    /**
     * Get all Users in the Database
     * 
     * It returns all the users that are in the database, if there aren't users found it will return an error
     * 
     * URL: localhost:80/api/users/getAll
     * 
     * * Mètode: GET
     *
     * @return mixed It returns the email and username of all the users
     */

    public function getAllUsers()
    {
        //
        $UserModel = new UserModel();
        $data = $UserModel->getAllUsers();

        if (!empty($data)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'Users data founds',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'No users found',
                'data' => []
            ];
        }

        return $this->respond($response);
    }

    public function login()
    {
        $auth = service('authentication');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $credentials = [
            'username' => $username,
            'password' => $password
        ];

        $auth->attempt($credentials, false);

        $current_user = $auth->user();

        helper("jwt");
        $APIGroupConfig = "default";
        $cfgAPI = new \Config\APIJwt($APIGroupConfig);

        $data = array(
            "uid" => $current_user->id,
            "name" => $current_user->name,
            "email" => $current_user->email,
            "group" => $current_user->getRoles($current_user->id)
        );

        $token = newTokenJWT($cfgAPI->config(), $data);

        if (!empty($current_user)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'Users data founds',
                'data' => $token
            ];
        } else {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'No users found',
                'data' => []
            ];
        }
        return $this->respond($response);
    }
}
