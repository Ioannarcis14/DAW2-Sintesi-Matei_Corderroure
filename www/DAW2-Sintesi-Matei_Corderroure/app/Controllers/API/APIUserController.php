<?php

namespace App\Controllers\API;

use App\Models\MessagesModel;
use App\Models\RestaurantModel;
use CodeIgniter\RESTful\ResourceController;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Entities\User;
use CodeIgniter\Files\File;
use App\Models\UserModel as NoAuthUser;
use App\Models\ValorationsModel;
use Myth\Auth\Config\Auth as AuthConfig;

use \Firebase\JWT\Key;
use \Firebase\JWT\JWT;

class APIUserController extends ResourceController
{

    /**
     * Changes the password of the user
     */
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
                'newPass'     => 'required',
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

            if ($auth->validate($credentials)) {
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
                    "messages" => "There's been an error with the password change",
                    "data" => []
                ];
                return $this->respond($response);
            }
        } else {
            $response = [
                'status' => 401,
                "error" => true,
                "messages" => "You don't have the permission to do this action",
            ];
            return $this->respond($response);
        }
    }

    /**
     * Updates the information of an specific user
     */
    public function updateUserSpecific($id)
    {
        helper('form');
        helper('html');

        $token_data = json_decode($this->request->header("token-data")->getValue());
        $auth = service('authentication');
        $auth->check();
        $currentUser = $auth->user();

        if (!empty($token_data) && $token_data->email == $currentUser->email && in_array("administrador", $currentUser->getRoles())) {
            if (file_exists($this->request->getFile('userfile'))) {
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
            } else {
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
            }

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


            $file = $this->request->getFile('userfile');

            if (file_exists($file)) {
                if (!$file->hasMoved()) {
                    $filepath = WRITEPATH . 'uploads/' . $file->store("user/img_profile/");
                    $Filetest = new File($filepath);
                } else {
                    $response = [
                        'status' => 400,
                        "error" => true,
                        'messages' => 'There\'s been an error with the file',
                    ];
                    return $this->respond($response);
                }

                $file = explode("user/img_profile/", $Filetest, 2);
                $file = $file[1];
            }

            $users = new NoAuthUser();
            $data = $users->updateUser($id, $this->request->getPost(), $file);

            if (!$data) {
                $response = [
                    'status' => 500,
                    "error" => true,
                    'messages' => 'Error updating the user',
                    'data' => []
                ];
            } else {
                $response = [
                    'status' => 200,
                    "error" => false,
                    'messages' => 'The user has been updated',
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
     * Updates the users data 
     */
    public function updateUser()
    {
        helper('form');
        helper('html');

        $token_data = json_decode($this->request->header("token-data")->getValue());
        $auth = service('authentication');
        $auth->check();
        $currentUser = $auth->user();

        if (!empty($token_data) && $token_data->email == $currentUser->email) {
            if (file_exists($this->request->getFile('userfile'))) {
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
            } else {
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
            }

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


            $file = $this->request->getFile('userfile');

            if (file_exists($file)) {
                if (!$file->hasMoved()) {
                    $filepath = WRITEPATH . 'uploads/' . $file->store("user/img_profile/");
                    $Filetest = new File($filepath);
                } else {
                    $response = [
                        'status' => 400,
                        "error" => true,
                        'messages' => 'There\'s been an error with the file',
                    ];
                    return $this->respond($response);
                }

                $file = explode("user/img_profile/", $Filetest, 2);
                $file = $file[1];
            }

            $users = new NoAuthUser();
            $data = $users->updateUser($currentUser->id, $this->request->getPost(), $file);

            if (!$data) {
                $response = [
                    'status' => 500,
                    "error" => true,
                    'messages' => 'Error updating the user',
                    'data' => []
                ];
            } else {
                $response = [
                    'status' => 200,
                    "error" => false,
                    'messages' => 'The user has been updated',
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

    public function getUser($user)
    {
        //
        $UserModel = new NoAuthUser();
        $data = $UserModel->getUserByMailOrUsername($user);

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
                'status' => 400,
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

    /**
     * Create a valoration
     */
    public function createValorations()
    {
        helper('form');
        helper('html');

        $token_data = json_decode($this->request->header("token-data")->getValue());
        $auth = service('authentication');
        $auth->check();
        $currentUser = $auth->user();
        $restaurantCheck = new RestaurantModel();
        $valModel = new ValorationsModel();

        if (!empty($token_data) && $token_data->email == $currentUser->email) {

            $id_restaurant = $this->request->getVar('id_restaurant');

            //Check restaurant
            if (!empty($restaurantCheck->existsRestaurant($id_restaurant))) {

                //Validate the rating 
                $rules = [
                    'rating' => 'required'
                ];

                if (!$this->validate($rules)) {
                    $response = [
                        'status' => 400,
                        "error" => true,
                        'messages' => 'Error with the general fields',
                        'errors' => $this->validator->getErrors(),
                    ];
                    return $this->respond($response);
                }

                //Make the valoration
                $valModel->createValoration($id_restaurant, $token_data->uid, $this->request->getVar('rating'),$this->request->getVar('observation'));

                if (!empty($valModel->checkValoration($id_restaurant, $token_data->uid))) {
                    $response = [
                        'status' => 200,
                        "error" => false,
                        'messages' => 'Review succesfully created',
                    ];
                } else {
                    $response = [
                        'status' => 500,
                        "error" => true,
                        'messages' => 'An error while creating the review has occurred',
                    ];
                }
            } else {
                $response = [
                    'status' => 404,
                    "error" => true,
                    'messages' => 'This restaurant doesn\'t exist',
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
     * Creates a contact message that can be seen by the admins
     */
    public function contactAdmin()
    {
        helper('form');
        helper('html');

        $token_data = json_decode($this->request->header("token-data")->getValue());
        $msgModel = new MessagesModel();
        $auth = service('authentication');
        $auth->check();
        $currentUser = $auth->user();


        if (!empty($token_data) && $token_data->email == $currentUser->email) {

            //Check the content
            $rules = [
                'theme' => 'required',
                'commentary' => 'required'
            ];

            if (!$this->validate($rules)) {
                $response = [
                    'status' => 400,
                    "error" => true,
                    'messages' => 'Error with the general fields',
                    'errors' => $this->validator->getErrors(),
                ];
                return $this->respond($response);
            }

            $msgModel->createMessage($token_data->uid, $this->request->getVar('theme'),$this->request->getVar('commentary'));
            
            if (!empty($msgModel->checkMessage($token_data->uid, 0, $this->request->getVar('theme')))) {
                $response = [
                    'status' => 200,
                    "error" => false,
                    'messages' => 'Contact message created',
                ];
            } else {
                $response = [
                    'status' => 500,
                    "error" => true,
                    'messages' => 'An error while sending the messsage',
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
     * Creates a contact message that can be seen by the admins
     */
    public function dischargeRestaurant()
    {
        helper('form');
        helper('html');

        $token_data = json_decode($this->request->header("token-data")->getValue());
        $auth = service('authentication');
        $auth->check();
        $currentUser = $auth->user();

        if (!empty($token_data) && $token_data->email == $currentUser->email && !in_array("responsable", $currentUser->getRoles())) {

            //Check data
                $rules = [
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

            $restModel->createRestaurant($this->request->getPost('nameRestaurant'), $this->request->getPost('cityRestaurant'), 
            $this->request->getPost('streetRestaurant'), $this->request->getPost('postal_codeRestaurant'), $this->request->getPost('phoneRestaurant'), 
            $this->request->getPost('twitterRestaurant'), $this->request->getPost('instagramRestaurant'), $this->request->getPost('facebookRestaurant'));


            $check = $restModel->checkRestaurant($this->request->getPost('nameRestaurant'), $this->request->getPost('cityRestaurant'), 
            $this->request->getPost('streetRestaurant'), $this->request->getPost('postal_codeRestaurant'), $this->request->getPost('phoneRestaurant'));

            if(!empty($check)) {
                $files = $this->request->getFiles();
                $fileNames = "";
                if(!empty($files)) {
                    foreach($files['userfile'] as $img) {
                        if($img->isValid() && !$img->hasMoved()) {
                            $filepath = WRITEPATH . 'uploads/' . $img->store("restaurant/".$check['id']."/");
                            $Filetest = new File($filepath);
    
                        } else {
                            $response = [
                                'status' => 400,
                                "error" => true,
                                'messages' => 'Error with the files',
                            ];
                            return $this->respond($response);
                        }
                        $file = explode("restaurant/".$check['id']."/", $Filetest, 2);
                        $fileNames .= ",".$file[1];
                    }
        
                    $restModel->insertGallery($this->request->getPost('nameRestaurant'), $this->request->getPost('cityRestaurant'), 
                    $this->request->getPost('streetRestaurant'), $this->request->getPost('postal_codeRestaurant'), $this->request->getPost('phoneRestaurant'), $fileNames);
                }

                $authorize = $auth = service('authorization');

                $authorize->addUserToGroup($token_data->uid, "responsable");
                $restModel->addUserRestaurant($token_data->uid, $check['id']);

                $response = [
                    'status' => 200,
                    "error" => false,
                    'messages' => "Succesfully discharged",
                    'data' => [$fileNames]
                ];

            } else {
                $response = [
                    'status' => 500,
                    "error" => false,
                    'messages' => "There\'s been an error with the discharged process",
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
}
