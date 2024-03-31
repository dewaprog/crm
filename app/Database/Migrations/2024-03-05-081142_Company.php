<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Company extends Migration
{
    public function up()
    {

        $this->forge->addField([
            'company_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'company_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true,
                // 'default' => date("Y-m-d H:i:s"),
            ],
            'created_by' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'updated_by' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null' => true,
            ],
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null' => true,
                'default' => 1,
            ],
        ]);
        $this->forge->addKey('company_id', true);
        $this->forge->createTable('company');
    }

    public function down()
    {
        $this->forge->dropTable('company');
    }
}
