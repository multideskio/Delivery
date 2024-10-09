<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

abstract class BaseController extends ResourceController
{
    use ResponseTrait;

    protected $request;

    protected $helpers = [];
    

    public function __construct()
    {
        $this->request = service('request');
    }
}
