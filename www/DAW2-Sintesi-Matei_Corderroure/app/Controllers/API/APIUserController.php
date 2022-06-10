<?php

namespace App\Controllers\API;

use App\Models\MessagesModel;
use App\Models\RestaurantModel;
use App\Models\RoleModel;
use CodeIgniter\RESTful\ResourceController;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Entities\User;
use CodeIgniter\Files\File;
use App\Models\UserModel as NoAuthUser;
use App\Models\UserRestaurantModel;
use App\Models\ValorationsModel;
use Myth\Auth\Config\Auth as AuthConfig;

use \Firebase\JWT\Key;
use \Firebase\JWT\JWT;

class APIUserController extends ResourceController
{

    /**
     * Changes the password of the user
     * 
     * When the user changes the password using the function at the profile page, it will retrieve the token and the password and confirmation password
     * 
     * URL: localhost:80/api/users/changePass
     * 
     * * Mètode: POST
     * 
     * Parameters introduced by the User (sended by JSON or a form-data):
     * 
     * * $email
     * 
     * The email of the user introducing the new password
     * * $newPass
     * 
     * The new password that the user wants to use
     * 
     * * $newPassConfirm
     * 
     * The repetition of the new password to ensure that the user remembers the password
     * @return mixed It returns a message indicating if the password has been changed or an error has occurred
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
        $userModel = new NoAuthUser();

        if (!empty($token_data) && !empty($userModel->getUserByMailOrUsername($token_data->email))) {
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
            $data = $users->updateUser($token_data->uid, $this->request->getPost(), $file);

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
     * Create a Role
     * 
     */
    public function createRole()
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
                'roleName'     => 'required',
                'roleDescription' => 'required',
            ];

            if (!$this->validate($rules)) {
                $response = [
                    'status' => 404,
                    "error" => true,
                    'messages' => "Error with the fields"
                ];
                return $this->respond($response);
            }

            $roleName = $this->request->getVar('roleName');
            $roleDescription = $this->request->getVar('roleDescription');

            $authorize = $auth = service('authorization');
            $id = $authorize->createGroup($roleName, $roleDescription);
            $group = $authorize->group($id);

            if (empty($group)) {
                $response = [
                    'status' => 500,
                    "error" => true,
                    'messages' => "Failed to create the group"
                ];
            } else {
                $response = [
                    'status' => 200,
                    "error" => false,
                    'messages' => "Group created successfully"
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
     * Updates a role
     * 
     */
    public function updateRole()
    {
        helper('form');
        helper('html');

        $token_data = json_decode($this->request->header("token-data")->getValue());
        $auth = service('authentication');
        $auth->check();
        $currentUser = $auth->user();

        if (!empty($token_data) && $token_data->email == $currentUser->email && in_array("administrador", $currentUser->getRoles())) {

            $rules = [
                'id_role'     => 'required',
            ];

            if (!$this->validate($rules)) {
                $response = [
                    'status' => 500,
                    "error" => true,
                    'messages' => "ID role not found"
                ];
                return $this->respond($response);
            }

            $id_role = $this->request->getVar('id_role');
            $roleName = $this->request->getVar('roleName');
            $roleDescription = $this->request->getVar('roleDescription');

            $authorize = $auth = service('authorization');
            $authorize->updateGroup($id_role, $roleName, $roleDescription);
            $group = $authorize->group($id_role);

            if ($group->name != $roleName && $group->description != $roleDescription) {
                $response = [
                    'status' => 500,
                    "error" => true,
                    'messages' => "Failed to update the group",
                    'data' => []
                ];
            } else {
                $response = [
                    'status' => 200,
                    "error" => false,
                    'messages' => "Group updated succefully"
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
     * Assigns a role to a user
     * 
     */
    public function assignRoleUser()
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
                'id_role'     => 'required',
                'id_user' => 'required',
            ];

            if (!$this->validate($rules)) {
                $response = [
                    'status' => 404,
                    "error" => true,
                    'messages' => "Error with the fields"
                ];
                return $this->respond($response);
            }

            $id_Role = $this->request->getVar('id_role');
            $id_User = $this->request->getVar('id_user');

            $roleModel = new RoleModel();

            $check = $roleModel->checkRole($id_Role);

            if (empty($check)) {
                $response = [
                    'status' => 404,
                    "error" => true,
                    'messages' => "This role doesn't exist"
                ];
            } else {
                $authorize = $auth = service('authorization');
                $authorize->addUserToGroup($id_User, $id_Role);

                if (!$authorize->inGroup($id_Role, $id_User)) {
                    $response = [
                        'status' => 500,
                        "error" => true,
                        'messages' => "Failed to assign the group"
                    ];
                } else {
                    $response = [
                        'status' => 200,
                        "error" => false,
                        'messages' => "Succesfully assign to the group"
                    ];
                }
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
     * Deassigns a role that a user has
     * 
     */
    public function removeRoleUser()
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
                'id_role'     => 'required',
                'id_user' => 'required',
            ];

            if (!$this->validate($rules)) {
                $response = [
                    'status' => 404,
                    "error" => true,
                    'messages' => "Error with the fields"
                ];
                return $this->respond($response);
            }

            $id_Role = $this->request->getVar('id_role');
            $id_User = $this->request->getVar('id_user');

            $roleModel = new RoleModel();

            $check = $roleModel->checkRole($id_Role);

            if (empty($check)) {
                $response = [
                    'status' => 404,
                    "error" => true,
                    'messages' => "This role doesn't exist"
                ];
            } else {
                $authorize = $auth = service('authorization');
                $authorize->removeUserFromGroup($id_User, $id_Role);

                if ($authorize->inGroup($id_Role, $id_User)) {
                    $response = [
                        'status' => 500,
                        "error" => true,
                        'messages' => "Failed to remove from the group"
                    ];
                } else {
                    $response = [
                        'status' => 200,
                        "error" => false,
                        'messages' => "Succesfully removed from the group"
                    ];
                }
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
        $restaurantCheck = new RestaurantModel();
        $valModel = new ValorationsModel();
        $userModel = new NoAuthUser();

        if (!empty($token_data) && !empty($userModel->getUserByMailOrUsername($token_data->email)) && !in_array("responsable", json_decode(json_encode($token_data->group), true))) {

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
                $valModel->createValoration($id_restaurant, $token_data->uid, $this->request->getVar('rating'), $this->request->getVar('observation'));

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
                "error" => true,
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
        $userModel = new NoAuthUser();

        if (!empty($token_data) && !empty($userModel->getUserByMailOrUsername($token_data->email))) {

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

            $msgModel->createMessage($token_data->uid, $this->request->getVar('theme'), $this->request->getVar('commentary'));

            if (!empty($msgModel->checkMessage($token_data->uid, null, $this->request->getVar('theme')))) {
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
            $restUserModel = new UserRestaurantModel();

            $restModel->createRestaurant(
                $this->request->getPost('nameRestaurant'),
                $this->request->getPost('cityRestaurant'),
                $this->request->getPost('streetRestaurant'),
                $this->request->getPost('postal_codeRestaurant'),
                $this->request->getPost('phoneRestaurant'),
                $this->request->getPost('twitterRestaurant'),
                $this->request->getPost('instagramRestaurant'),
                $this->request->getPost('facebookRestaurant')
            );


            $check = $restModel->checkRestaurant(
                $this->request->getPost('nameRestaurant'),
                $this->request->getPost('cityRestaurant'),
                $this->request->getPost('streetRestaurant'),
                $this->request->getPost('postal_codeRestaurant'),
                $this->request->getPost('phoneRestaurant')
            );

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
                        $this->request->getPost('nameRestaurant'),
                        $this->request->getPost('cityRestaurant'),
                        $this->request->getPost('streetRestaurant'),
                        $this->request->getPost('postal_codeRestaurant'),
                        $this->request->getPost('phoneRestaurant'),
                        $fileNames
                    );
                }

                $authorize = $auth = service('authorization');

                $authorize->addUserToGroup($token_data->uid, "responsable");
                $restUserModel->addUserRestaurant($token_data->uid, $check['id']);
                
                $check = $restUserModel->checkUserRestaurant($token_data->uid, $check['id']);

                if(!empty($check)) {
                    $response = [
                        'status' => 200,
                        "error" => false,
                        'messages' => "Succesfully discharged",
                        'data' => []
                    ];
                } else {
                    $response = [
                        'status' => 500,
                        "error" => true,
                        'messages' => "There\'s been an error adding the restaurant",
                        'data' => []
                    ];
                }
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

    public function sendMessage() {
        helper('form');
        helper('html');

        $token_data = json_decode($this->request->header("token-data")->getValue());
        $auth = service('authentication');
        $auth->check();
        $currentUser = $auth->user();

        if (!empty($token_data) && $token_data->email == $currentUser->email && in_array("administrador", $currentUser->getRoles())) {

            $rules = [
                'receiver'     => 'required',
                'theme'     => 'required',
                'message'     => 'required',
            ];

            if (!$this->validate($rules)) {
                $response = [
                    'status' => 400,
                    "error" => true,
                    'messages' => "Error with the general fields"
                ];
                return $this->respond($response);
            }

            $receiver = $this->request->getVar('receiver');
            $theme = $this->request->getVar('theme');
            $message = $this->request->getVar('message');

            $messageModel = new MessagesModel();
            $messageModel->createMessageAdmin($token_data->uid, $receiver, $theme, $message);
            $check = $messageModel->checkMessage($token_data->uid, $receiver, $theme);

            if (empty($check)) {
                $response = [
                    'status' => 500,
                    "error" => true,
                    'messages' => "Failed to send the message",
                    'data' => []
                ];
            } else {
                $response = [
                    'status' => 200,
                    "error" => false,
                    'messages' => "Message sended successfully"
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
