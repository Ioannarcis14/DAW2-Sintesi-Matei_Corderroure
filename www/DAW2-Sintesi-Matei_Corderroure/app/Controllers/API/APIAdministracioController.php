<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;


class APIAdministracioController extends ResourceController
{    
    protected $helpers = ['auth'];
    
    
    public function testAuth() {
        return view('/API/APITestAuth');
    }

    public function testUser() {
        return view('/API/APITestUser');
    }

    public function testAdmin() {
        return view('/API/APITestAdmin');
    }

    public function testResponsable() {
        return view('/API/APITestResponsable');
    }

    public function testStaff() {
        return view('/API/APITestStaff');
    }

}
