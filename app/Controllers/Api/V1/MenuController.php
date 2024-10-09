<?php

namespace App\Controllers\Api\V1;

use App\Models\MenusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class MenuController extends BaseController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        //
        $menuModel = new MenusModel();
        return $this->respond($menuModel->findAll());
    }

    public function text()
    {
        //
        $menuModel = new MenusModel();

        $build = $menuModel->select('item, descricao, tipo, valor')->findAll();

        echo "Quantidade de intens no menu: ". count($build);
        foreach($build as $key => $value){
            echo "**Item:** {$value['item']}<br>";
            echo "**Desrição:** {$value['descricao']}<br>";
            echo "**Categoria:** {$value['tipo']}<br>";
            echo "**Valor:** R$ {$value['valor']}<br>";
            echo "<br>";
        }

        //return $this->respond($build);
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
