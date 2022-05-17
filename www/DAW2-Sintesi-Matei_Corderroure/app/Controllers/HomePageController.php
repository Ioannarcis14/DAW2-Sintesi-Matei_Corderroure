<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\API\APIUserController;

class HomePageController extends BaseController
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
        return view('Home', $data);
    }

    public function login() {

    }

    public function logout() {
        
    }

}
