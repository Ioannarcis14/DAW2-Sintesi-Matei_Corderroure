<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RestaurantModel;
use SIENSIS\KpaCrud\Libraries\KpaCrud;


class ResponsableCrudController extends BaseController
{





    //Category

    public function getCategories()
    {
    }

    public function addCategory()
    {
    }

    public function editCategory()
    {
    }

    public function deleteCategory()
    {
    }

    //Dishes

    public function getDishes()
    {
    }

    public function addDish()
    {
    }

    public function editDish()
    {
    }

    public function deleteDish()
    {
    }

    public function assignSupplement()
    {
    }

    public function assignAllergen()
    {
    }

    //Supplements

    public function getSupplements()
    {
    }

    public function addSupplement()
    {
    }

    public function editSupplement()
    {
    }

    public function deleteSupplement()
    {
    }

    //Allergen

    public function getAllergens()
    {
    }


    //Restaurants

    /**
     * Gets and display the restaurants
     * 
     * It returns all the restaurants that are owned by the responsable user
     * 
     * URL: localhost:80/responsable/restaurants
     * 
     * * Mètode: GET
     */
    public function list_restaurants()
    {
        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("responsable", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        //Gets the data and paginates it

        $searchData = $this->request->getGet();

        if (isset($searchData) && isset($searchData['q'])) {
            $search = $searchData["q"];
        } else
            $search = "";

        $restModel = new RestaurantModel();

        $order = $searchData['order'] ?? '';
        $activePage = $searchData['page'] ?? 1;
        $act = $searchData['active'] ?? '';

        if ($search == '') {
            $paginateData = $restModel->restaurantListPagerResponsable(5, $order, ($act = $act != "a" ? "a" : ""), $currentUser->id);
        } else {
            $paginateData = $restModel->restaurantSearchResponsable($search, $order, ($act = $act != "a" ? "a" : ""), $currentUser->id)->paginate(5);
        }

        $data = [
            'page_title' => 'CI4 Pager & search filter',
            'title' => 'Manage restaurants',
            'restaurants' => $paginateData,
            'pager' => $restModel->pager,
            'search' => $search,
            'table' => $restModel,
            'activepage' => $activePage,
            'act' => $act,
        ];

        echo view('responsable/list_restaurants', $data);
    }

    /**
     * Returns a form to discharge restaurants
     * 
     * It returns the form to discharge the restaurants
     * 
     * URL: localhost:80/responsable/create
     * 
     * * Mètode: GET
     */
    public function addRestaurant()
    {
        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("responsable", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        return view('/responsable/restaurant/add_restaurant');

    }

        /**
     * Returns a form to update the restaurant
     * 
     * It returns the form to update the restaurant
     * 
     * URL: localhost:80/responsable/create
     * 
     * * Mètode: GET
     */
    public function updateRestaurant($id_restaurant)
    {
        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("responsable", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        $restModel = new RestaurantModel();

        $restaurant = $restModel->getSpecificRestaurantDischarged($id_restaurant);
        $data['restaurant'] = $restaurant;

        return view('/responsable/restaurant/update_restaurant', $data);

    }

    public function deleteRestaurant($id_restaurant)
    {
        //Check the identity of the user

        helper('html');
        $auth = service('authentication');

        if (!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();

        if (!in_array("responsable", $currentUser->getRoles())) {
            return redirect()->route('logout');
        }

        $restModel = new RestaurantModel();

        $restModel->deleteRestaurant($id_restaurant);

        return redirect()->route('responsable/restaurants');

    }
}
