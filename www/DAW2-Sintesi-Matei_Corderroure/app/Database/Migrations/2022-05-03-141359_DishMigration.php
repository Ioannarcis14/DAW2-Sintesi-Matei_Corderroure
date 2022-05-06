<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DishMigration extends Migration
{
    public function up()
{
        $this->forge->addField([
                'id'          => [
                        'type'           => 'INT',
                        'constraint'     => 11,
                        'unsigned'       => true,
                        'auto_increment' => true,
                ],
                'description'          => [
                        'type'           => 'TEXT',
                        'null'           => false,
                ],
                'name'          => [
                        'type'           => 'CHAR',
                        'constraint'     => '255',
                        'null'           => false,
                ],
                'price'          => [
                        'type'           => 'FLOAT',
                        'constraint'     => '10',
                        'unsigned'       => true,
                        'null'           => false,
                ],
                'imgs'          => [
                        'type'           => 'TEXT',
                        'null'           => false,
                ],
                'short_description'          => [
                        'type'           => 'VARCHAR',
                        'constraint'     => '255',
                        'null'           => false,
                ],
        ]);
        $this->forge->addPrimaryKey('id', true);
        $this->forge->createTable('dish');

        /*
         * Dish/Category Table
         */

        $this->forge->addField([
            'id_category'          => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'null'           => false,
            ],
            'id_dish'          => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'null'           => false,
            ],
        ]);
        $this->forge->addForeignKey('id_category', 'category', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_dish', 'dish', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('dish_category');

        /*
         * Dish/Allergen Table
         */

        $this->forge->addField([
            'id_allergen'          => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'null'           => false,
            ],
            'id_dish'          => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'null'           => false,
            ],
        ]);
        $this->forge->addForeignKey('id_allergen', 'allergen', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_dish', 'dish', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('dish_allergen');

        /*
         * Dish/Supplement Table
         */

        $this->forge->addField([
            'id_supplement'          => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'null'           => false,
            ],
            'id_dish'          => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'null'           => false,
            ],
        ]);
        $this->forge->addForeignKey('id_supplement', 'supplement', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_dish', 'dish', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('dish_supplement');
}

public function down()
{
        $this->forge->dropTable('dish');
        $this->forge->dropTable('dish_category');
        $this->forge->dropTable('dish_allergen');
        $this->forge->dropTable('dish_supplement');

}
}