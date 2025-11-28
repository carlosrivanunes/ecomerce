<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Finalizar Compra</title>

    <script src="https://js.stripe.com/v3/"></script>
    
    <style>
        /* Variáveis de Estilo Padronizadas (Laranja/Vermelho) */
        :root {
            --primary-color: #333; /* Cor escura para texto principal/títulos */
            --accent-color: #ff6347; /* Laranja/Tomate para Ação (como no botão) */
            --accent-dark: #e84c3c; /* Vermelho/Laranja Escuro para Hover */
            --light-bg: #f8f8f8; /* Fundo mais claro */
            --border-color: #ddd;
            --price-color: #2c3e50;
        }

        /* Container principal para centralizar e dar fundo */
        body {
            background-color: var(--light-bg);
            padding: 20px;
            font-family: Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
        }

        /* Form/Card de Pagamento */
        #payment-form {
            max-width: 450px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); /* Sombra suave */
        }
        
        /* Título */
        .page-title {
            text-align: center;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 25px;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 10px;
        }

        /* Estilo do Elemento Stripe (Input) */
        .StripeElement {
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background: white;
            margin-bottom: 20px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        .StripeElement--focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(255, 99, 71, 0.2);
        }

        /* Mensagens de Erro */
        #card-errors {
            color: var(--accent-dark);
            background-color: #fff0f0;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #c0392b;
            margin-bottom: 20px;
            font-weight: 500;
        }

        /* Estilo do Botão "Pagar" - PADRÃO LARANJA */
        #submit {
            background: var(--accent-color);
            background: linear-gradient(180deg, var(--accent-color) 0%, var(--accent-dark) 100%); /* Gradiente */
            color: #fff;
            border: none;
            padding: 14px 12px;
            width: 100%;
            font-size: 1.1rem;
            font-weight: 700; /* Mais negrito */
            border-radius: 8px; /* Bordas mais marcadas */
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
            box-shadow: 0 4px 0 var(--accent-dark); /* Efeito 3D sutil */
            line-height: 1;
        }
        
        #submit:hover:not(:disabled) {
            transform: translateY(1px);
            box-shadow: 0 3px 0 var(--accent-dark);
        }
        
        #submit:active:not(:disabled) {
            transform: translateY(4px);
            box-shadow: 0 0 0 var(--accent-dark);
        }

        #submit:disabled {
            opacity: 0.7; /* Mantém um pouco do estilo mesmo desabilitado */
            cursor: not-allowed;
            box-shadow: none; /* Remove a sombra 3D quando desabilitado */
            transform: none;
        }
    </style>
</head>
<body>
    <h2 class="page-title">🔒 Finalizar Pagamento</h2>

    <form id="payment-form">
        <label style="font-weight: 600; color: var(--primary-color); display: block; margin-bottom: 5px;">Dados do Cartão:</label>
        <div id="card-element"></div>
        <div id="card-errors" role="alert"></div>
        
        <button id="submit">
            Pagar Agora <i class="bi bi-wallet-fill ms-1"></i>
        </button>
    </form>

    <script>
        // Configurações e lógica do Stripe (O script original foi mantido, mas a variável $stripeKey deve ser passada via Blade)
        const stripe = Stripe('{{ $stripeKey }}');
        const elements = stripe.elements();

        const card = elements.create('card');
        card.mount('#card-element');

        card.on('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        const form = document.getElementById('payment-form');
        const clientSecret = "{{ $clientSecret }}";

        form.addEventListener('submit', function(ev) {
            ev.preventDefault();

            document.getElementById('submit').disabled = true;
            document.getElementById('submit').textContent = 'Processando...'; // Feedback de processamento

            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: 'Cliente' 
                    }
                }
            }).then(function(result) {
                if (result.error) {
                    // Exibe erro no pagamento
                    document.getElementById('card-errors').textContent = result.error.message;
                    document.getElementById('submit').textContent = 'Pagar Novamente';
                    document.getElementById('submit').disabled = false;
                } else {
                    if (result.paymentIntent.status === 'succeeded') {
                        // Pagamento ok, chama API para salvar pedido e limpar carrinho
                        document.getElementById('submit').textContent = '✅ Pagamento Aprovado!';

                        fetch('{{ route('checkout.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({})
                        }).then(response => {
                            if(response.ok) {
                                // Redireciona após um pequeno delay para o usuário ver a mensagem de sucesso
                                setTimeout(() => {
                                    window.location.href = '/meus-pedidos'; 
                                }, 1500);
                            } else {
                                alert('Erro ao salvar pedido. Entre em contato com suporte.');
                                document.getElementById('submit').textContent = 'Pagar Novamente';
                                document.getElementById('submit').disabled = false;
                            }
                        });
                    }
                }
            });
        });
    </script>
</body>
</html>