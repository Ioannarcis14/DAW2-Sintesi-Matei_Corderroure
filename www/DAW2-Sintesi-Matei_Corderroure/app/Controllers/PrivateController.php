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

        return view('/private/private', $data);
    }

    public function changeData() {
        $auth = service('authentication');

        if(!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();


        $data['logged'] = true;
        $data['user'] = $currentUser;
        return view('/private/changeData', $data);

    }

    public function changeDataPost() {

    }

    public function changePass() {
        $auth = service('authentication');

        if(!$auth->check()) {
            return redirect()->route('login');
        }

        $currentUser = $auth->user();


        $data['logged'] = true;
        $data['user'] = $currentUser;

        return view('/private/changePass', $data);

    }
}
