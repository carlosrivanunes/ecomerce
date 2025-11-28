@extends('layouts.app')

@section('content')
<style>
    /* Variáveis de Estilo Padronizadas (Laranja/Vermelho) */
    :root {
        --primary-color: #333; /* Cor escura para texto principal/títulos */
        --secondary-color: #555;
        --accent-color: #ff6347; /* Laranja Vívido para Ação Principal */
        --accent-dark: #e84c3c; /* Vermelho/Laranja Escuro para Hover e Sombra */
        --light-bg: #f8f8f8; /* Fundo Muito Claro */
        --border-color: #e0e0e0;
        --remove-color: #c0392b; /* Cor para Ação de Remover (vermelho escuro) */
    }

    /* Estilos Gerais do Carrinho */
    .cart-container {
        padding: 50px 0;
        background-color: var(--light-bg);
        min-height: 80vh;
    }

    .cart-title {
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 30px;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 10px;
        font-size: 2rem;
    }

    /* Tabela do Carrinho */
    .table-cart {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); /* Sombra mais destacada */
    }
    
    .table-cart thead th {
        background-color: var(--primary-color); /* Fundo do Header Preto/Escuro */
        color: white;
        font-weight: 600;
        border-bottom: none;
        vertical-align: middle;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-cart tbody tr:hover {
        background-color: #fcfcfc;
    }

    .table-cart td {
        vertical-align: middle;
        font-size: 1rem;
        border-color: #f0f0f0;
    }

    /* Estilo para a Quantidade - Mantendo a simplicidade */
    .quantity-cell {
        font-weight: 600;
        color: var(--secondary-color);
    }
    
    /* Destaque do Nome do Produto */
    .product-name-cell {
        font-weight: 700;
        color: var(--primary-color);
        transition: color 0.2s;
    }
    .product-name-cell:hover {
        color: var(--accent-color);
    }

    /* Total e Checkout */
    .checkout-summary {
        margin-top: 30px;
        padding: 30px;
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }
    
    .checkout-summary h4 {
        color: var(--primary-color);
    }

    .checkout-total-text {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 15px;
        padding-top: 10px;
        border-top: 1px dashed #ddd; /* Linha tracejada de separação */
    }
    
    .checkout-total-value {
        color: var(--accent-dark); /* Valor Total em destaque */
    }

    /* Botão Finalizar Compra (Estilo 3D Laranja/Vermelho) */
    .btn-checkout {
        background-color: var(--accent-color);
        border-color: var(--accent-dark);
        background: linear-gradient(180deg, var(--accent-color) 0%, var(--accent-dark) 100%);
        box-shadow: 0 4px 0 var(--accent-dark); /* Sombra 3D */
        color: white;
        font-weight: 700;
        padding: 12px 30px;
        font-size: 1.1rem;
        border-radius: 8px;
        transition: transform 0.2s, box-shadow 0.2s;
        text-transform: uppercase;
    }

    .btn-checkout:hover {
        transform: translateY(1px);
        box-shadow: 0 3px 0 var(--accent-dark);
        color: white; /* Garante que o texto permaneça branco no hover */
    }
    .btn-checkout:active {
        transform: translateY(4px);
        box-shadow: none;
    }
    
    /* Botão Remover Item (Pequeno e Vermelho) */
    .btn-remove-item {
        background-color: #e74c3c;
        border-color: var(--remove-color);
        color: white;
        transition: background-color 0.2s;
    }
    
    .btn-remove-item:hover {
        background-color: var(--remove-color);
        border-color: var(--remove-color);
    }
    
    /* Estilo do Carrinho Vazio */
    .empty-cart-message {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        padding: 80px 30px;
    }
    .empty-cart-message .bi-cart-x {
        color: var(--accent-dark);
        opacity: 0.7;
    }
</style>

<div class="container cart-container">
    <h1 class="cart-title">🛒 Seu Carrinho de Compras</h1>

    @if($cartItems->isEmpty())
        <div class="text-center empty-cart-message">
            <i class="bi bi-cart-x" style="font-size: 3rem;"></i>
            <p class="text-muted mt-4 h4">Seu carrinho está vazio.</p>
            <!-- Botão Secundário para Continuar Comprando (Cor primária/escura) -->
            <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3" style="background-color: var(--primary-color); border-color: var(--primary-color);">
                Continuar Comprando
            </a>
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
                                        <!-- Se você tiver a imagem, descomente esta linha. Caso contrário, mantenha o nome simples. -->
                                        {{-- 
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px; border-radius: 4px; border: 1px solid #eee;"> 
                                        --}}
                                        <a href="{{ route('products.show', $item->product->id) }}" class="product-name-cell">
                                            {{ $item->product->name }}
                                        </a>
                                    </div>
                                </td>
                                <td>R$ {{ number_format($item->product->price, 2, ',', '.') }}</td>
                                <td class="quantity-cell">
                                    {{ $item->quantity }}
                                    <!-- Aqui você adicionaria formulários para + / - se necessário -->
                                </td>
                                <td style="font-weight: 700; color: var(--accent-dark);">R$ {{ number_format($item->product->price * $item->quantity, 2, ',', '.') }}</td>
                                <td>
                                    <!-- Botão de Remoção -->
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-remove-item" title="Remover item">
                                            <i class="bi bi-x-lg"></i>
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
                    <h4 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">Resumo do Pedido</h4>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal:</span>
                        <span style="font-weight: 600; color: var(--secondary-color);">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                    </div>
                    
                    <!-- Simulação de Frete/Desconto (Opcional, mas comum em resumos) -->
                    <div class="d-flex justify-content-between mb-3 text-success">
                        <span>Desconto:</span>
                        <span style="font-weight: 500;">R$ 0,00</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-4 checkout-total-text">
                        <span>Total:</span>
                        <span class="checkout-total-value">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                    </div>
                    
                    <a href="{{ route('checkout.index') }}" class="btn btn-checkout w-100">
                        <i class="bi bi-check-circle-fill"></i> FINALIZAR COMPRA
                    </a>
                </div>
                
                <div class="text-center mt-3">
                    <a href="{{ route('products.index') }}" class="text-secondary text-decoration-none" style="font-size: 0.9rem;">
                        <i class="bi bi-arrow-left"></i> Continuar Comprando
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection