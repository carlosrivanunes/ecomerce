@extends('layouts.app')

@section('content')

<script src="https://js.stripe.com/v3/"></script>

<style>
    /* Variáveis de Estilo Padronizadas */
    :root {
        --primary-color: #5d5d81; /* Índigo Suave */
        --accent-color: #00897b; /* Verde-Água (Teal) para Ação */
        --light-bg: #f4f7f9;
        --border-color: #e0e0e0;
        --price-color: #2c3e50; /* Cor escura para preços */
    }
    
    /* Container principal para centralizar e dar fundo */
    .checkout-wrapper {
        background-color: var(--light-bg);
        padding: 60px 20px;
        min-height: 80vh;
    }

    /* Card/Formulário de Pagamento */
    .payment-card {
        max-width: 450px;
        margin: 0 auto;
        padding: 30px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Título */
    .payment-card h2 {
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 25px;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 10px;
    }

    /* Destaque do Valor */
    .payment-amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--price-color);
        margin-bottom: 20px;
    }
    
    .payment-amount strong {
        color: var(--accent-color);
    }
    
    /* Estilo do Elemento Stripe (Input) */
    #card-element {
        padding: 12px;
        border: 1px solid var(--border-color); /* Borda cinza suave */
        border-radius: 6px;
        margin-bottom: 20px;
        background-color: #fff;
        transition: border-color 0.3s;
    }
    
    #card-element:focus-within {
        border-color: var(--primary-color); /* Foco na cor primária */
    }

    /* Estilo do Botão "Pagar" (Substitui o azul padrão) */
    .btn-pay {
        background: var(--accent-color); /* Verde-Água */
        color: #fff;
        border: none;
        padding: 12px;
        width: 100%;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }
    
    .btn-pay:hover {
        background-color: #00695c; /* Tom mais escuro no hover */
        transform: translateY(-1px);
    }
    
    /* Mensagens de Status */
    #message {
        margin-top: 20px;
        font-size: 1.1rem;
        font-weight: 600;
        text-align: center;
    }

    #message span {
        padding: 8px 15px;
        border-radius: 4px;
        display: inline-block;
    }

    #message span[style*="color:red"] {
        background-color: #fce7e7;
        color: #c0392b !important;
        border: 1px solid #c0392b;
    }
    
    #message span[style*="color:green"] {
        background-color: #e6fff7;
        color: #00897b !important;
        border: 1px solid #00897b;
    }
</style>

<div class="checkout-wrapper">
    <div class="payment-card">
        <h2><i class="bi bi-lock-fill me-2"></i> Pagamento Seguro</h2>
        
        <p class="payment-amount">Valor: <strong>R$ {{ isset($total) ? number_format($total, 2, ',', '.') : '0,00' }}</strong></p>

        <form id="payment-form">
            <div class="mb-3">
                <label class="form-label" style="font-weight: 500;">Dados do Cartão:</label>
                <div id="card-element">
                    </div>
            </div>

            <button type="submit" class="btn-pay">
                Pagar <i class="bi bi-wallet2 ms-1"></i>
            </button>
        </form>

        <div id="message"></div>
    </div>
</div>

<script>
    // Configurações do Stripe e lógica de pagamento
    const stripe = Stripe(@json(config('services.stripe.key')));

    const elements = stripe.elements();
    const card = elements.create("card");
    card.mount("#card-element");

    const form = document.getElementById("payment-form");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        
        // Exibe mensagem de processamento enquanto espera
        document.getElementById("message").innerHTML = 
            "<span style='color:blue; background-color: #e3f2fd; border: 1px solid #2196f3;'>Processando pagamento...</span>";

        // 👉 1. Solicita ao backend a criação do PaymentIntent
        const response = await fetch("/createintent");
        const { clientSecret } = await response.json();

        // 👉 2. Finaliza o pagamento
        const result = await stripe.confirmCardPayment(clientSecret, {
            payment_method: {
                card: card
            }
        });

        // 👉 3. Resultado do pagamento
        if (result.error) {
            document.getElementById("message").innerHTML =
                "<span style='color:red'>" + result.error.message + "</span>";
        } else if (result.paymentIntent.status === "succeeded") {
            document.getElementById("message").innerHTML =
                "<span style='color:green'>Pagamento aprovado!</span>";

            // Redireciona para a página de sucesso
            setTimeout(() => {
                window.location.href = "/checkout/success";
            }, 1500);
        }
    });
    
    // Opcional: expor total para JS se precisar enviar ao backend
    const orderTotal = @json($total ?? 0);
</script>

@endsection