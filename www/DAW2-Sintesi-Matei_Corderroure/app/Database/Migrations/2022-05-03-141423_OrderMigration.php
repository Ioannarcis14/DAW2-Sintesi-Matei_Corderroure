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
            'id_cambrer'          => [
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
        $this->forge->addForeignKey('id_cambrer', 'users', 'id');
        $this->forge->addForeignKey('id_taula', 'table', 'id');
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
                'null'           => false,
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
        $this->forge->dropTable('order');
        $this->forge->dropTable('order_dish');
        $this->forge->dropTable('order_dish_supplement');
    }
}
