<?php

namespace App\Controllers\API;

use App\Models\MessagesModel;
use App\Models\ThemeModel;
use CodeIgniter\RESTful\ResourceController;

class APIMessagesController extends ResourceController
{
    public function index()
    {
        //
    }

    public function getMessagesFromUser($email)
    {

        $MessageModel = new MessagesModel();
        $list = $MessageModel->getMessagesFromUser($email);

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

    public function getMessageNumber($email)
    {

        $MessageModel = new MessagesModel();
        $list = $MessageModel->getMessages($email);

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
     * Create theme
     * 
     * It creates a theme so users when they try to contact the admin they have the option to select them
     * 
     * URL: localhost:80/api/theme/create
     * 
     * * Method: POST
     * 
     * Parameters introduced by the User (sended by JSON or a form-data):
     * 
     * * $token_data: mixed
     * 
     * This is the JWT_Token that contains the information encrypted of the user and allows him to use functions of the API if this one has the permissions to do so
     * * $themeName: string
     * 
     * This is the theme name that will be created
     * @return mixed It returns an error if something wrong happened while creating the theme or a confirmation message 
     */
    public function themeCreate()
    {
        helper('form');
        helper('html');

        $token_data = json_decode($this->request->header("token-data")->getValue());
        $auth = service('authentication');
        $auth->check();
        $currentUser = $auth->user();

        if (!empty($token_data) && $token_data->email == $currentUser->email && in_array("administrador", $currentUser->getRoles())) {

            //Validation of the password
            $rules = [
                'themeName'     => 'required',
            ];

            if (!$this->validate($rules)) {
                $response = [
                    'status' => 400,
                    "error" => true,
                    'messages' => "Error with the fields"
                ];
                return $this->respond($response);
            }

            $themeName = $this->request->getVar('themeName');
            $themeModel = new ThemeModel();

            $themeModel->themeCreate($themeName);
            $check = $themeModel->checkTheme($themeName);

            if (empty($check)) {
                $response = [
                    'status' => 500,
                    "error" => true,
                    'messages' => "Failed to create the theme"
                ];
            } else {
                $response = [
                    'status' => 200,
                    "error" => false,
                    'messages' => "Theme created successfully"
                ];
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

    /**
     * Updates the theme
     * 
     * Updates an old theme name and replaces it by a new one
     * 
     * URL: localhost:80/api/theme/updateTheme
     * 
     * * Method: POST
     * 
     * Parameters introduced by the User (sended by JSON or a form-data):
     * 
     * * $token_data: mixed
     * 
     * This is the JWT_Token that contains the information encrypted of the user and allows him to use functions of the API if this one has the permissions to do so
     * * $themeName: string
     * 
     * This is the theme name that will be used now
     * * $oldthemeName: string
     * 
     * This is the theme name that was used before
     * @return mixed It returns an error if something wrong happened while creating the theme or a confirmation message 
     */
    public function themeUpdate()
    {
        helper('form');
        helper('html');

        $token_data = json_decode($this->request->header("token-data")->getValue());
        $auth = service('authentication');
        $auth->check();
        $currentUser = $auth->user();

        if (!empty($token_data) && $token_data->email == $currentUser->email && in_array("administrador", $currentUser->getRoles())) {

            //Validation of the password
            $rules = [
                'oldThemeName' => 'required',
                'themeName'     => 'required',
            ];

            if (!$this->validate($rules)) {
                $response = [
                    'status' => 400,
                    "error" => true,
                    'messages' => "Error with the fields"
                ];
                return $this->respond($response);
            }
            $oldThemeName = $this->request->getVar('oldThemeName');
            $themeName = $this->request->getVar('themeName');
            $themeModel = new ThemeModel();

            $themeModel->themeUpdate($oldThemeName, $themeName);
            $check = $themeModel->checkTheme($themeName);

            if (empty($check)) {
                $response = [
                    'status' => 500,
                    "error" => true,
                    'messages' => "Failed to update the theme"
                ];
            } else {
                $response = [
                    'status' => 200,
                    "error" => false,
                    'messages' => "Theme updated successfully"
                ];
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
