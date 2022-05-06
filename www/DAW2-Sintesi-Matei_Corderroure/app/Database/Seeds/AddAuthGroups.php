<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddAuthGroups extends Seeder
{
    public function run()
    {
        //
        $authorize = $auth = service('authorization');
        $authorize->createGroup('administradors', 'Usuaris administradors del sistema');
        $authorize->createGroup('responsables', 'Responsables del restaurant');
        $authorize->createGroup('cuiners','Usuaris cuiner');
        $authorize->createGroup('cambrers','Usuaris cambrer');
        $authorize->createGroup('maitres','Usuaris maitre');
        $authorize->createGroup('usuaris','Usuaris generals');
    }
}
