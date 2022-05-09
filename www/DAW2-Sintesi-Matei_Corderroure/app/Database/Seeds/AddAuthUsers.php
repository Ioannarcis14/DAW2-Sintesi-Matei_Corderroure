<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;

class AddAuthUsers extends Seeder
{
    public function run()
    {
        //
        $authorize = $auth = service('authorization');
        $users = model(UserModel::class);

        $row = [
            'active'   => 1,
            'username' => 'admin',
            'password' => '1234',
            'name' => 'Josep',
            'surname' => 'Maria Flix',
            'email' => 'admin@me.local',
            'img_profile' => null,
            'phone' => 985848448,
            'city'  => 'Lleida',
            'street' => 'Carrer de les Palmes',
            'postal_code' => 25000
        ];

        $user = new User($row);
        $userId = $users->insert($user);
        $authorize->addUserToGroup($userId, 'administrador');

        $user->active = 1;
        $user->username = 'responsable';
        $user->password = '1234';
        $user->name = 'Maria';
        $user->surname = 'Angels Cerveró';
        $user->email = 'responsable@me.local';
        $user->img_profile = null;
        $user->phone = 985872129;
        $user->city = 'Barcelona';
        $user->street = 'Carrer Vall De Aran';
        $user->postal_code = 25940;


        $userId = $users->insert($user);
        $authorize->addUserToGroup($userId, 'responsable');

        $user->active = 1;
        $user->username = 'maitre';
        $user->password = '1234';
        $user->name = 'Marc';
        $user->surname = 'Iborra Mòdol';
        $user->email = 'maitre@me.local';
        $user->img_profile = null;
        $user->phone = 967248372;
        $user->city = 'Barcelona';
        $user->street = 'Carrer Vall De Aran';
        $user->postal_code = 25940;

        $userId = $users->insert($user);
        $authorize->addUserToGroup($userId, 'maitre');

        $user->active = 1;
        $user->username = 'cambrer';
        $user->password = '1234';
        $user->name = 'Joan';
        $user->surname = 'Corderroure ';
        $user->email = 'cambrer@me.local';
        $user->img_profile = 'Barcelona';
        $user->phone = 'Carrer de les Palmes';
        $user->city = 'Angels';
        $user->street = 'Cerveró';
        $user->postal_code = 'Carrer de les Palmes';

        $userId = $users->insert($user);
        $authorize->addUserToGroup($userId, 'cambrer');

        $user->active = 1;
        $user->username = 'usuari';
        $user->password = '1234';
        $user->name = 'Ioan';
        $user->surname = 'Matei';
        $user->email = 'user@me.local';
        $user->img_profile = 'Barcelona';
        $user->phone = 'Carrer de les Palmes';
        $user->city = 'Angels';
        $user->street = 'Cerveró';
        $user->postal_code = 'Carrer de les Palmes';

        $userId = $users->insert($user);
        $authorize->addUserToGroup($userId, 'usuari');
    }
}
