<?php

namespace App\Controllers\Api\V1;

use App\Models\ClientesModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ClientesController extends BaseController
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

    public function cadCliente()
    {
        $input = $this->request->getJSON(true);

        $cpf      = preg_replace('/\D/', '', $input['cpf']);
        $nome     = $input['nome'];
        $telefone = $input['telefone'];
        $endereco = $input['endereco'];

        $modelCliente = new ClientesModel();
        $build = $modelCliente->where('cpf', $cpf)->first();

        if($build){
            $dataUpdate = [
                "id" => $build['id'],
                "nome" => $input['nome'],
                "telefone" => $input['telefone'],
                "endereco" =>  $input['endereco'],
            ];

            $modelCliente->save($dataUpdate);
            
            $data = [
                "output" => "O cliente foi atualizado com sucesso, sempre garanta que o endereço está completo para não haver problemas na entrega..."
            ];
        }else{

            $dataUpdate = [
                "nome" => $input['nome'],
                "telefone" => $input['telefone'],
                "endereco" =>  $input['endereco'],
                "cpf" => $cpf 
            ];

            $modelCliente->save($dataUpdate);
            
            $data = [
                "output" => "O cliente foi cadastrado com sucesso, sempre garanta que o endereço está completo para não haver problemas na entrega..."
            ];
        }

        return $this->respond($data);

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
