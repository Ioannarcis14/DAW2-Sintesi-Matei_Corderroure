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
                'null'           => false,
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
        $this->forge->createTable('order');
        $this->forge->addForeignKey('id_restaurant', 'restaurant', 'id');
        $this->forge->addForeignKey('id_client', 'user', 'id');
        $this->forge->addForeignKey('id_cambrer', 'user', 'id');
        $this->forge->addForeignKey('id_taula', 'table', 'id');


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
                'unsigned'       => true,
                'null'           => true,
            ],
            'finishedTime'          => [
                'type'           => 'TIMESTAMP',
                'unsigned'       => true,
                'null'           => true,
            ],
            'state'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
            'lastTimeAction'          => [
                'type'           => 'TIMESTAMP',
                'unsigned'       => true,
                'null'           => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id', true);
        $this->forge->createTable('order_dish');
        $this->forge->addForeignKey('id_order', 'restaurant', 'id');
        $this->forge->addForeignKey('id_dish', 'user', 'id');
        $this->forge->addForeignKey('quantity', 'user', 'id');
        $this->forge->addForeignKey('observation', 'table', 'id');

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
        $this->forge->createTable('order_dish_supplement');
        $this->forge->addForeignKey('id_order_dish', 'order_dish', 'id');
        $this->forge->addForeignKey('id_supplement', 'supplement', 'id');
    }


    public function down()
    {
        $this->forge->dropTable('order');
        $this->forge->dropTable('order_dish');
        $this->forge->dropTable('order_dish_supplement');
    }
}
