<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificações de Clientes</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- FontAwesome (para ícones) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .notification {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        .notification.new {
            border-left: 5px solid #28a745;  /* Verde para novos clientes */
        }
        .notification.update {
            border-left: 5px solid #ffc107;  /* Amarelo para atualizações */
        }
        .fade-in-left {
            opacity: 0;
            transform: translateX(-100%);
            transition: all 0.5s ease-in-out;
        }
        .fade-in-left.show {
            opacity: 1;
            transform: translateX(0);
        }
    </style>
</head>
<body>

    <div class="container my-5">
        <h2 class="mb-4 text-center">Notificações de Clientes</h2>

        <!-- Container para exibir as notificações -->
        <div id="notification-list"></div>
    </div>

    <!-- WebSocket Script -->
    <script>
        const ws = new WebSocket('ws://5.161.224.69:8081?empresa_id=1'); // Substitua pelo ID correto da empresa

        ws.onopen = () => {
            console.log('Conectado ao WebSocket');
        };

        ws.onmessage = (event) => {
            try {
                // Fazer log do dado recebido para ver sua estrutura
                console.log("Mensagem recebida:", event.data);

                const rawData = JSON.parse(event.data); // Parse do primeiro nível
                console.log("Dados após o primeiro parse:", rawData);

                // Verificar se existe a propriedade 'message' e fazer parse da string JSON interna
                if (!rawData.message) {
                    console.error('Estrutura inesperada, `rawData.message` está indefinido:', rawData);
                    return;
                }

                const data = JSON.parse(rawData.message); // Parse da string JSON dentro de 'message'
                console.log("Dados após o segundo parse:", data);

                const clientData = data.data;  // Acessar os dados corretamente

                let notificationClass = '';
                let title = '';

                if (data.event === 'new_cliente') {
                    notificationClass = 'new';
                    title = '<strong><i class="fas fa-user-plus"></i> Novo cliente cadastrado:</strong>';
                } else if (data.event === 'update_cliente') {
                    notificationClass = 'update';
                    title = '<strong><i class="fas fa-user-edit"></i> Cliente atualizado:</strong>';
                }

                // Criar o HTML da notificação
                const notificationHtml = `
                    <div class="notification ${notificationClass} fade-in-left">
                        ${title} ${clientData.nome}<br>
                        <small>CPF: ${clientData.cpf} | Telefone: ${clientData.telefone}</small>
                    </div>
                `;

                // Adicionar a notificação ao início da lista
                $('#notification-list').prepend(notificationHtml);

                // Aplicar a classe 'show' para a animação de entrada
                setTimeout(() => {
                    $('.fade-in-left').first().addClass('show');
                }, 100);
            } catch (error) {
                console.error('Erro ao processar a mensagem:', error);
            }
        };

        ws.onclose = () => {
            console.log('Conexão WebSocket fechada');
        };

        ws.onerror = (error) => {
            console.error('Erro no WebSocket: ', error);
        };
    </script>

    <!-- Bootstrap 5 JavaScript CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
