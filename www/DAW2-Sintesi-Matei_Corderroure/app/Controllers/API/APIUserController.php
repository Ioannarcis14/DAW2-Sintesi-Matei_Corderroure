<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Entities\User;
use CodeIgniter\Files\File;
use App\Models\UserModel as NoAuthUser;

use \Firebase\JWT\Key;
use \Firebase\JWT\JWT;

class APIUserController extends ResourceController
{

    protected $helpers = ['auth'];

    
    /**
     * Registers a user in the Database
     * 
     * It compiles the data, that the user is giving us and if the data passes through the validation, the user is created
     * 
     * URL: localhost:80/api/register
     * 
     * * Method: POST
     * 
     * Parameters introduced by the User (sended by JSON or a form-data):
     * 
     * * $username: string
     * 
     * This is username, that the future user will be known for
     * * $name: string
     * 
     * The real name of the User
     * * $surname: string
     * 
     * The real surname of the User
     * * $password: mixed
     * 
     * The password that the user will have to introduce
     * * $pass_confirm: mixed
     * 
     * This parameter will be used to verify that the user knows the password that he is introducing
     * * $phone: int
     * 
     * A phone number, that the user will have
     * * $city: string
     * 
     * The city, the user is currently located
     * * $street: string 
     * 
     * The street, that the user lives
     * * $postal_code: string
     * 
     * The postal code of the location
     * * $img_profile: mixed = null
     * 
     * The user can give and img, that will be used as a profile picture each time he enters his profile
     * @return mixed It returns a message indicating if the user has been registered or an error has occurred
     */
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
            'img' => 'required',
            'postal_code' => 'required',
        ];

        $users = model(UserModel::class);

        $email = $this->request->getVar('email');
        $username = $this->request->getVar('username');
        $name = $this->request->getVar('name');
        $surname = $this->request->getVar('surname');
        $phone = $this->request->getVar('phone');
        $city = $this->request->getVar('city');
        $street = $this->request->getVar('street');
        $postal_code = $this->request->getVar('postal_code');
        $password = $this->request->getVar('password');
        $file = $this->request->getVar('img');
        
        //Validation of the general fields of the form and the profile img
        if (!$this->validate($rules)) {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'Error with the general fields',
                'errors' => $this->validator->getErrors(),
                'data' => $camps = [
                    'email' => $email,
                    'username' => $username,
                    'name' => $name,
                    'surname' => $surname,
                    'phone' => $phone,
                    'city' => $city,
                    'street' => $street,
                    'postal_code' => $postal_code,
                    'password' => $password,
                    'img_profile' => $file
                ]
            ];
            return $this->respond($response);
        }


        //Validation of the password
        $rules = [
            'password'     => 'required',
            'pass_confirm' => 'required',
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

        $response = [
            'status' => 200,
            "error" => false,
            'messages' => 'Data received',
            'errors' => $camps = [
                'email' => $email,
                'username' => $username,
                'name' => $name,
                'surname' => $surname,
                'phone' => $phone,
                'city' => $city,
                'street' => $street,
                'postal_code' => $postal_code,
                'password' => $password,
                'img_profile' => $file
            ]
        ];
        return $this->respond($response);

        /*
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
                'messages' => 'User has been saved',
                'data' => []
            ];
        }
        */

        return $this->respond($response);
    }

    /** 
     * Logs in the user
     * 
     * When the user tries to log in, the auth service will verify if that user exists in the DB, if the user exists it will return a token for future authentications if not it will return an error
     * 
     * * URL: localhost:80/api/login
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

        $login = $this->request->getVar('login');
        $password = $this->request->getVar('password');

        $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (!$auth->attempt([$type => $login, 'password' => $password], false)) {
            $response = [
                'status' => 500,
                "error" => true,
                'messages' => 'The password or the user is incorrect'
            ];
            return $this->respond($response);
        }

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

        if (!empty($token)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'User logged',
                'token' => $token
            ];
        } else {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'There is an error with the login',
                'data' => []
            ];
        }
        return $this->respond($response);
    }

    /** 
     * Log off a user that is currently logged in
     * 
     * It exhausts the use of the token and doesn't respond so the token cannot renew by himself
     * 
     * URL: localhost:80/api/logout
     * 
     * * Method: POST
     * 
     * @return null It doesn't return anything, cuz it doesn't want to respond with a refresh token 
     */
    public function logout()
    {

    }

    /** 
     * Checks if the user is currently logged in
     * 
     * Checks if the token is still valid and the user currently exists
     * 
     * @return mixed It returns a refresh token if everything goes right, if there is any error in the procedure it will return that error
     */
    public function isUserAuthenticated()
    {
        $token_data = json_decode($this->request->header("token-data")->getValue());


        if (!empty($token_data)) {
            $userModel = new NoAuthUser();

            $email = $token_data->email;
            $user = $userModel->getUserByMailOrUsername($email);

            if (empty($user)) {
                $response = [
                    'status' => 500,
                    "error" => true,
                    'errors' => 'There is been an error with the verification process',
                    'data' => []
                ];
            } else {
                $response = [
                    'status' => 200,
                    "error" => false,
                    'messages' => 'The user is authenticated',
                    'data' => []
                ];
        }
        } else {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'The user is not authenticated',
                'data' => []
            ];
        }

        return $this->respond($response);
    }

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
        $UserModel = new NoAuthUser();
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

    /**
     * Get all roles available
     * 
     */
    public function getAllRoles()
    {
        $UserModel = new NoAuthUser();

        $roles = $UserModel->getRoles();

        if (!empty($roles)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'Users data founds',
                'data' => $roles
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

    /**
     * Create a Role
     * 
     */
    public function createRole()
    {

    }

    /**
     * Updates a role
     * 
     */
    public function updateRole($id_role)
    {

    }

    /**
     * Delete the role
     * 
     */
    public function deleteRole($id_role)
    {

    }

    /**
     * Assigns a role to a user
     * 
     */
    public function assignRole(){

    }
}
