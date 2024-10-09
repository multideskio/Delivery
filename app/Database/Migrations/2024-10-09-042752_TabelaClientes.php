<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TabelaClientes extends Migration
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
            'cpf' => [
                'type' => 'varchar',
                'constraint' => 15
            ],
            'nome' => [
                'type' => 'varchar',
                'constraint' => 90
            ],
            'telefone' => [
                'type' => 'varchar',
                'constraint' => 60
            ],
            'endereco' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'ativo' => [
                'type' => 'bool',
                'default' => true
            ],
            'slug' => [
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
        $this->forge->addForeignKey('id_empresa', 'empresas', 'id', 'cascade', 'cascade');
        $this->forge->createTable('clientes');
    }

    public function down()
    {
        //
        $this->forge->dropTable('clientes');

    }
}
