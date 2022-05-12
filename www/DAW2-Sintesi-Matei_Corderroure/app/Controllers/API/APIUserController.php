<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Entities\User;
use CodeIgniter\Files\File;
use App\Models\UserModel as NoAuthUser;
use Myth\Auth\Authorization\GroupModel;

class APIUserController extends ResourceController
{

    protected $helpers = ['auth'];

    public function register()
    {
        $rules = [
            'username' => 'required|is_unique[users.username,id,{id}]',
            'email' => [
                'label'  => 'Email address',
                'rules'  => 'required|valid_email|is_unique[users.email,id,{id}]',
                'errors' => [
                    'required' => '{field} is required',
                    'valid_email' => '{field} doesn\'t appear to be a valid email address',
                    'is_unique' => 'This email address is already registered',
                ],
            ],
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'required|min_length[9]|max_length[9]',
            'city' => 'required',
            'street' => 'required',
            'postal_code' => 'required',
        ];

        $users = model(UserModel::class);

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

        $email = $this->request->getPost('email');
        $username = $this->request->getPost('username');
        $name = $this->request->getPost('name');
        $surname = $this->request->getPost('surname');
        $phone = $this->request->getPost('phone');
        $city = $this->request->getPost('city');
        $street = $this->request->getPost('street');
        $postal_code = $this->request->getPost('postal_code');

        //Validation of the password
        $rules = [
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'Error with the password',
                'errors' => $this->validator->getErrors()
            ];
            return $this->respond($response);
        }

        $password = $this->request->getPost('password');
        $file = $this->request->getFile('img_profile');

        if (!$file->hasMoved()) {
            $filepath = WRITEPATH . 'uploads/' . $file->store("user/img_profile/" . $username . "/");
            $Filetest = new File($filepath);
        } else {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'File has been moved',
            ];
            return $this->respond($response);
        }

        $camps = [
            'email' => $email,
            'username' => $username,
            'name' => $name,
            'surname' => $surname,
            'phone' => $phone,
            'city' => $city,
            'street' => $street,
            'postal_code' => $postal_code,
            'password' => $password,
            'img_profile' => $filepath
        ];

        $user = new User($camps);

        if (!empty($this->config->defaultUserGroup)) {
            $users = $users->withGroup($this->config->defaultUserGroup);
        }

        if (!$users->save($user)) {
            $response = [
                'status' => 500,
                "error" => true,
                'messages' => 'Error creating the user',
                'data' => []
            ];
        } else {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'User has been saved?',
                'data' => $user
            ];
        }

        return $this->respond($response);
    }

    /** 
     * 
     * 
     */
    public function login()
    {
        $auth = service('authentication');

        $rules = [
            'login'    => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            $response = [
                'status' => 400,
                "error" => true,
                'messages' => 'Error with the fields',
                'errors' => $this->validator->getErrors()
            ];
            return $this->respond($response);
        }

        $userModel = new NoAuthUser();

        $login = $this->request->getPost('login');

        $user = $userModel->getUserByMailOrUsername($login);

        $password = $this->request->getPost('password');
        if ($user) {
            if (!password_verify($password, $user['password_hash'])) {
                $response = [
                    'status' => 500,
                    "error" => true,
                    'errors' => 'This password is incorrect'
                ];
                return $this->respond($response);
            }
        } else {
            $response = [
                'status' => 500,
                "error" => true,
                'errors' => 'There is been an error creating the user'
            ];
            return $this->respond($response);
        }

        helper("jwt");
        $APIGroupConfig = "default";
        $cfgAPI = new \Config\APIJwt($APIGroupConfig);

        $data = array(
            "uid" => $user['id'],
            "name" => $user['username'],
            "email" => $user['email'],

        );

        $token = newTokenJWT($cfgAPI->config(), $data);


        if (!empty($token)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'User logged',
                'data' => $token
            ];
        } else {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'There is an error with the loggin',
                'data' => []
            ];
        }
        return $this->respond($response);
    }

    public function logout()
    {
        if (empty($current_user)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'The user has been logged off succesfully',
            ];
        } else {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'There is been an error with the log off process',
            ];
        }
    }

    public function isUserAuthenticated()
    {



        if (!empty($current_user)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'The user is currently logged',
            ];
        } else {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'The user is not logged',
            ];
        }
        return $this->respond($response);
    }
}
