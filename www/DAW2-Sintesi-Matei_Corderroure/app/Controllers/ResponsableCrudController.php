<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use SIENSIS\KpaCrud\Libraries\KpaCrud;


class ResponsableCrudController extends BaseController
{
    public function view()
    {
        $auth = service('authentication');
        $userId = $auth->id();

        $crud = new KpaCrud();
        $crud->setTable('restaurant');
        $crud->setPrimaryKey('id');

        $crud->setConfig([
            "recycled_button" => false,
            "exportXLS" => false,
            "print" => false,
            "multidelete" => false,
            "deletepermanent" => false,

        ]);
        $crud->setColumns(['id','name','city']);
        
        $crud->addPostAddCallBack(array($this, 'hashNewPassword'));
        $crud->addPostEditCallBack(array($this, 'hashEditPassword'));

        $crud->addItemFunction('assign', 'fa fa-id-badge', array($this, 'myCustomPage'), "Enter restaurant");

    

        $data['output'] = $crud->render();

        return view('responsable/manage_restaurants', $data);

    }
}
