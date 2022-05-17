<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HomePageController extends BaseController
{
    public function index()
    {
        helper('html');
        return view('Home');
    }

    public function login() {

    }

    public function logout() {
        
    }

}
