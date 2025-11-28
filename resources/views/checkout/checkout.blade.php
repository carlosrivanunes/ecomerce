@extends('layouts.app')

@section('content')
<style>
    /* 🎨 Estilos Específicos para os Elementos do Stripe */
    .StripeElement {
        padding: 12px;
        border: 1px solid #ced4da; /* Cor de borda padrão do Bootstrap */
        border-radius: 0.25rem; /* Padrão do Bootstrap */
        background: white;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .StripeElement--focus {
        border-color: #80bdff; /* Cor de foco do Bootstrap */
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    #card-errors {
        color: var(--bs-danger); /* Cor de perigo do Bootstrap */
        margin-top: 0.5rem;
        font-size: 0.875rem;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="h3 fw-bold mb-4 text-center text-primary">
                <i class="bi bi-credit-card-fill me-2"></i> Finalizar Pagamento
            </h1>

            <div class="card shadow-lg">
                <div class="card-body p-4 p-md-5">
                    
                    {{-- 🛒 RESUMO DO PEDIDO (OPCIONAL) --}}
                    <div class="alert alert-info py-2 mb-4">
                        <i class="bi bi-cart-check me-1"></i> Total a Pagar: 
                        {{-- O valor total deve ser passado do backend para o frontend --}}
                        <span class="fw-bold">R$ {{ number_format($totalAmount, 2, ',', '.') ?? '0,00' }}</span> 
                    </div>

                    {{-- Formulário de Pagamento Stripe --}}
                    <form id="payment-form">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="card-element">
                                Detalhes do Cartão de Crédito
                            </label>
                            {{-- Elemento Card do Stripe será montado aqui --}}
                            <div id="card-element" class="form-control p-0 border-0"></div> 
                        </div>

                        {{-- Área de Erros do Stripe --}}
                        <div id="card-errors" role="alert" class="mb-4"></div>
                        
                        {{-- Botão de Submissão --}}
                        <button id="submit" class="btn btn-lg btn-success w-100">
                            <span id="button-text">
                                <i class="bi bi-lock-fill me-1"></i> Pagar Agora
                            </span>
                        </button>
                        
                        <p class="text-center text-muted small mt-3">Transação segura via Stripe.</p>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 📝 Lógica JavaScript do Stripe --}}
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // As variáveis Blade são injetadas aqui
        const stripe = Stripe('{{ $stripeKey }}');
        const elements = stripe.elements();

        // Configura e monta o elemento 'card'
        const card = elements.create('card');
        card.mount('#card-element');

        // Manipulação de Erros em Tempo Real
        card.on('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
            document.getElementById('submit').disabled = !event.complete;
        });

        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit');
        const buttonText = document.getElementById('button-text');
        const clientSecret = "{{ $clientSecret }}";

        // Lógica de Submissão do Formulário
        form.addEventListener('submit', function(ev) {
            ev.preventDefault();

            // Desabilita e mostra o estado de processamento
            submitButton.disabled = true;
            buttonText.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processando...';

            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card,
                    // Idealmente, você deve passar os detalhes do cliente autenticado aqui
                    billing_details: {
                        name: '{{ Auth::user()->name ?? 'Cliente' }}' 
                    }
                }
            }).then(function(result) {
                if (result.error) {
                    // Erro de pagamento (ex: cartão recusado)
                    document.getElementById('card-errors').textContent = result.error.message;
                    submitButton.disabled = false;
                    buttonText.innerHTML = '<i class="bi bi-lock-fill me-1"></i> Tentar Novamente';
                } else {
                    if (result.paymentIntent.status === 'succeeded') {
                        // Pagamento bem-sucedido!
                        
                        // 1. Chama a API para finalizar o pedido no backend
                        fetch('{{ route('checkout.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                payment_intent_id: result.paymentIntent.id
                            })
                        }).then(response => {
                            if(response.ok) {
                                // 2. Redireciona para o sucesso
                                alert('Pedido finalizado com sucesso!');
                                window.location.href = '{{ url('/meus-pedidos') }}'; 
                            } else {
                                // 3. Erro ao salvar o pedido no backend APÓS o sucesso do Stripe
                                alert('Pagamento aprovado, mas erro ao salvar pedido. Entre em contato com suporte.');
                                submitButton.disabled = false;
                                buttonText.innerHTML = '<i class="bi bi-check-lg me-1"></i> Suporte Necessário';
                            }
                        }).catch(error => {
                            console.error('Erro no fetch:', error);
                            alert('Erro de rede ao finalizar pedido. Tente novamente.');
                            submitButton.disabled = false;
                            buttonText.innerHTML = '<i class="bi bi-x-circle me-1"></i> Erro de Conexão';
                        });

                    } else {
                        // Outros status como 'requires_action' ou 'processing' (menos comuns com cards)
                        document.getElementById('card-errors').textContent = 'Aguardando confirmação do pagamento. Status: ' + result.paymentIntent.status;
                    }
                }
            });
        });
    });
</script>
@endsection