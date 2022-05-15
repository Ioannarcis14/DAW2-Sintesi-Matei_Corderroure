<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Install extends Seeder
{
    public function run()
    {
        $this->call("AddAuthGroups");
        $this->call("AddAuthPermissions");
        $this->call("AddAuthUsers");

        $this->call("AddRestaurantSeeder");
        $this->call("UserRestaurantSeeder");

        $this->call("AddCategorySeeder");
        $this->call("AddAllergenSeeder");
        $this->call("AddSupplementSeeder");
        $this->call("AddDishSeeder");
        $this->call("AddTaulaSeeder");
        $this->call("AddMessageSeeder");

        $this->call("DishAllergenSeeder");
        $this->call("DishCategorySeeder");
        $this->call("DishSupplementSeeder");

        $this->call("AddOrderSeeder");
        $this->call("OrderDishSeeder");
        $this->call("OrderDishSupplementSeeder");
        
        $this->call("ValorationsSeeder");
    }
}
