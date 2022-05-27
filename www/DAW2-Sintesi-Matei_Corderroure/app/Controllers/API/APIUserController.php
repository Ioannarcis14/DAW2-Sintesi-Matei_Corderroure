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

  /**
   * Get all users that are the staff of that restaurant
   */
    public function getAllStaff(){
        
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

        $file = new \CodeIgniter\Files\File(WRITEPATH.DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."user".DIRECTORY_SEPARATOR.$username.DIRECTORY_SEPARATOR.$user->img_profile);
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
