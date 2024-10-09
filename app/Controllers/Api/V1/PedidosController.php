<?php

namespace App\Controllers\Api\V1;

use App\Models\ClientesModel;
use App\Models\PedidosModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PedidosController extends BaseController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        //
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
        try {
            // Recebe os dados da requisição em formato JSON
            $input = $this->request->getJSON(true);

            // Valida o campo CPF (obrigatório)
            if (empty($input['cpf'])) {
                throw new \Exception('Informe o CPF para localizar o cliente.');
            }

            // Remove caracteres não numéricos do CPF
            $cpf = preg_replace('/\D/', '', $input['cpf']);

            // Valida o campo itens (obrigatório)
            if (empty($input['itens'])) {
                throw new \Exception('Os itens são obrigatórios.');
            }

            $itens = $input['itens'];

            // Valida o campo total (obrigatório e conversão para decimal 10,2)
            if (empty($input['total'])) {
                throw new \Exception('O total é obrigatório.');
            }

            if (!is_numeric($input['total'])) {
                throw new \Exception('O total deve ser um valor numérico.');
            }

            // Converte o total para decimal 10,2
            $total = number_format((float) $input['total'], 2, '.', '');

            // Valida o campo forma_pagamento (obrigatório)
            if (empty($input['forma_pagamento'])) {
                throw new \Exception('A forma de pagamento é obrigatória.');
            }

            $forma_pagamento = $input['forma_pagamento'];

            // Valida o campo observações (não obrigatório, mas pode ser tratado)
            $observacoes = isset($input['observacoes']) ? $input['observacoes'] : '';

            // Instancia o modelo do cliente
            $modelCliente = new ClientesModel();
            $cliente = $modelCliente->select('id as id_cliente')->where('cpf', $cpf)->first();

            // Verifica se o cliente foi encontrado
            if (!$cliente) {
                throw new \Exception('CPF não informado ou cliente não tem cadastro.');
            }

            // Instancia o modelo de pedidos
            $modelPedido = new PedidosModel();

            // Verifica se o cliente já tem um pedido "em preparação"
            $pedidoExistente = $modelPedido->where([
                'id_cliente' => $cliente['id_cliente'],
                'status'     => 'em preparação'
            ])->first();

            
            // Conta o número total de pedidos que o cliente já fez
            $countPedidos = $modelPedido->where('id_cliente', $cliente['id_cliente'])->countAllResults();

            // Gera automaticamente o número do pedido com base na contagem de pedidos
            $numero_pedido = !$pedidoExistente
                ? 'P' . $cliente['id_cliente'] . '-' . ($countPedidos + 1)
                : $pedidoExistente['numero_pedido'];

            // Dados do pedido
            $pedidoData = [
                'id_empresa'      => 1,  // Valor fixo ou obtido dinamicamente
                'id_cliente'      => $cliente['id_cliente'],
                'numero_pedido'   => $numero_pedido,
                'itens'           => $itens,
                'total'           => $total,
                'forma_pagamento' => $forma_pagamento,
                'observacoes'     => $observacoes,
                'status'          => 'em preparação',  // Status inicial do pedido
            ];

            // Verifica o status do pedido existente
            if ($pedidoExistente) {
                // Caso o pedido esteja "em preparação", permite atualização
                if ($pedidoExistente['status'] === 'em preparação') {
                    $modelPedido->update($pedidoExistente['id'], $pedidoData);

                    return $this->respond(['output' => 'Pedido atualizado com sucesso!', 'pedido' => $pedidoData], 200);
                } else {
                    // Caso o pedido esteja com outro status (ex: "saiu para entrega" ou "pedido entregue")
                    throw new \Exception('Pedido não pode ser alterado pois já saiu para entrega ou foi finalizado.');
                }
            } else {
                // Caso não exista um pedido "em preparação", cria um novo pedido
                $modelPedido->insert($pedidoData);

                return $this->respond(['output' => 'Pedido criado com sucesso!', 'pedido' => $pedidoData], 200);
            }
        } catch (\Exception $e) {
            // Captura qualquer exceção e retorna a mensagem de erro com código 200
            return $this->respond(['error' => $e->getMessage()], 200);
        }
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
