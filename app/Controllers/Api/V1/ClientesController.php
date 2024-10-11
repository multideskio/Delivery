<?php

namespace App\Controllers\Api\V1;

use App\Libraries\RedisLibrary;
use App\Models\ClientesModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\WebSocketLibrary; // Importando a library WebSocket

class ClientesController extends BaseController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    protected $redis;
    protected $webSocket;

    public function __construct()
    {
        // Inicializar a biblioteca Redis
        $this->redis = new RedisLibrary();
        // Inicializar a biblioteca WebSocket
        $this->webSocket = new WebSocketLibrary();
    }
    public function index()
    {
        //
    }

    public function cadCliente()
    {
        $input = $this->request->getJSON(true);

        $cpf      = preg_replace('/\D/', '', $input['cpf']);
        $nome     = $input['nome'];
        $telefone = $input['telefone'];
        $endereco = $input['endereco'];

        $modelCliente = new \App\Models\ClientesModel();
        $build = $modelCliente->where('cpf', $cpf)->first();

        if ($build) {
            // Atualizando os dados do cliente existente
            $dataUpdate = [
                "id" => $build['id'],
                "nome" => $nome,
                "telefone" => $telefone,
                "endereco" => $endereco,
                "cpf" => $cpf
            ];

            $modelCliente->save($dataUpdate);

            // Enviar notificação via WebSocket para clientes conectados
            $this->webSocket->sendMessage([
                'event' => 'update_cliente',
                'data'  => $dataUpdate
            ]);

            // Publicar notificação no Redis
            $this->redis->publish('cliente_event', json_encode([
                'event' => 'update_cliente',
                'data'  => $dataUpdate
            ]));

            $data = ["output" => "O cliente foi atualizado com sucesso."];
        } else {
            // Inserindo um novo cliente
            $dataInsert = [
                "nome" => $nome,
                "telefone" => $telefone,
                "endereco" => $endereco,
                "cpf" => $cpf
            ];

            $modelCliente->save($dataInsert);

            // Enviar notificação via WebSocket para clientes conectados
            $this->webSocket->sendMessage([
                'event' => 'new_cliente',
                'data'  => $dataInsert
            ]);

            // Publicar notificação no Redis
            $this->redis->publish('cliente_event', json_encode([
                'event' => 'new_cliente',
                'data'  => $dataInsert
            ]));

            $data = ["output" => "O cliente foi cadastrado com sucesso."];
        }

        return $this->respond($data);
    }

    // Função para enviar notificações ao WebSocket
    private function sendWebSocketNotification($event, $data)
    {
        // Usar a library WebSocket para enviar notificação
        $websocket = new WebSocketLibrary();
        $websocket->sendMessage([
            'event' => $event,
            'data' => $data
        ]);
    }


    public function getCliente()
    {
        $input = $this->request->getJSON(true);
        $cpf = preg_replace('/\D/', '', $input['cpf']);

        $modelCliente = new ClientesModel();

        $build = $modelCliente->select('cpf, nome, telefone, endereco')->where('cpf', $cpf)->first();

        if ($build) {
            $data = [
                "output" => "**Nome:** {$build['nome']}\n**CPF:** {$build['cpf']}\n**Telefone:** {$build['telefone']}\n**Endereco:** {$build['endereco']}"
            ];
        } else {
            $data = [
                "output" => "CPF Não foi localizado"
            ];
        }

        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
