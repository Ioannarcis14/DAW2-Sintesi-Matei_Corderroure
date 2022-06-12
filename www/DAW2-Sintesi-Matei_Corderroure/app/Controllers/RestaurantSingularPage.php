<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\RestaurantModel;

class RestaurantSingularPage extends BaseController
{
    public function index($id)
    {
        helper('html');
        helper('url');
        $auth = service('authentication');
        if (!$auth->check()) {
            $_SESSION['token'] = "";
            $data['logged'] = false;
        } else {
            $data['logged'] = true;
            $data['user'] = $auth->user();
            $data['groups'] = $auth->user()->getRoles();
        }


        $Category = new CategoryModel();
        $list = $Category->getCategory($id);

        $restaurantModel = new RestaurantModel();
        $restaurant = $restaurantModel->getSpecificRestaurantDischarged($id);

        $data['restaurant'] = $restaurant;

        $data['list'] = $list;

        $data['id'] = $id;

        return view('layouts/layout_singular_rest', $data);
    }
}
