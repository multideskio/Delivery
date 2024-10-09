<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TabelaApiKeys extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_empresa' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'id_usuario' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'key' => [
                'type' => 'varchar',
                'constraint' => 90
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        //$this->forge->addForeignKey('id_empresa', 'empresas', 'id', 'cascade', 'cascade');
        //$this->forge->addForeignKey('id_usuario', 'usuarios', 'id', 'no action', 'no action');
        $this->forge->createTable('api_keys');
    }

    public function down()
    {
        //
        $this->forge->dropTable('api_keys');
    }
}
