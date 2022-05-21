<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;


class APIAdministracioController extends ResourceController
{    
    protected $helpers = ['auth'];
    
    
    public function testApi() {

        return view('/APITest');
    }


}
