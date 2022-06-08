<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\User;
use App\Models\MessagesModel;
use App\Models\RestaurantModel;
use App\Models\RoleModel;
use App\Models\ThemeModel;
use App\Models\UserModel;
use Myth\Auth\Password;

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
    public function listUsers()
    {

        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("administrador", $currentUser->getRoles())) {
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
            $paginateData = $userModel->userListPager(5, $order, ($act = $act != "a" ? "a" : ""));
        } else {
            $paginateData = $userModel->userSearch($search, $order, ($act = $act != "a" ? "a" : ""))->paginate(5);
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

        echo view('admin/manage_users', $data);
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
    public function listRoles()
    {

        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("administrador", $currentUser->getRoles())) {
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
            $paginateData = $userModel->roleListPager(5, $order, ($act = $act != "a" ? "a" : ""));
        } else {
            $paginateData = $userModel->roleSearch($search, $order, ($act = $act != "a" ? "a" : ""))->paginate(6);
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

        echo view('admin/manage_roles', $data);
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
    public function listMessages()
    {

        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("administrador", $currentUser->getRoles())) {
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
            $paginateData = $messageModel->messageListPager(5, $order, ($act = $act != "a" ? "a" : ""));
        } else {
            $paginateData = $messageModel->messageSearch($search, $order, ($act = $act != "a" ? "a" : ""))->paginate(6);
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

        echo view('admin/see_messages', $data);
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
    public function listThemes()
    {

        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("administrador", $currentUser->getRoles())) {
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
            $paginateData = $themeModel->themeListPager(5, $order, ($act = $act != "a" ? "a" : ""));
        } else {
            $paginateData = $themeModel->themeSearch($search, $order, ($act = $act != "a" ? "a" : ""))->paginate(6);
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

        echo view('admin/manage_themes', $data);
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
    public function listRestaurants()
    {

        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("administrador", $currentUser->getRoles())) {
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
            $paginateData = $restaurantModel->restaurantListPager(5, $order, ($act = $act != "a" ? "a" : ""));
        } else {
            $paginateData = $restaurantModel->restaurantSearch($search, $order, ($act = $act != "a" ? "a" : ""))->paginate(5);
        }

        $data = [
            'page_title' => 'CI4 Pager & search filter',
            'title' => 'Manage restaurants',
            'restaurants' => $paginateData,
            'pager' => $restaurantModel->pager,
            'search' => $search,
            'table' => $restaurantModel,
            'activepage' => $activePage,
            'act' => $act,
        ];

        echo view('admin/discharge_restaurants', $data);
    }

    /**
     * 
     */
    public function createUser()
    {
        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("administrador", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        //Returns the view

        return view('/admin/users/create_user');
    }


    /**
     * 
     */
    public function updateUser($id)
    {
        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("administrador", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        //Returns the view with the data of the user 
        $userModel = new UserModel();

        $user = $userModel->getUserByID($id);
        $data['user'] = $user;

        return view('/admin/users/update_user', $data);
    }

    /**
     * 
     */
    public function deleteUser($id)
    {
        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("administrador", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        //Returns the view with the data of the user 

        $userModel = new UserModel();

        $userModel->deleteUser($id);

        return redirect()->route('admin/users');
    }

    /**
     * Assigns a role to the user
     */
    public function assignRole($id)
    {
        //Check the identity of the user
        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("administrador", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        $userModel = new UserModel();
        $user = $userModel->getUserByID($id);

        $data['roles'] = $userModel->getMissingRoles($id);
        $data['user'] = $user;

        return view('/admin/users/assign_roles', $data);
    }

    /**
     * 
     */
    public function removeRole($id)
    {        
        //Check the identity of the user
        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("administrador", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        $userModel = new UserModel();
        $user = $userModel->getUserByID($id);

        $data['roles'] = $userModel->getRoles($id);
        $data['user'] = $user;

        return view('/admin/users/remove_roles', $data);

    }

    /**
     * 
     */
    public function createRole()
    {
        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("administrador", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        return view('/admin/roles/create_role');
    }

    /**
     * 
     */
    public function updateRole($id)
    {
        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("administrador", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        $roleModel = new roleModel();

        $role = $roleModel->getRoleByID($id);
        $data['role'] = $role;

        return view('/admin/roles/update_role', $data);
    }

    /**
     * 
     */
    public function deleteRole($id)
    {
        //Check the identity of the user
        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("administrador", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        $roleModel = new RoleModel();
        $roleModel->deleteRole($id);

        return redirect()->route('admin/roles');

    }

    /**
     * 
     */
    public function createTheme()
    {
        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("administrador", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        return view('/admin/roles/create_role');
    }

    /**
     * 
     */
    public function updateTheme($name)
    {
        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("administrador", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        $roleModel = new roleModel();

        $role = $roleModel->getRoleByID($name);
        $data['role'] = $role;

        return view('/admin/roles/update_role', $data);
    }

    /**
     * 
     */
    public function deleteTheme($name)
    {
        //Check the identity of the user
        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("administrador", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        $roleModel = new RoleModel();
        $roleModel->deleteRole($name);

        return redirect()->route('admin/roles');

    }
    

    /**
     * 
     */
    public function sendMessage()
    {
    }

    /**
     * 
     */
    public function dischargeRestaurants($id) {

    }

}
