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
            $_SESSION['token'] = "";
            $data['logged'] = false;
        } else {
            $data['logged'] = true;
            $data['user'] = $auth->user();
            $data['groups'] = $auth->user()->getRoles();
        }


        

        
        return view('layouts/layout_home', $data);
    }
}
