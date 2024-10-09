<?php

namespace App\Database\Seeds;

use App\Models\ApikeysModel;
use App\Models\EmpresasModel;
use App\Models\MenusModel;
use App\Models\UsuariosModel;
use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;

class Init extends Seeder
{
    public function run()
    {
        //
        $modelEmpresa = new EmpresasModel();
        $modelUsuario = new UsuariosModel();
        $modelApikey  = new ApikeysModel();
        $modelMenu    = new MenusModel();

        $empresa = [
            'empresa' => 'Multidesk',
            'descricao' => 'Empresa teste',
            'telefone' => '62981154120',
            'email' => 'multidesk.io@gmail.com',
            'limite_noite' => 10,
            'limite_mes' => 1000,
            'slug' => Uuid::uuid4()->toString()
        ];

        $idEmpresa = $modelEmpresa->insert($empresa);

        $usuario = [
            'id_empresa' => $idEmpresa,
            'nome' => 'Paulo',
            'email' => 'multidesk.io@gmail.com',
            'telefone' => '62981154120',
            'password' => '123456',
            'slug' => Uuid::uuid4()->toString()
        ];

        $idUsuario = $modelUsuario->insert($usuario);

        $key = [
            'id_empresa' => $idEmpresa,
            'id_usuario' => $idUsuario,
            'key' => Uuid::uuid4()->toString()
        ];

        $idKey = $modelApikey->insert($key);

        $menu = [
            [
                'id_empresa' => $idEmpresa,
                'id_usuario' => $idUsuario,
                'item' => 'Pizza Calabresa grande',
                'descricao' => 'Ingredientes: calabresa, queijo, molho de tomate',
                'tipo' => 'Pizzas',
                'valor' => '45.00',
                'image' => null,
                'slug' => Uuid::uuid4()->toString()
            ],
            [
                'id_empresa' => $idEmpresa,
                'id_usuario' => $idUsuario,
                'item' => 'Pizza Portuguesa média',
                'descricao' => 'Ingredientes: presunto, ovos, azeitonas, cebola',
                'tipo' => 'Pizzas',
                'valor' => '40.00',
                'image' => null,
                'slug' => Uuid::uuid4()->toString()
            ],
            [
                'id_empresa' => $idEmpresa,
                'id_usuario' => $idUsuario,
                'item' => 'Pizza Marguerita pequena',
                'descricao' => 'Ingredientes: manjericão, tomate, queijo',
                'tipo' => 'Pizzas',
                'valor' => '30.00',
                'image' => null,
                'slug' => Uuid::uuid4()->toString()
            ],
            [
                'id_empresa' => $idEmpresa,
                'id_usuario' => $idUsuario,
                'item' => 'Refrigerante Guaraná',
                'descricao' => '1 litro',
                'tipo' => 'Bebidas',
                'valor' => '8.00',
                'image' => null,
                'slug' => Uuid::uuid4()->toString()
            ],
            [
                'id_empresa' => $idEmpresa,
                'id_usuario' => $idUsuario,
                'item' => 'Suco de Laranja natural',
                'descricao' => '500ml',
                'tipo' => 'Bebidas',
                'valor' => '12.00',
                'image' => null,
                'slug' => Uuid::uuid4()->toString()
            ],
            [
                'id_empresa' => $idEmpresa,
                'id_usuario' => $idUsuario,
                'item' => 'Água Mineral',
                'descricao' => '500ml',
                'tipo' => 'Bebidas',
                'valor' => '5.00',
                'image' => null,
                'slug' => Uuid::uuid4()->toString()
            ],
            [
                'id_empresa' => $idEmpresa,
                'id_usuario' => $idUsuario,
                'item' => 'Pizza Quatro Queijos grande',
                'descricao' => 'Ingredientes: muçarela, provolone, parmesão, gorgonzola',
                'tipo' => 'Pizzas',
                'valor' => '50.00',
                'image' => null,
                'slug' => Uuid::uuid4()->toString()
            ],
            [
                'id_empresa' => $idEmpresa,
                'id_usuario' => $idUsuario,
                'item' => 'Pizza de Frango com Catupiry média',
                'descricao' => 'Ingredientes: frango desfiado, catupiry, queijo',
                'tipo' => 'Pizzas',
                'valor' => '42.00',
                'image' => null,
                'slug' => Uuid::uuid4()->toString()
            ],
            [
                'id_empresa' => $idEmpresa,
                'id_usuario' => $idUsuario,
                'item' => 'Pizza Pepperoni grande',
                'descricao' => 'Ingredientes: pepperoni, queijo, molho de tomate',
                'tipo' => 'Pizzas',
                'valor' => '48.00',
                'image' => null,
                'slug' => Uuid::uuid4()->toString()
            ],
            [
                'id_empresa' => $idEmpresa,
                'id_usuario' => $idUsuario,
                'item' => 'Hambúrguer Tradicional',
                'descricao' => 'Ingredientes: carne bovina, alface, tomate, queijo',
                'tipo' => 'Lanches',
                'valor' => '20.00',
                'image' => null,
                'slug' => Uuid::uuid4()->toString()
            ],
        ];

        $success = $modelMenu->insertBatch($menu);

        $results = [
            'empresa' => $idEmpresa,
            'usuario' => $idUsuario,
            'apikey'  => $idKey,
            'menu'    => $success ? 'Menu inserido com sucesso' : 'Falha ao inserir o menu'
        ];

        print_r($results);
    }
}
