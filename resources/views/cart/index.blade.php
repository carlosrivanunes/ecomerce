@extends('layouts.app')

@section('content')
<style>
    /* Variáveis de Estilo da Página Inicial (Padronização) */
    :root {
        --primary-color: #5d5d81; /* Índigo Suave */
        --accent-color: #00897b; /* Verde-Água (Teal) para Ação */
        --light-bg: #f4f7f9;
        --border-color: #e0e0e0;
    }

    /* Estilos Gerais do Carrinho */
    .cart-container {
        padding: 50px 0;
        background-color: var(--light-bg);
        min-height: 80vh; /* Para garantir que o fundo claro cubra a página */
    }

    .cart-title {
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 30px;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 10px;
    }

    /* Tabela do Carrinho */
    .table-cart {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .table-cart thead th {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        border-bottom: none;
        vertical-align: middle;
    }

    .table-cart tbody tr:hover {
        background-color: #f9f9f9;
    }

    .table-cart td {
        vertical-align: middle;
        font-size: 1rem;
        border-color: #f0f0f0;
    }

    /* Total e Checkout */
    .checkout-summary {
        margin-top: 30px;
        padding: 20px;
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .checkout-total-text {
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
    }
    
    .checkout-total-value {
        color: var(--accent-color);
    }

    .btn-checkout {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        font-weight: 600;
        padding: 10px 30px;
        font-size: 1.1rem;
    }

    .btn-checkout:hover {
        background-color: #00695c;
        border-color: #00695c;
    }
    
    .btn-remove-item {
        background-color: #e74c3c;
        border-color: #e74c3c;
    }
    
    .btn-remove-item:hover {
        background-color: #c0392b;
        border-color: #c0392b;
    }
</style>

<div class="container cart-container">
    <h1 class="cart-title">🛒 Seu Carrinho de Compras</h1>

    @if($cartItems->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-cart-x" style="font-size: 3rem; color: #aeb6bf;"></i>
            <p class="text-muted mt-3 h4">Seu carrinho está vazio.</p>
            <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Continuar Comprando</a>
        </div>
    @else
        <div class="row">
            <div class="col-lg-8">
                <table class="table table-striped table-cart">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 40%;">Produto</th>
                            <th scope="col" style="width: 15%;">Preço</th>
                            <th scope="col" style="width: 15%;">Quantidade</th>
                            <th scope="col" style="width: 15%;">Total</th>
                            <th scope="col" style="width: 15%;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{-- <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px; border-radius: 4px;"> --}}
                                        <span style="font-weight: 500; color: #333;">{{ $item->product->name }}</span>
                                    </div>
                                </td>
                                <td>R$ {{ number_format($item->product->price, 2, ',', '.') }}</td>
                                <td>
                                    {{ $item->quantity }}
                                </td>
                                <td style="font-weight: 600;">R$ {{ number_format($item->product->price * $item->quantity, 2, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-remove-item">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-lg-4">
                <div class="checkout-summary">
                    <h4 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; color: var(--primary-color);">Resumo do Pedido</h4>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal:</span>
                        <span style="font-weight: 500;">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-4 checkout-total-text">
                        <span>Total:</span>
                        <span class="checkout-total-value">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                    </div>
                    
                    <a href="{{ route('checkout.index') }}" class="btn btn-checkout w-100">
                        <i class="bi bi-check-circle-fill"></i> Finalizar Compra
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection