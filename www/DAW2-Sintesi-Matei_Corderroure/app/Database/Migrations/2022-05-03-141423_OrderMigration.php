<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrderMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
                'null'           => false,
            ],
            'id_restaurant'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
            'id_client'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false,
            ],
            'id_taula'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false,
            ],
            'diners'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
            'state'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id', true);
        $this->forge->addForeignKey('id_restaurant', 'restaurant', 'id');
        $this->forge->addForeignKey('id_client', 'users', 'id');
        $this->forge->addForeignKey('id_taula', 'taula', 'id');
        $this->forge->createTable('order');


        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
                'null'           => false,
            ],
            'id_order'          => [
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
            'quantity'          => [
                'type'           => 'INT',
                'constraint'     => 4,
                'unsigned'       => true,
                'null'           => false,
            ],
            'observation'          => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'startTime'          => [
                'type'           => 'TIMESTAMP',
                'null'           => true,
            ],
            'finishedTime'          => [
                'type'           => 'TIMESTAMP',
                'null'           => true,
            ],
            'state'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
            'lastTimeAction'          => [
                'type'           => 'TIMESTAMP',
                'null'           => true,   
            ],
        ]);
        $this->forge->addPrimaryKey('id', true);
        $this->forge->addForeignKey('id_order', 'order', 'id');
        $this->forge->addForeignKey('id_dish', 'dish', 'id');
        $this->forge->createTable('order_dish');


        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
                'null'           => false,
            ],
            'id_order_dish'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false,
            ],
            'id_supplement'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id', true);
        $this->forge->addForeignKey('id_order_dish', 'order_dish', 'id');
        $this->forge->addForeignKey('id_supplement', 'supplement', 'id');
        $this->forge->createTable('order_dish_supplement');


        $this->forge->addField([
            'id_user'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false,
            ],
            'id_restaurant'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false,
            ],
        ]);
        $this->forge->addForeignKey('id_user', 'users', 'id');
        $this->forge->addForeignKey('id_restaurant', 'restaurant', 'id');
        $this->forge->createTable('user_restaurant');
    }


    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
            $this->forge->dropForeignKey('order', 'order_id_client_foreign');
            $this->forge->dropForeignKey('order', 'order_id_cambrer_foreign');
            $this->forge->dropForeignKey('order', 'order_id_taula_foreign');
            $this->forge->dropForeignKey('order', 'order_id_restaurant_foreign');

            $this->forge->dropForeignKey('order_dish', 'order_dish_id_order_foreign');
            $this->forge->dropForeignKey('order_dish', 'order_dish_id_dish_foreign');

            $this->forge->dropForeignKey('order_dish_supplement','order_dish_supplement_id_order_dish_foreign');
            $this->forge->dropForeignKey('order_dish_supplement','order_dish_supplement_id_supplement_foreign');

            $this->forge->dropForeignKey('user_restaurant', 'user_restaurant_id_user_foreign');
            $this->forge->dropForeignKey('user_restaurant', 'user_restaurant_id_restaurant_foreign');
        }

        $this->forge->dropTable('order');
        $this->forge->dropTable('order_dish');
        $this->forge->dropTable('order_dish_supplement');
    }
}
