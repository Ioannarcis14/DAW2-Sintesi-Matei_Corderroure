<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MessagesModel;
use App\Models\RestaurantModel;
use App\Models\ThemeModel;
use App\Models\UserModel;
use Myth\Auth\Password;
use SIENSIS\KpaCrud\Libraries\KpaCrud;

class AdminCrudController extends BaseController
{


    /**
     * Gets and display the users
     * 
     * It returns all the users that are in the database to display them in a paginated page
     * 
     * URL: localhost:80/admin/users
     * 
     * * Mètode: GET
    */
    public function listUsers() {

        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if(!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if(in_array("administrador", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        //Gets the data and paginates it
        
        $searchData = $this->request->getGet();

        if (isset($searchData) && isset($searchData['q'])) {
            $search = $searchData["q"];
        } else
            $search = "";

        $userModel = new UserModel();

        $order = $searchData['order'] ?? '';
        $activePage = $searchData['page'] ?? 1;
        $act = $searchData['active'] ?? '';

        if ($search == '') {
            $paginateData = $userModel->userListPager(5,$order,($act = $act != "a" ? "a" : ""));
        } else {
            $paginateData = $userModel->userSearch($search,$order,($act = $act != "a" ? "a" : ""))->paginate(5);
        }

        $data = [
            'page_title' => 'CI4 Pager & search filter',
            'title' => 'Manage users',
            'users' => $paginateData,
            'pager' => $userModel->pager,
            'search' => $search,
            'table' => $userModel,
            'activepage' => $activePage,
            'act' => $act,
        ];

        echo view('admin/manage_users',$data);
    }

    /**
     * Gets and display the roles
     * 
     * It returns all the roles that are in the database to display them in a paginated page
     * 
     * URL: localhost:80/admin/roles
     * 
     * * Mètode: GET
    */
    public function listRoles() {

        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if(!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if(in_array("administrador", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        //Gets the data and paginates it

        $searchData = $this->request->getGet();

        if (isset($searchData) && isset($searchData['q'])) {
            $search = $searchData["q"];
        } else
            $search = "";

        $userModel = new UserModel();

        $order = $searchData['order'] ?? '';
        $activePage = $searchData['page'] ?? 1;
        $act = $searchData['active'] ?? '';

        if ($search == '') {
            $paginateData = $userModel->roleListPager(5,$order,($act = $act != "a" ? "a" : ""));
        } else {
            $paginateData = $userModel->roleSearch($search,$order,($act = $act != "a" ? "a" : ""))->paginate(6);
        }

        $data = [
            'page_title' => 'CI4 Pager & search filter',
            'title' => 'Manage roles',
            'roles' => $paginateData,
            'pager' => $userModel->pager,
            'search' => $search,
            'table' => $userModel,
            'activepage' => $activePage,
            'act' => $act,
        ];

        echo view('admin/manage_roles',$data);
    }


    /**
     * Gets and display the messages
     * 
     * It returns all the messages that are in the database to display them in a paginated page
     * 
     * URL: localhost:80/admin/messages
     * 
     * * Mètode: GET
    */
    public function listMessages() {

        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if(!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if(in_array("administrador", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        //Gets the data and paginates it

        $searchData = $this->request->getGet();

        if (isset($searchData) && isset($searchData['q'])) {
            $search = $searchData["q"];
        } else
            $search = "";

        $messageModel = new MessagesModel();

        $order = $searchData['order'] ?? '';
        $activePage = $searchData['page'] ?? 1;
        $act = $searchData['active'] ?? '';

        if ($search == '') {
            $paginateData = $messageModel->messageListPager(5,$order,($act = $act != "a" ? "a" : ""));
        } else {
            $paginateData = $messageModel->messageSearch($search,$order,($act = $act != "a" ? "a" : ""))->paginate(6);
        }

        $data = [
            'page_title' => 'CI4 Pager & search filter',
            'title' => 'Manage messages',
            'messages' => $paginateData,
            'pager' => $messageModel->pager,
            'search' => $search,
            'table' => $messageModel,
            'activepage' => $activePage,
            'act' => $act,
        ];

        echo view('admin/see_messages',$data);
    }

    /**
     * Gets and display the themes
     * 
     * It returns all the themes that are in the database to display them in a paginated page
     * 
     * URL: localhost:80/admin/themes
     * 
     * * Mètode: GET
    */
    public function listThemes() {

        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if(!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if(in_array("administrador", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        //Gets the data and paginates it

        $searchData = $this->request->getGet();

        if (isset($searchData) && isset($searchData['q'])) {
            $search = $searchData["q"];
        } else
            $search = "";

        $themeModel = new ThemeModel();

        $order = $searchData['order'] ?? '';
        $activePage = $searchData['page'] ?? 1;
        $act = $searchData['active'] ?? '';

        if ($search == '') {
            $paginateData = $themeModel->themeListPager(5,$order,($act = $act != "a" ? "a" : ""));
        } else {
            $paginateData = $themeModel->themeSearch($search,$order,($act = $act != "a" ? "a" : ""))->paginate(6);
        }

        $data = [
            'page_title' => 'CI4 Pager & search filter',
            'title' => 'Manage themes',
            'theme' => $paginateData,
            'pager' => $themeModel->pager,
            'search' => $search,
            'table' => $themeModel,
            'activepage' => $activePage,
            'act' => $act,
        ];

        echo view('admin/manage_themes',$data);
    }


    /**
     * Gets and display the restaurants
     * 
     * It returns all the restaurants that are in the database that aren't discharged to display them in a paginated page
     * 
     * URL: localhost:80/admin/discharge
     * 
     * * Mètode: GET
    */
    public function listRestaurants() {

        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if(!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if(in_array("administrador", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        //Gets the data and paginates it

        $searchData = $this->request->getGet();

        if (isset($searchData) && isset($searchData['q'])) {
            $search = $searchData["q"];
        } else
            $search = "";

        $restaurantModel = new RestaurantModel();

        $order = $searchData['order'] ?? '';
        $activePage = $searchData['page'] ?? 1;
        $act = $searchData['active'] ?? '';

        if ($search == '') {
            $paginateData = $restaurantModel->restaurantListPager(5,$order,($act = $act != "a" ? "a" : ""));
        } else {
            $paginateData = $restaurantModel->restaurantSearch($search,$order,($act = $act != "a" ? "a" : ""))->paginate(5);
        }

        $data = [
            'page_title' => 'CI4 Pager & search filter',
            'title' => 'Manage users',
            'restaurants' => $paginateData,
            'pager' => $restaurantModel->pager,
            'search' => $search,
            'table' => $restaurantModel,
            'activepage' => $activePage,
            'act' => $act,
        ];

        echo view('admin/discharge_restaurants',$data);
    }


    public function createUser() {

    }

    public function updateUser() {
        
    }

    public function assignRole() {

    }

    

    public function createRole() {

    }

    public function updateRole() {
        
    }

   

    public function sendMessage() {

    }



    public function hashNewPassword($postData)
    {
        $postData['data_password_hash'] = Password::hash($postData['data_password_hash']);
        $postData['active'] = 1;
        return $postData; // if return null, edit process will be cancelled
    }

    public function hashEditPassword($postData)
    {
        if ($postData['data_password_hash'] != $postData['olddata_password_hash']) {
            // field has a new value. You new to generate new password
            $postData['data_password_hash'] = password_hash($postData['data_password_hash'], PASSWORD_DEFAULT);
        } // else field not changed, you can update with the same value
        return $postData;  // if return null, edit process will be cancelled
    }

    public function seeMessages()
    {
        $crud = new KpaCrud('listView');

        $crud->setTable('messages');
        $crud->setPrimaryKey('id_user');
        $crud->setPrimaryKey('receiver');

        $crud->setColumns(['id_user', 'theme', 'message']);
        $crud->addWhere('receiver='.null);

        $crud->setColumnsInfo([
            'auth_groups__name' => 'Group',
            'users__username' => 'UserName',
            'users__name' => 'Name',
            'users__email' => 'eMail',
        ]);

        $crud->setConfig([
            "recycled_button" => false,
            "exportXLS" => false,
            "print" => false,
            "multidelete" => false,
            "deletepermanent" => false,

        ]);

        $data['output'] = $crud->render();

        return view('admin/see_messages', $data);
    }

    public function assignRoles()
    {
        $crud = new KpaCrud('listView');

        $crud->setTable('auth_groups_users');
        $crud->setPrimaryKey('group_id');
        $crud->setPrimaryKey('user_id');

        $crud->setRelation('group_id', 'auth_groups', 'id', 'name');
        $crud->setRelation('user_id', 'users', 'id', 'username');
        $crud->addWhere('users.deleted_at='.null);

        $crud->setColumns(['auth_groups__name', 'users__username', 'users__name', 'users__email']);

        $crud->setColumnsInfo([
            'auth_groups__name' => 'Group',
            'users__username' => 'UserName',
            'users__name' => 'Name',
            'users__email' => 'eMail',
        ]);

        $crud->setConfig([
            "recycled_button" => false,
            "exportXLS" => false,
            "print" => false,
            "multidelete" => false,
            "deletepermanent" => false,
            "add_button" => true,
            "removable" => true
        ]);

        $data['output'] = $crud->render();

        return view('admin/assign_roles', $data);
    }

    public function manageRole() 
    {
        $crud = new KpaCrud();
        $crud->setTable('auth_groups');
        $crud->setPrimaryKey('id');

        $crud->setColumns(['id', 'name', 'description']);

        $crud->setConfig([
            "recycled_button" => false,
            "exportXLS" => false,
            "print" => false,
            "multidelete" => false,
            "deletepermanent" => false,
        ]);

        $data['output'] = $crud->render();

        return view('admin/manage_roles', $data);
    }

    public function manageThemes() 
    {
        $crud = new KpaCrud();
        $crud->setTable('theme');
        $crud->setPrimaryKey('name');

        $crud->setColumns(['name']);

        $data['output'] = $crud->render();

        return view('admin/manage_themes', $data);
    }

    public function dischargeRestaurant() 
    {
        $crud = new KpaCrud();
        $crud->setTable('restaurant');
        $crud->setPrimaryKey('id');

        $crud->setColumns(['id', 'name', 'city']);

        $crud->addWhere('discharged='.null);

        $data['output'] = $crud->render();

        return view('admin/discharge_restaurants', $data);
    }

    public function manageUser()
    {
        $crud = new KpaCrud();
        $crud->setTable('users');
        $crud->setPrimaryKey('id');

        $crud->setConfig([
            "recycled_button" => false,
            "exportXLS" => false,
            "print" => false,
            "multidelete" => false,

        ]);
        $crud->setColumns(['id', 'email', 'username', 'phone']);
        $crud->addWhere('deleted_at='.null);

        $crud->addPostAddCallBack(array($this, 'hashNewPassword'));
        $crud->addPostEditCallBack(array($this, 'hashEditPassword'));

        $crud->setColumnsInfo([
            'id' => ['name' => 'Code'],
            'email' => [
                'name' => 'Email',
                'html_atts' => [
                    'required',
                    'placeholder="Introduce the email of the user"'
                ],
                'type' => KpaCrud::EMAIL_FIELD_TYPE
            ],
            'username' => [
                'name' => 'Username',
                'html_atts' => [
                    "required",
                    "placeholder=\"Introduce the username\""
                ],
            ],
            'password_hash' => [
                'type' => KpaCrud::PASSWORD_FIELD_TYPE,
                'name' => 'Password',
                'html_atts' => [
                    "requiered",
                ]
            ],

            'img_profile' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
                'activate_hash' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
                'reset_hash' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
                'reset_at' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
                'reset_expires' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
                'status' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
                'status_message' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
                'active' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
                'created_at' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
                'updated_at' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
            'deleted_at' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
            'force_pass_reset' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],

        ]);


        $data['output'] = $crud->render();

        return view('admin/manage_users', $data);
    }
}
