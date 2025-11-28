@extends('layouts.app')

@section('content')
<style>
    /* Variáveis de Estilo Padronizadas */
    :root {
        --primary-color: #5d5d81; /* Índigo Suave */
        --accent-color: #00897b; /* Verde-Água (Teal) para Ação */
        --light-bg: #f4f7f9;
        --border-color: #e0e0e0;
        --price-color: #2c3e50; /* Cor escura para preços */
    }

    /* Estilo do Container e Título */
    .container {
        padding-top: 50px;
        padding-bottom: 50px;
    }

    .cart-title-main {
        font-weight: 700;
        color: var(--primary-color);
    }
    
    /* Botões Padrão */
    .btn-primary {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
    }
    .btn-primary:hover {
        background-color: #00695c;
        border-color: #00695c;
    }

    /* Estilo do Card de Item (Lista) */
    .cart-item-card {
        border: 1px solid var(--border-color);
        border-radius: 6px;
        transition: box-shadow 0.3s;
    }
    .cart-item-card:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05) !important;
    }

    .cart-item-card .card-title {
        font-weight: 600;
        color: var(--primary-color);
    }

    /* Estilo do Subtotal do Item */
    .item-subtotal {
        color: var(--price-color);
        font-size: 1.5rem;
        font-weight: 700;
    }

    /* Estilo do Resumo do Pedido (Lateral) */
    .order-summary-card {
        border: 1px solid var(--border-color);
        border-radius: 6px;
    }

    .order-summary-card .card-title {
        font-weight: 600;
        color: var(--primary-color);
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 10px;
    }

    .list-group-item {
        border-color: #f0f0f0;
    }
    
    /* Destaque do Total Final */
    .list-group-item.total-final span {
        font-weight: 700;
        color: var(--price-color);
    }
    
    .list-group-item.total-final .total-value {
        color: var(--accent-color);
    }
</style>

<div class="container py-5">
    {{-- Título e botão Continuar Comprando --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 cart-title-main"><i class="bi bi-cart3 me-2"></i>Meu Carrinho</h1>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Continuar Comprando
        </a>
    </div>

    {{-- Mensagens de sucesso --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(Cart::getContent()->count() > 0)
        <div class="row">
            {{-- Coluna da Lista de Itens --}}
            <div class="col-lg-8">
                @foreach(Cart::getContent() as $item)
                <div class="card mb-3 shadow-sm border-0 cart-item-card">
                    <div class="row g-0">

                        {{-- *** AQUI É EXIBIDA A IMAGEM *** --}}
                        <div class="col-md-2 d-flex align-items-center justify-content-center p-2">
                            @php
                                $imageUrl = isset($item->attributes['image']) && $item->attributes['image']
                                            ? asset('storage/' . $item->attributes['image'])
                                            : 'https://via.placeholder.com/100?text=Sem+Img';
                            @endphp
                            <img src="{{ $imageUrl }}"
                                class="img-fluid rounded"
                                alt="{{ $item->name }}"
                                style="max-height: 100px; max-width: 100px; object-fit: contain; border: 1px solid #eee;">
                        </div>


                        {{-- Coluna dos Detalhes (Nome, Preço, Ações) --}}
                        <div class="col-md-10">
                            <div class="card-body">
                                {{-- Nome e Subtotal --}}
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <span class="item-subtotal">
                                        R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}
                                    </span>
                                </div>
                                
                                {{-- Preço Unitário --}}
                                <p class="card-text text-muted mb-2">
                                    Preço Unitário: R$ {{ number_format($item->price, 2, ',', '.') }}
                                </p>
                                
                                {{-- Ações (Atualizar/Remover) --}}
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    {{-- Formulário Atualizar --}}
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        @method('PATCH')
                                        <label for="qty-{{ $item->id }}" class="me-2 text-muted" style="font-size: 0.9rem;">Qtd:</label>
                                        <input type="number" id="qty-{{ $item->id }}" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm" style="width: 70px;">
                                        <button type="submit" class="btn btn-primary btn-sm ms-2" title="Atualizar Quantidade"><i class="bi bi-arrow-repeat"></i></button>
                                    </form>
                                    
                                    {{-- Formulário Remover --}}
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Remover Item"><i class="bi bi-trash-fill"></i> Remover</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Coluna do Resumo do Pedido --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 order-summary-card sticky-top" style="top: 2rem;">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Resumo do Pedido</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Subtotal ({{ Cart::getTotalQuantity() }} itens)</span>
                                <span>R$ {{ number_format(Cart::getSubTotal(), 2, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Frete Estimado</span>
                                <span class="text-success fw-bold">Grátis</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 fw-bold h5 total-final">
                                <span>Total</span>
                                <span class="total-value">R$ {{ number_format(Cart::getTotal(), 2, ',', '.') }}</span>
                            </li>
                        </ul>
                        <div class="d-grid gap-2 mt-4">
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg">
                                Finalizar Compra <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                        
                        {{-- Simulação da área de Pagamento (mantida para contexto) --}}
                        <hr class="mt-4 mb-3">
                        <p class="text-muted small text-center">Pagamento seguro via Stripe</p>
                        
                    </div>
                </div>
            </div>
        </div>

    @else
        {{-- Mensagem de Carrinho Vazio --}}
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm text-center py-5" style="border-radius: 8px;">
                    <div class="card-body">
                        <i class="bi bi-cart-x" style="font-size: 4rem; color: var(--primary-color);"></i>
                        <h3 class="mt-4 cart-title-main">Seu carrinho está vazio.</h3>
                        <p class="text-muted">Parece que você ainda não adicionou nenhum produto.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                            <i class="bi bi-shop me-1"></i> Ir para Produtos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
{{-- Seção de Scripts não alterada, apenas movida para baixo --}}
<script src="https://js.stripe.com/v3/"></script>
<script>
    // ... Seu código JavaScript/Stripe original ...
    const stripe = Stripe('{{ $stripeKey }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    card.on('change', function(event) {
        document.getElementById('card-errors').textContent = event.error ? event.error.message : '';
    });

    const form = document.getElementById('payment-form');
    const clientSecret = "{{ $stripeSecret }}";

    if (form) { // Verifica se o formulário existe (só existirá na página de checkout, não na de carrinho)
        form.addEventListener('submit', function(ev) {
            ev.preventDefault();

            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: 'Cliente Teste'
                    }
                }
            }).then(function(result) {
                if (result.error) {
                    document.getElementById('card-errors').textContent = result.error.message;
                } else if (result.paymentIntent.status === 'succeeded') {
                    fetch("{{ route('checkout.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({})
                    }).then(response => {
                        if (response.ok) {
                            window.location.href = "{{ route('orders.index') }}";
                        } else {
                            alert("Erro ao salvar pedido!");
                        }
                    });
                }
            });
        });
    }
</script>
@endsection