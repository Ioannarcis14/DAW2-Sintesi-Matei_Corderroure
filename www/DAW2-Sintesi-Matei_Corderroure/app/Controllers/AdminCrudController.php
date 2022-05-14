<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\User as EntUser;
use SIENSIS\KpaCrud\Libraries\KpaCrud;

class AdminCrudController extends BaseController
{
    public function hashNewPassword($postData)
    {
        $pass = new EntUser();
        $newPass = $pass->setPassword($postData['data_password_hash']);
        return $newPass; // if return null, edit process will be cancelled
    }

    public function view() {

        $crud = new KpaCrud();
        $crud->setTable('users');
        $crud->setPrimaryKey('id');

        $crud->setConfig([
            "recycled_button" => false,
            "exportXLS" => false,
            "print" => false,
            "multidelete" => false,
            "deletepermanent" => false,

        ]);
        $crud->setColumns(['id','email','username','phone']);
        
        $crud->addPostAddCallBack(array($this, 'hashNewPassword'));
        $crud->addPostEditCallBack(array($this, 'hashEditPassword'));

        $crud->setColumnsInfo([
            'id' => ['name' => 'Code'],
            'email' => [
                'name' => 'Email',
                'html_atts' => [
                    'required',
                    'placeholder="Introduce the email of the user"'
                ],
                'type' => KpaCrud::EMAIL_FIELD_TYPE
            ],
            'username' => [
                'name' => 'Username',
                'html_atts' => [
                    "required",
                    "placeholder=\"Introduce the username\""
                ],
            ],
            'password_hash' => [
                'type' => KpaCrud::PASSWORD_FIELD_TYPE,
                'name'=> 'Password',
                'html_atts' => [
                ]
            ],

            'activate_hash' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
            'reset_hash' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
            'reset_at' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
            'reset_expires' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
            'status' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
            'status_message' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
            'active' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
            'created_at' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
            'updated_at' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
            'deleted_at' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
            'force_pass_reset' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],

        ]);


        $data['output'] = $crud->render();

        return view('admin/manage_users', $data);

    }
}
