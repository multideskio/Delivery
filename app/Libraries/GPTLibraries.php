<?php namespace App\Libraries;

class GPTLibraries {

    // Configura a chave da API OpenAI
    protected function dataGPT() {
        return [
            'api_key' => 'sua_chave_openai_aqui',
            'model' => 'gpt-4o-mini' // Nome do modelo OpenAI
        ];
    }

    // Identifica a intenção da mensagem e retorna o método correspondente
    protected function identifica_intencao($message) {
        if (stripos($message, 'buscar cliente') !== false) {
            return 'pesquisa_cliente';
        } elseif (stripos($message, 'cadastrar cliente') !== false) {
            return 'cadastra_cliente';
        } elseif (stripos($message, 'atualizar cliente') !== false) {
            return 'atualiza_cliente';
        } elseif (stripos($message, 'menu') !== false) {
            return 'menu';
        } elseif (stripos($message, 'pedido') !== false) {
            if (stripos($message, 'anotar') !== false) {
                return 'anota_pedido';
            } elseif (stripos($message, 'consultar') !== false) {
                return 'consulta_pedido';
            } elseif (stripos($message, 'atualizar') !== false) {
                return 'atualiza_pedido';
            }
        }
        return null; // Intenção não identificada
    }

    // Executa o fluxo consultando a intenção e chamando a API da OpenAI
    public function chat($message) {
        // Identifica a intenção
        $intent = $this->identifica_intencao($message);

        // Verifica se a intenção foi identificada
        if ($intent) {
            // Processa a intenção chamando o método apropriado
            switch ($intent) {
                case 'pesquisa_cliente':
                    $cpf = $this->extrair_cpf($message);
                    $result = $this->pesquisa_cliente($cpf);
                    break;
                case 'cadastra_cliente':
                    $params = $this->extrair_parametros_cliente($message);
                    $result = $this->cadastra_cliente($params);
                    break;
                case 'atualiza_cliente':
                    $params = $this->extrair_parametros_cliente($message);
                    $result = $this->atualiza_cliente($params);
                    break;
                case 'menu':
                    $result = $this->menu();
                    break;
                case 'anota_pedido':
                    $params = $this->extrair_parametros_pedido($message);
                    $result = $this->anota_pedido($params);
                    break;
                case 'consulta_pedido':
                    $cpf = $this->extrair_cpf($message);
                    $numero_pedido = $this->extrair_numero_pedido($message);
                    $result = $this->consulta_pedido($cpf, $numero_pedido);
                    break;
                case 'atualiza_pedido':
                    $params = $this->extrair_parametros_pedido($message);
                    $result = $this->atualiza_pedido($params);
                    break;
                default:
                    $result = "Intenção não reconhecida.";
                    break;
            }
            
            // Envia a resposta para o modelo GPT para processamento adicional
            return $this->chamar_openai($result, $message);
        }

        return "Desculpe, não consegui entender sua solicitação.";
    }

    // Método para chamar a API do OpenAI com a resposta
    protected function chamar_openai($dados, $mensagem_usuario) {
        $config = $this->dataGPT();

        // Corpo da requisição
        $data = [
            'model' => $config['model'],
            'messages' => [
                ['role' => 'system', 'content' => "Responda como assistente."],
                ['role' => 'user', 'content' => $mensagem_usuario],
                ['role' => 'assistant', 'content' => $dados]
            ]
        ];

        // Envia a requisição para a API do OpenAI
        $response = $this->enviar_request_openai($data, $config['api_key']);

        // Processa e retorna a resposta
        if ($response && isset($response['choices'][0]['message']['content'])) {
            return $response['choices'][0]['message']['content'];
        }

        return "Erro ao processar a resposta com OpenAI.";
    }

    protected function enviar_request_openai($data, $apiKey) {
        // Obtém a instância do serviço HTTP de CodeIgniter
        $client = \Config\Services::curlrequest();
    
        // Faz a requisição POST para a API do OpenAI
        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey
            ],
            'json' => $data  // O CI4 cuida de transformar o array em JSON
        ]);
    
        // Retorna a resposta decodificada como array
        return json_decode($response->getBody(), true);
    }
    

    // Métodos para cada intenção
    protected function pesquisa_cliente($cpf) {
        return "Cliente com CPF $cpf encontrado.";
    }

    protected function cadastra_cliente(array $params) {
        return "Cliente cadastrado com sucesso. Dados: " . implode(', ', $params);
    }

    protected function atualiza_cliente(array $params) {
        return "Cliente atualizado com sucesso. Dados: " . implode(', ', $params);
    }

    protected function menu() {
        return "Aqui está o menu do restaurante.";
    }

    protected function anota_pedido(array $params) {
        return "Pedido anotado com sucesso. Detalhes: " . implode(', ', $params);
    }

    protected function consulta_pedido($cpf, $numero_pedido) {
        return "Status do pedido $numero_pedido para o cliente com CPF $cpf.";
    }

    protected function atualiza_pedido(array $params) {
        return "Pedido atualizado com sucesso.";
    }

    // Funções auxiliares para extração de dados
    protected function extrair_cpf($message) {
        if (preg_match('/\d{11}/', $message, $matches)) {
            return $matches[0]; // Retorna o primeiro CPF encontrado
        }
        return null;
    }

    protected function extrair_parametros_cliente($message) {
        $cpf = $this->extrair_cpf($message);
        $nome = $this->extrair_nome($message);
        $email = $this->extrair_email($message);

        return compact('cpf', 'nome', 'email');
    }

    protected function extrair_parametros_pedido($message) {
        $produto = $this->extrair_produto($message);
        $quantidade = $this->extrair_quantidade($message);

        return compact('produto', 'quantidade');
    }

    protected function extrair_numero_pedido($message) {
        if (preg_match('/\d+/', $message, $matches)) {
            return $matches[0]; // Retorna o primeiro número encontrado
        }
        return null;
    }

    // Exemplos de funções auxiliares para extrair informações adicionais
    protected function extrair_nome($message) {
        // Exemplo básico para detectar um nome (pode ser ajustado para seu caso)
        if (preg_match('/nome\s*:\s*(\w+)/i', $message, $matches)) {
            return $matches[1];
        }
        return null;
    }

    protected function extrair_email($message) {
        if (preg_match('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}\b/', $message, $matches)) {
            return $matches[0];
        }
        return null;
    }

    protected function extrair_produto($message) {
        // Exemplo simples para detectar produto
        if (preg_match('/produto\s*:\s*(\w+)/i', $message, $matches)) {
            return $matches[1];
        }
        return null;
    }

    protected function extrair_quantidade($message) {
        // Exemplo simples para detectar quantidade
        if (preg_match('/quantidade\s*:\s*(\d+)/i', $message, $matches)) {
            return (int)$matches[1];
        }
        return 1; // Retorna 1 como padrão
    }
}
