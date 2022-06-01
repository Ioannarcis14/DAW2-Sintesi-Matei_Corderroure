<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RestaurantModel;

class RestaurantPage extends BaseController
{
    public function index()
    {
        helper('html');
        $auth = service('authentication');
        if (! $auth->check() )
        {
            $_SESSION['token'] = "";
            $data['logged'] = false;
        } else {
            $data['logged'] = true;
            $data['user'] = $auth->user();
            $data['groups'] = $auth->user()->getRoles();
            
        }


        $RestaModel = new RestaurantModel();
        $list = $RestaModel->getRatedRestaurants();

        $data['list'] = $list;
        

        return view('layouts/layout_rest', $data);
    }
}
