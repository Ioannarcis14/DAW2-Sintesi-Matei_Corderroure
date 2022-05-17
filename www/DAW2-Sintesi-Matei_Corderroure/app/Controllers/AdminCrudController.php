<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Myth\Auth\Password;
use SIENSIS\KpaCrud\Libraries\KpaCrud;

class AdminCrudController extends BaseController
{
    public function hashNewPassword($postData)
    {
        $postData['data_password_hash'] = Password::hash($postData['data_password_hash']);
        return $postData; // if return null, edit process will be cancelled
    }

    public function hashEditPassword($postData)
    {
        if ($postData['data_password_hash'] != $postData['olddata_password_hash']) {
            // field has a new value. You new to generate new password
            $postData['data_password_hash'] = password_hash($postData['data_password_hash'], PASSWORD_DEFAULT);
        } // else field not changed, you can update with the same value
        return $postData;  // if return null, edit process will be cancelled
    }

    public function seeMessages()
    {
        $crud = new KpaCrud('listView');

        $crud->setTable('messages');
        $crud->setPrimaryKey('id_user');
        $crud->setPrimaryKey('id_restaurant');

        $crud->setRelation('group_id', 'auth_groups', 'id', 'name');
        $crud->setRelation('user_id', 'users', 'id', 'username');

        $crud->setColumns(['auth_groups__name', 'users__username', 'users__name', 'users__email']);

        $crud->setColumnsInfo([
            'auth_groups__name' => 'Group',
            'users__username' => 'UserName',
            'users__name' => 'Name',
            'users__email' => 'eMail',
        ]);

        $crud->setConfig([
            "recycled_button" => false,
            "exportXLS" => false,
            "print" => false,
            "multidelete" => false,
            "deletepermanent" => false,

        ]);

        $data['output'] = $crud->render();

        return view('admin/assign_roles', $data);
    }

    public function assignRoles()
    {
        $crud = new KpaCrud('listView');

        $crud->setTable('auth_groups_users');
        $crud->setPrimaryKey('group_id');
        $crud->setPrimaryKey('user_id');

        $crud->setRelation('group_id', 'auth_groups', 'id', 'name');
        $crud->setRelation('user_id', 'users', 'id', 'username');

        $crud->setColumns(['auth_groups__name', 'users__username', 'users__name', 'users__email']);

        $crud->setColumnsInfo([
            'auth_groups__name' => 'Group',
            'users__username' => 'UserName',
            'users__name' => 'Name',
            'users__email' => 'eMail',
        ]);

        $crud->setConfig([
            "recycled_button" => false,
            "exportXLS" => false,
            "print" => false,
            "multidelete" => false,
            "deletepermanent" => false,

        ]);

        $data['output'] = $crud->render();

        return view('admin/assign_roles', $data);
    }

    public function manageRole() 
    {
        $crud = new KpaCrud();
        $crud->setTable('auth_groups');
        $crud->setPrimaryKey('id');

    }

    public function dischargeRestaurant() 
    {
        $crud = new KpaCrud();
        $crud->setTable('restaurants');
        $crud->setPrimaryKey('id');

    }

    public function manageUser()
    {
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
        $crud->setColumns(['id', 'email', 'username', 'phone']);

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
                'name' => 'Password',
                'html_atts' => [
                    "requiered",
                ]
            ],

            'Img_profile' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
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
