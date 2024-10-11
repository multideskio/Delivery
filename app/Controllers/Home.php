<?php

namespace App\Controllers;

use App\Libraries\RedisLibrary;

class Home extends BaseController
{
    public function index(): string
    {

        $redis = new RedisLibrary();

        // Teste de publicação de mensagem no canal 'test_channel'
        //$redis->publish('test_channel', 'Mensagem de teste');

        // Teste de definir e obter uma chave no Redis
        //$redis->set('chave_teste', 'valor_teste');
        
        //echo $redis->get('chave_teste');  // Deve exibir 'valor_teste'

        return view('a');
    }
}
