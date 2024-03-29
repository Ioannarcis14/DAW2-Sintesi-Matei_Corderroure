<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ThemeModel;
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

        if(in_array("responsable", $currentUser->getRoles())) {
            return redirect()->route('home');
        }

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

        $themeModel = new ThemeModel();

        $list = $themeModel->getAllThemes();

        $data['themes'] = $list;
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
