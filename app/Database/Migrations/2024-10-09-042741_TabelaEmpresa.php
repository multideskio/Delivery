<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TabelaEmpresa extends Migration
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
            'empresa' => [
                'type' => 'varchar',
                'constraint' => 150
            ],
            'descricao' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'telefone' => [
                'type' => 'varchar',
                'constraint' => 25
            ],
            'email' => [
                'type' => 'varchar',
                'constraint' => 60
            ],
            'slug' => [
                'type' => 'varchar',
                'constraint' => 90
            ],
            'limite_noite' => [
                'type' => 'int',
                'constraint' => 3,
                'default' => 5
            ],
            'limite_mes' => [
                'type' => 'int',
                'constraint' => 3,
                'default' => 5
            ],
            'ativo' => [
                'type' => 'bool',
                'default' => true
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

        $this->forge->addPrimaryKey('id')->createTable('empresas');
    }

    public function down()
    {
        //
        $this->forge->dropTable('empresas');
    }
}
