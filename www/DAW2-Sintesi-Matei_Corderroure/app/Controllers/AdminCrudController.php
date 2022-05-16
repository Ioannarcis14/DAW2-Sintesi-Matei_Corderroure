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

    public function assignRoles(){
        $crud = new KpaCrud('listView');

    $crud->setTable('auth_groups_users');
    $crud->setPrimaryKey('group_id');
    $crud->setPrimaryKey('user_id');

    $crud->setRelation('group_id', 'auth_groups', 'id', 'name');
    $crud->setRelation('user_id', 'users', 'id', 'username');

    $crud->setColumns(['auth_groups__name', 'users__username', 'users__email']);

    $crud->setColumnsInfo([
        'auth_groups__name' => 'Rol',
        'users__username' => 'Usuari',
        'users__email' => 'eMail',
    ]);

    $data['output'] = $crud->render();

        return view('admin/manage_users', $data);

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

        $crud->addItemFunction('assign', 'fa fa-id-badge', array($this, 'myCustomPage'), "Assign roles");

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
                    "requiered",
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

    public function myCustomPage($obj)
    {
        $html = "<div class=\"container-lg p-4\">";
        $html .= "<form method='post' action='".base_url($this->request->getPath())."?". $this->request->getUri()->getQuery() ."'>";
        $html .= csrf_field()  ."<input type='hidden' name='test' value='ToSend'>";
        $html .= "<div class=\"bg-secondary p-2 text-white\">";
        $html .= "	<h1>Assign Group</h1>";
        $html .= "</div>";
        $html .= "	<div style=\"margin-top:20px\" class=\"border bg-light\">";
        $html .= "		<div class=\"d-grid\" style=\"margin-top:20px\">";
        $html .= "			<div class=\"p-2 \">	";
        $html .= "				<label>Username</label>	";
        $html .= "				<div class=\"form-control bg-light \" name=\"Username\">";
        $html .= $obj['username'];
        $html .= "				</div>";
        $html .= "			</div>";
        $html .= "";
        $html .= "			<div class=\"p-2 \">	";
        $html .= "				<label>Assign groups</label>";
        $html .= "                  <select class=\"form-select\" name=\"Group\" aria-label=\"Default select example\">";
        $html .= "			            <option value=\"6\" selected>Usuari</option>";
        $html .= "                      <option value=\"5\">Maitre</option>";
        $html .= "                      <option value=\"4\">Cambrer</option>";
        $html .= "                      <option value=\"3\">Cuiner</option>";
        $html .= "                      <option value=\"2\">Responsable</option>";
        $html .= "			        </select>";
        $html .= "			    </div>";
        $html .= "			</div>";
        $html .= "			";
        $html .= "		</div>";
        $html .= "	</div>";
        $html .= "<div class='pt-2'><input type='submit' value='Assign group'></div></form>";
        $html .= "</div>";


        // $html = view('view_route/view_name');

        return $html;
    }
    
    public function myCustomPagePost($obj)
    {
        // $obj contains info about register if you repeat querystring received in MyCustomPage
        $html ='<h1>Operation ok</h1>';
        /*
        Do something with this->request->getPost information
        */
        $username = $this->request->getPost('Username');
        $Group = $this->request->getPost('Group');

        dd($username);  

        return $html;
    }

}
