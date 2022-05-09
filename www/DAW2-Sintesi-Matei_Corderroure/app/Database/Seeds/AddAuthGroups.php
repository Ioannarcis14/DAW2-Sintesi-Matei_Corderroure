<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddAuthGroups extends Seeder
{
    public function run()
    {
        //
        $authorize = $auth = service('authorization');
        $authorize->createGroup('administrador', 'Usuaris administradors del sistema');
        $authorize->createGroup('responsable', 'Responsables del restaurant');
        $authorize->createGroup('cuiner','Usuaris cuiner');
        $authorize->createGroup('cambrer','Usuaris cambrer');
        $authorize->createGroup('maitre','Usuaris maitre');
        $authorize->createGroup('usuari','Usuaris generals');
    }
}
