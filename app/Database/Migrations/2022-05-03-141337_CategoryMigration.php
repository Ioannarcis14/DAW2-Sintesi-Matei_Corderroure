<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableMigration extends Migration
{
    public function up()
    {

        $this->db->disableForeignKeyChecks();

        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_restaurant'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false,
            ],
            'id_category_parent'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
            'name'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
            'observation_msg'          => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id', true);
        $this->forge->createTable('category');
        $this->forge->addForeignKey('id_restaurant', 'restaurant', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_category_parent', 'category', 'id', 'CASCADE', 'CASCADE');

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('category');
    }
}
