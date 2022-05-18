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
            $data['logged'] = false;
        } else {
            $data['logged'] = true;
        }

        $RestaModel = new RestaurantModel();
        $list = $RestaModel->getRatedRestaurants();

        $data['list'] = $list;

        return view('Restaurant', $data);
    }
}
