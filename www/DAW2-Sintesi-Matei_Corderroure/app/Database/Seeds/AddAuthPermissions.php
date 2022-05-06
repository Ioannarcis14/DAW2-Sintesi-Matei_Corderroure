<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddAuthPermissions extends Seeder
{
    public function run()
    {
        //
        $authorize = $auth = service('authorization');
        $authorize->createPermission('news.manage', 'Allows a user to create, edit, and delete news');
        $authorize->createPermission('news.add', 'Allows a user to create news');
        $authorize->createPermission('news.update', 'Allows a user to edit news');
        $authorize->createPermission('news.delete', 'Allows a user to delete news');
        $authorize->createPermission('news.enter', 'Allows a user to enter a news');
        # Add permissions to administradors
        $authorize->addPermissionToGroup('news.manage', 'administrador');
        $authorize->addPermissionToGroup('news.add', 'administrador');
        $authorize->addPermissionToGroup('news.update', 'administrador');
        $authorize->addPermissionToGroup('news.delete', 'administrador');
        # Add permissions to responsables
        $authorize->addPermissionToGroup('news.manage', 'responsable');
        $authorize->addPermissionToGroup('news.add', 'responsable');
        $authorize->addPermissionToGroup('news.update', 'responsable');
        $authorize->addPermissionToGroup('news.delete', 'responsable');
        # Add permissions to cambrer
        $authorize->addPermissionToGroup('news.manage', 'cambrer');
        $authorize->addPermissionToGroup('news.add', 'cambrer');
        $authorize->addPermissionToGroup('news.update', 'cambrer');
        $authorize->addPermissionToGroup('news.delete', 'cambrer');
        # Add permissions to cuiner
        $authorize->addPermissionToGroup('news.manage', 'cuiner');
        $authorize->addPermissionToGroup('news.add', 'cuiner');
        $authorize->addPermissionToGroup('news.update', 'cuiner');
        $authorize->addPermissionToGroup('news.delete', 'cuiner');
        # Add permissions to maitre
        $authorize->addPermissionToGroup('news.manage', 'maitre');
        $authorize->addPermissionToGroup('news.add', 'maitre');
        $authorize->addPermissionToGroup('news.update', 'maitre');
        $authorize->addPermissionToGroup('news.delete', 'maitre');

        # Add generics permissions
        $authorize->addPermissionToGroup('news.enter', 'administradors');
        $authorize->addPermissionToGroup('news.enter', 'responsable');
        $authorize->addPermissionToGroup('news.enter', 'cuiner');
        $authorize->addPermissionToGroup('news.enter', 'cambrer');
        $authorize->addPermissionToGroup('news.enter', 'maitre');
        $authorize->addPermissionToGroup('news.enter', 'usuari');
    }
}
