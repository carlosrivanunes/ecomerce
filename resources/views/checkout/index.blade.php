@extends('layouts.app')

@section('content')

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
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); /* Sombra mais suave */
    }

    /* Título */
    .payment-card h2 {
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 25px;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 10px;
        text-align: center; /* Centraliza o título */
    }

    /* Destaque do Valor */
    .payment-amount {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--price-color);
        margin-bottom: 20px;
        text-align: center;
    }
    
    .payment-amount strong {
        color: var(--accent-dark); /* Destaque em tom mais forte */
        font-size: 1.8rem;
    }
    
    /* Estilo do Elemento Stripe (Input) */
    #card-element {
        padding: 12px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        margin-bottom: 20px;
        background-color: #fff;
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    
    #card-element:focus-within {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(255, 99, 71, 0.2); /* Sombra suave no foco */
    }

    /* Estilo do Botão "Pagar" - PADRÃO LARANJA */
    .btn-pay {
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
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 0 var(--accent-dark); /* Efeito 3D sutil */
        line-height: 1;
    }
    
    .btn-pay:hover {
        transform: translateY(1px); /* Move levemente para baixo no hover */
        box-shadow: 0 3px 0 var(--accent-dark); /* Reduz a sombra */
    }
    
    .btn-pay:active {
        transform: translateY(4px); /* Pressiona o botão */
        box-shadow: 0 0 0 var(--accent-dark);
    }
    
    /* Mensagens de Status */
    #message {
        margin-top: 20px;
        font-size: 1rem;
        font-weight: 600;
        text-align: center;
    }

    #message span {
        padding: 10px 18px;
        border-radius: 6px;
        display: inline-block;
    }

    /* Mensagem de Erro */
    #message span[style*="color:red"] {
        background-color: #fff0f0;
        color: #c0392b !important;
        border: 1px solid #c0392b;
    }
    
    /* Mensagem de Sucesso */
    #message span[style*="color:green"] {
        background-color: #f0fff0;
        color: #007000 !important;
        border: 1px solid #007000;
    }

    /* Mensagem de Processamento (Amarelo/Laranja) */
    #message span[style*="color:blue"] {
        background-color: #fffbe6;
        color: #f39c12 !important;
        border: 1px solid #f39c12;
    }
</style>

<div class="checkout-wrapper">
    <div class="payment-card">
        <h2>🔒 Pagamento Seguro</h2> 
        
        <p class="payment-amount">Total a Pagar: <strong>R$ {{ isset($total) ? number_format($total, 2, ',', '.') : '0,00' }}</strong></p>

        <form id="payment-form">
            <div class="mb-3">
                <label class="form-label" style="font-weight: 600; color: var(--primary-color);">Preencha os dados do seu cartão:</label>
                <div id="card-element">
                </div>
            </div>

            <button type="submit" class="btn-pay">
                Pagar Agora <i class="bi bi-arrow-right-circle-fill ms-1"></i>
            </button>
        </form>

        <div id="message"></div>
    </div>
</div>

<script>
    // Configurações do Stripe e lógica de pagamento (permanece a mesma)
    const stripe = Stripe(@json(config('services.stripe.key')));

    const elements = stripe.elements();
    const card = elements.create("card");
    card.mount("#card-element");

    const form = document.getElementById("payment-form");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        
        // Exibe mensagem de processamento enquanto espera
        document.getElementById("message").innerHTML = 
            "<span style='color:blue; background-color: #fffbe6; border: 1px solid #f39c12;'>Processando pagamento...</span>";

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