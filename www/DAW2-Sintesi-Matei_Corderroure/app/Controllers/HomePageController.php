<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HomePageController extends BaseController
{
    public function index()
    {
        return view('Home');
    }

    public function login() {

    }

    public function logout() {
        
    }

}
