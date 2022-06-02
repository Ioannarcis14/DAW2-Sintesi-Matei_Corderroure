<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel as NoAuthUser;

class PrivateController extends BaseController
{
    public function view()
    {
        helper('html');
        $auth = service('authentication');

        if(!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();


        $data['logged'] = true;
        $data['user'] = $currentUser;
        $data['groups'] = $currentUser->getRoles();

        return view('/private/private', $data);
    }

    public function dischargeRestaurant()
    {
        helper('html');
        $auth = service('authentication');

        if(!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();


        $data['logged'] = true;
        $data['user'] = $currentUser;
        $data['groups'] = $currentUser->getRoles();

        return view('/private/discharge', $data);
    }

    public function contactAdmin()
    {
        helper('html');
        $auth = service('authentication');

        if(!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();


        $data['logged'] = true;
        $data['user'] = $currentUser;
        $data['groups'] = $currentUser->getRoles();

        return view('/private/contact', $data);
    }

    public function changeData() 
    {
        $auth = service('authentication');

        if(!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();


        $data['logged'] = true;
        $data['user'] = $currentUser;
        $data['groups'] = $currentUser->getRoles();

        return view('/private/changeData', $data);

    }
}
