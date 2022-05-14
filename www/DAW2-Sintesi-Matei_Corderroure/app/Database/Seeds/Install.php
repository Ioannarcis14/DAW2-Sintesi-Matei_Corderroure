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
        $this->call("AddAllergenSeeder");
        $this->call("AddCategorySeeder");
        $this->call("AddDishSeeder");
        $this->call("AddOrderSeeder");
        $this->call("AddTaulaSeeder");
        $this->call("AddSupplementSeeder");
        $this->call("AddRestaurantSeeder");
        $this->call("AddMessageSeeder");
        $this->call("DishAllergenSeeder");
        $this->call("DishCategorySeeder");
        $this->call("DishSupplementSeeder");
        $this->call("OrderDishSeeder");
        $this->call("OrderDishSupplementSeeder");
        $this->call("UserRestaurantSeeder");
        $this->call("ValorationsSeeder");
    }
}
