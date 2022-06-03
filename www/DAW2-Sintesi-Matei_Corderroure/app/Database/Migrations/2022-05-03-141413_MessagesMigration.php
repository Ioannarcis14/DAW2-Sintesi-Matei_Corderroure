<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MessagesMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false,
            ],
            'receiver'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
            'theme'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
            'message'          => [
                'type'           => 'TEXT',
                'null'           => false,
            ],
        ]);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('messages');
        
        $this->forge->addField([
            'name'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
        ]);
        $this->forge->addPrimaryKey('name', true);
        $this->forge->createTable('theme');
        
    }

    public function down()
    {
        $this->forge->dropTable('messages');
        $this->forge->dropTable('theme');
    }
}
