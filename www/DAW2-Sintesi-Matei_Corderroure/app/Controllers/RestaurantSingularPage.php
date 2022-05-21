<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\RestaurantModel;

class RestaurantSingularPage extends BaseController
{
    public function index()
    {
        helper('html');
        helper('url');
        $auth = service('authentication');
        if (! $auth->check() )
        {
            $data['logged'] = false;
        } else {
            $data['logged'] = true;
        }

        $Category = new CategoryModel();
        $list = $Category->getCategory();

        $data['list'] = $list;

        return view('layouts/layout_singular_rest', $data);
    }
}
