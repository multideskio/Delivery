<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TabelaPedidos extends Migration
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
            'id_cliente' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'itens' => [
                'type' => 'text'
            ],
            'total' => [
                'type' => 'decimal',
                'constraint' => '10.2'
            ],
            'forma_pagamento' => [
                'type' => 'varchar',
                'constraint' => 20
            ],
            'observacoes' => [
                'type' => 'text'
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
        //$this->forge->addForeignKey('id_empresa', 'empresas', 'id', 'cascade', 'cascade');
        //$this->forge->addForeignKey('id_cliente', 'clientes', 'id', 'cascade', 'cascade');
        $this->forge->createTable('pedidos');
    }

    public function down()
    {
        //
        $this->forge->dropTable('pedidos');
    }
}
