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
            'password' => '1234',
            'email' => 'admin@me.local',
            'username' => 'default',
            'name' => 'Josep M',
            'surname' => 'FR',
            'dni' => '12345678A',
            'ciutat' => 'Lleida',
            'carrer' => 'Carrer de les Palmes',
        ];

        $user = new User($row);
        $userId = $users->insert($user);
        $authorize->addUserToGroup($userId, 'administrador');
        $authorize->addUserToGroup($userId, 'usuari');
       
        $user->email = 'user@me.local';
        $user->active = 2;
        $user->username = 'idk';
        $user->name = 'Angels';
        $user->surname = 'Cerveró';
        $user->dni = '12345678A';
        $user->ciutat = 'Barcelona';
        $user->carrer = 'Carrer de les Palmes';

        $userId = $users->insert($user);

        $authorize->addUserToGroup($userId, 'responsable');
        $authorize->addUserToGroup($userId, 'usuari');

        $user->email = 'convidat@me.local';
        $user->active = 1;
        $user->username = 'idkkk';
        $user->name = 'Andreu';
        $user->surname = 'Ribes';
        $user->dni = '12345678A';
        $user->ciutat = 'Barcelona';
        $user->carrer = 'Carrer de les Palmes';
        
        $userId = $users->insert($user);
        $authorize->addUserToGroup($userId, 'maitre');
        $authorize->addUserToGroup($userId, 'usuari');

        $user->email = 'cambrer@me.local';
        $user->active = 1;
        $user->username = 'idkk';
        $user->name = 'Joan';
        $user->surname = 'Ribes';
        $user->dni = '12345678A';
        $user->ciutat = 'Barcelona';
        $user->carrer = 'Carrer de les Palmes';

        $userId = $users->insert($user);
        $authorize->addUserToGroup($userId, 'cambrer');
        $authorize->addUserToGroup($userId, 'usuari');

        $user->email = 'convida23t@me.local';
        $user->active = 1;
        $user->username = 'odddddd';
        $user->name = 'Ricardo';
        $user->surname = 'Ribes';
        $user->dni = '12345678A';
        $user->ciutat = 'Barcelona';
        $user->carrer = 'Carrer de les Palmes';
       
        $userId = $users->insert($user);
        $authorize->addUserToGroup($userId, 'usuari');
    }
}
