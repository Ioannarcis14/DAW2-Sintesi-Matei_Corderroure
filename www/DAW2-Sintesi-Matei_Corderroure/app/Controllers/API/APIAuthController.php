<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Entities\User;
use CodeIgniter\Files\File;
use App\Models\UserModel as NoAuthUser;
use Myth\Auth\Config\Auth as AuthConfig;

use \Firebase\JWT\Key;
use \Firebase\JWT\JWT;

class APIAuthController extends ResourceController
{

    protected $helpers = ['auth', 'html'];


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
        helper(['form']);
        helper('html');

        $file = $this->request->getFile('userfile');

        if (file_exists($file)) {
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
                'userfile' => [
                    'label' => 'Image File',
                    'rules' => 'uploaded[userfile]'
                        . '|is_image[userfile]'
                        . '|mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                ],
            ];
        } else {
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
        }

        //Validation of the general fields of the form and the profile img
        if (!$this->validate($rules)) {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'Error with the general fields',
                'errors' => $this->validator->getErrors(),
            ];
            return $this->respond($response);
        }

        $users = model(UserModel::class);

        $active = 1;
        $email = $this->request->getPost('email');
        $username = $this->request->getPost('username');
        $name = $this->request->getPost('name');
        $surname = $this->request->getPost('surname');
        $phone = $this->request->getPost('phone');
        $city = $this->request->getPost('city');
        $street = $this->request->getPost('street');
        $postal_code = $this->request->getPost('postal_code');
        $password = $this->request->getPost('password');

        //Validation of the password
        $rules = [
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'Error with the password verification',
                'errors' => $this->validator->getErrors()
            ];
            return $this->respond($response);
        }


        if (file_exists($file)) {
            if (!$file->hasMoved()) {
                $filepath = WRITEPATH . 'uploads/' . $file->store("user/img_profile/");
                $Filetest = new File($filepath);
            } else {
                $response = [
                    'status' => 404,
                    "error" => true,
                    'messages' => 'There\'s been an error with the file',
                ];
                return $this->respond($response);
            }

            $hello = explode("user/img_profile/", $Filetest, 2);

            $camps = [
                'active' => $active,
                'email' => $email,
                'username' => $username,
                'name' => $name,
                'surname' => $surname,
                'img_profile' => $hello[1],
                'phone' => $phone,
                'city' => $city,
                'street' => $street,
                'postal_code' => $postal_code,
                'password' => $password,
            ];
        } else {
            $camps = [
                'active' => $active,
                'email' => $email,
                'username' => $username,
                'name' => $name,
                'surname' => $surname,
                'img_profile' => null,
                'phone' => $phone,
                'city' => $city,
                'street' => $street,
                'postal_code' => $postal_code,
                'password' => $password,
            ];
        }

        $user = new User($camps);
        $users = $users->withGroup("usuari");

        if (!$users->save($user)) {
            $response = [
                'status' => 500,
                "error" => true,
                'messages' => 'Error creating the user',
                'data' => [$user]
            ];
        } else {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'User has been saved',
                'data' => [$user]
            ];
        }
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
        helper('html');

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
        helper('html');

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
                    'data' => [$user]
                ];
            }
        } else {
            $response = [
                'status' => 400,
                "error" => true,
                'messages' => 'The user is not authenticated',
                'data' => []
            ];
        }

        return $this->respond($response);
    }
}
