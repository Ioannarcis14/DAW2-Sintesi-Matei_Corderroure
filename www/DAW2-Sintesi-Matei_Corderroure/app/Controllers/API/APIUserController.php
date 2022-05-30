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

class APIUserController extends ResourceController
{


    public function changePassword()
    {
        helper('form');

        $token_data = json_decode($this->request->header("token-data")->getValue());

        $rules = [
            'email' => [
                'label'  => 'Email address',
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required' => '{field} is required',
                    'valid_email' => '{field} doesn\'t appear to be a valid email address',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            $response = [
                'status' => 400,
                "error" => true,
                'messages' => $this->validator->getErrors()
            ];
            return $this->respond($response);
        }

        $email = $this->request->getVar('email');


        if (!empty($token_data) && $token_data->email == $email) {

            //Validation of the password
            $rules = [
                'newPass'     => 'required|strong_password',
                'newPassConfirm' => 'required|matches[newPass]',
            ];

            if (!$this->validate($rules)) {
                $response = [
                    'status' => 400,
                    "error" => true,
                    'messages' => "Error with the password"
                ];
                return $this->respond($response);
            }

            $userModel = new NoAuthUser();
            $userModel->changePassword($this->request->getVar('newPass'), $token_data->uid);

            $auth = service('authentication');

            $credentials = [
                'email' => $this->request->getVar('email'),
                'password' => $this->request->getVar('newPass')
            ];

            if (!$auth->validate($credentials)) {
                $response = [
                    'status' => 200,
                    "error" => false,
                    "messages" => "Password changed correctly"
                ];
                return $this->respond($response);
            } else {
                $response = [
                    'status' => 500,
                    "error" => true,
                    "messages" => "There's been an error with the password change"
                ];
                return $this->respond($response);
            }
        } else {
            $response = [
                'status' => 401,
                "error" => true,
            ];
            return $this->respond($response);
        }
    }


    /**
     * Get all users that are the staff of that restaurant
     */
    public function updateUser()
    {

        helper(['form']);
        helper('html');

        $rules = [
            'username' => 'is_unique[users.username,id,{id}]',
            'email' => [
                'label'  => 'Email address',
                'rules'  => 'valid_email|is_unique[users.email,id,{id}]',
                'errors' => [
                    'valid_email' => '{field} doesn\'t appear to be a valid email address',
                    'is_unique' => 'This email address is already registered',
                ],
            ],
            'phone' => 'min_length[9]|max_length[9]',
            'userfile' => [
                'label' => 'Image File',
                'rules' => 'uploaded[userfile]'
                    . '|is_image[userfile]'
                    . '|mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
            ],
        ];

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

        $response = [
            'status' => 200,
            'error' => false,
            'messages' => $this->request->getPost()
        ];

        return $this->respond($response);

        $token_data = json_decode($this->request->header("token-data")->getValue());
        $auth = service('authentication');
        $user = $auth->user();

        if (!empty($token_data) && $token_data->email == $user->email) {

            helper(['form']);

            $rules = [
                'username' => 'is_unique[users.username,id,{id}]',
                'email' => [
                    'label'  => 'Email address',
                    'rules'  => 'valid_email|is_unique[users.email,id,{id}]',
                    'errors' => [
                        'valid_email' => '{field} doesn\'t appear to be a valid email address',
                        'is_unique' => 'This email address is already registered',
                    ],
                ],
                'phone' => 'min_length[9]|max_length[9]',
            ];

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
        }
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
    public function assignRole()
    {
    }

    /**
     * Gets the img from the db of the user and returns it with base64 
     */

    public function returnUserImage()
    {
        $rules = [
            'username' => 'required'
        ];

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

        $username = $this->request->getPost('username');
        $userModel = new NoAuthUser();
        $user = $userModel->getUserByMailOrUsername($username);

        $file = new \CodeIgniter\Files\File(WRITEPATH . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "user" . DIRECTORY_SEPARATOR . $username . DIRECTORY_SEPARATOR . $user->img_profile);
        $fileEncoded = base64_encode($file);

        if (!$file->isFile()) {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'Profile picture not found',
                'data' =>  []
            ];
        } else {
            $response = [
                'status' => 200,
                'error' => false,
                'data' => $fileEncoded
            ];
        }
        return $this->respond($response);
    }
}
