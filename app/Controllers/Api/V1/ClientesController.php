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
