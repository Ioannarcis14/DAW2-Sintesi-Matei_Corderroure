<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddAuthPermissions extends Seeder
{
    public function run()
    {
        //
        $authorize = $auth = service('authorization');

        //Permissions for user administration (admin only)
        $authorize->createPermission('user.manage', 'Allows a user to create, edit, and delete users');
        $authorize->createPermission('user.add', 'Allows a user to create users');
        $authorize->createPermission('user.update', 'Allows a user to edit users');
        $authorize->createPermission('user.delete', 'Allows a user to delete users');
        $authorize->createPermission('user.enter', 'Allows a user to enter the user administration');

        //Permissions for staff administration (responsable only)
        $authorize->createPermission('staff.manage', 'Allows a user to create, edit, and delete staff');
        $authorize->createPermission('staff.add', 'Allows a user to create staff');
        $authorize->createPermission('staff.update', 'Allows a user to edit staff');
        $authorize->createPermission('staff.delete', 'Allows a user to delete staff');
        $authorize->createPermission('staff.enter', 'Allows a user to enter the staff administration');
        
        //Permissions for dish administration (responsable only)
        $authorize->createPermission('dish.manage', 'Allows a user to create, edit, and delete dish');
        $authorize->createPermission('dish.add', 'Allows a user to create dish');
        $authorize->createPermission('dish.update', 'Allows a user to edit dish');
        $authorize->createPermission('dish.delete', 'Allows a user to delete dish');
        $authorize->createPermission('dish.enter', 'Allows a user to enter the dish administration');
        
        //Permissions for supplement administration (only responsable) 
        $authorize->createPermission('supplement.manage', 'Allows a user to create, edit, and delete supplement');
        $authorize->createPermission('supplement.add', 'Allows a user to create supplement');
        $authorize->createPermission('supplement.update', 'Allows a user to edit supplement');
        $authorize->createPermission('supplement.delete', 'Allows a user to delete supplement');
        $authorize->createPermission('supplement.enter', 'Allows a user to enter the supplement administration');

        //Permissions for order administration (cambrer/cuiner can add/delete dishes from the orders 
        //and maitre can visualize the orders and make statistics)
        $authorize->createPermission('order.manage', 'Allows a user to create, edit, and delete order');
        $authorize->createPermission('order.add', 'Allows a user to create order');
        $authorize->createPermission('order.update', 'Allows a user to edit order');
        $authorize->createPermission('order.delete', 'Allows a user to delete order');
        $authorize->createPermission('order.enter', 'Allows a user to enter the orders administration');

        //Permissions for restaurant administration (admin needs to discharge the restauarant and then responsable can manage the restaurant administration)
        $authorize->createPermission('restaurant.discharge', 'Allows a user to discharge a restaurant');
        $authorize->createPermission('restaurant.manage', 'Allows a user to create, edit, and delete restaurant');
        $authorize->createPermission('restaurant.add', 'Allows a user to create restaurant');
        $authorize->createPermission('restaurant.update', 'Allows a user to edit restaurant');
        $authorize->createPermission('restaurant.delete', 'Allows a user to delete restaurant');
        $authorize->createPermission('restaurant.enter', 'Allows a user to enter the restaurant administration');

        //Permissions for theme administration (only admin) 
        $authorize->createPermission('theme.manage', 'Allows a user to create, edit, and delete theme');
        $authorize->createPermission('theme.add', 'Allows a user to create theme');
        $authorize->createPermission('theme.update', 'Allows a user to edit theme');
        $authorize->createPermission('theme.delete', 'Allows a user to delete theme');
        $authorize->createPermission('theme.enter', 'Allows a user to enter the themes administration');

        //Permissions for category administration (only responsable) 
        $authorize->createPermission('category.manage', 'Allows a user to create, edit, and delete category');
        $authorize->createPermission('category.add', 'Allows a user to create category');
        $authorize->createPermission('category.update', 'Allows a user to edit category');
        $authorize->createPermission('category.delete', 'Allows a user to delete category');
        $authorize->createPermission('category.enter', 'Allows a user to enter the category administration');

        //Permissions for allergen administration (only responsable) 
        $authorize->createPermission('allergen.manage', 'Allows a user to create, edit, and delete allergen');
        $authorize->createPermission('allergen.add', 'Allows a user to create allergen');
        $authorize->createPermission('allergen.update', 'Allows a user to edit allergen');
        $authorize->createPermission('allergen.delete', 'Allows a user to delete allergen');
        $authorize->createPermission('allergen.enter', 'Allows a user to enter the allergen administration');

        //Permissions for see messages (seeing and creating messages)
        $authorize->createPermission('messages.enter', 'Allows a user to enter the messages administration');
        $authorize->createPermission('messages.add', 'Allows a user to create messages');

        //Permissions for see valoracions (seeing and creating messages)
        $authorize->createPermission('valoracions.manage', 'Allows a user to enter the valoracions administration');
        $authorize->createPermission('valoracions.add', 'Allows a user to create valoracions');
        

        # Add permissions to administradors
        $authorize->addPermissionToGroup('user.manage', 'administrador');
        $authorize->addPermissionToGroup('restaurant.discharge', 'administrador');
        $authorize->addPermissionToGroup('theme.manage', 'administrador');

        # Add permissions to responsables
        $authorize->addPermissionToGroup('valoracions.manage', 'responsable');
        $authorize->addPermissionToGroup('allergen.manage', 'responsable');
        $authorize->addPermissionToGroup('category.manage', 'responsable');
        $authorize->addPermissionToGroup('restaurant.manage', 'responsable');
        $authorize->addPermissionToGroup('restaurant.manage', 'responsable');

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
