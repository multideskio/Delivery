<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TabelaMenu extends Migration
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
            'item' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'descricao' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'tipo' => [
                'type' => 'varchar',
                'constraint' => 25
            ],
            'valor' => [
                'type' => 'decimal',
                'constraint' => "10,2"
            ],
            'image' => [
                'type' => 'varchar',
                'constraint' => '255',
                'null' => true
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
        //$this->forge->addForeignKey('id_usuario', 'usuarios', 'id', 'no action', 'no action');
        $this->forge->createTable('menus', true);


        $seeder = \Config\Database::seeder();
        $seeder->call('Init');
    }

    public function down()
    {
        //
        $this->forge->dropTable('menus');
    }
}
