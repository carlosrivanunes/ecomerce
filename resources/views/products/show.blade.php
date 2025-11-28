@extends('layouts.app')

@section('content')
<style>
    /* Variáveis de Estilo Padronizadas */
    :root {
        --primary-color: #5d5d81; /* Índigo Suave */
        --accent-color: #00897b; /* Verde-Água (Teal) para Ação */
        --light-bg: #f4f7f9;
        --border-color: #e0e0e0;
        --price-color: #00897b; /* Preços na cor de destaque */
    }

    /* Container Principal */
    .container {
        background-color: var(--light-bg);
        min-height: 80vh;
        padding-top: 60px !important;
        padding-bottom: 60px !important;
    }

    /* Coluna de Detalhes */
    .product-details {
        padding-left: 30px;
    }
    
    /* Título do Produto */
    .product-details h1 {
        color: var(--primary-color);
        font-weight: 700 !important;
        font-size: 2.5rem;
        margin-bottom: 10px;
    }
    
    /* Preço */
    .product-details .product-price {
        color: var(--price-color);
        font-weight: 700 !important;
        font-size: 3rem;
        margin-top: 20px;
        margin-bottom: 25px;
        letter-spacing: -1px;
    }
    
    /* Descrição */
    .product-details .lead {
        color: #555;
        font-size: 1.15rem;
    }

    /* AÇÃO PRINCIPAL: Adicionar ao Carrinho */
    .btn-main-action {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        color: white;
        font-weight: 600;
        font-size: 1.2rem;
        padding: 12px 20px;
        transition: background-color 0.3s;
    }
    .btn-main-action:hover {
        background-color: #00695c;
        border-color: #00695c;
    }

    /* AÇÃO SECUNDÁRIA: Voltar ao Catálogo */
    .btn-secondary-action {
        color: var(--primary-color);
        border-color: var(--primary-color);
        font-weight: 500;
        padding: 12px 20px;
        transition: background-color 0.3s;
    }
    .btn-secondary-action:hover {
        background-color: var(--primary-color);
        color: white;
    }

    /* Imagem */
    .product-image {
        max-height: 600px;
        width: 100%;
        object-fit: cover;
    }

</style>

<div class="container py-5">
    
    <div class="row align-items-center">
        
        {{-- Coluna da Imagem --}}
        <div class="col-md-6">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" 
                     class="img-fluid rounded shadow-lg mb-4 mb-md-0 product-image" 
                     alt="{{ $product->name }}">
            @else
                <img src="https://via.placeholder.com/600x400?text=Sem+Imagem" 
                     class="img-fluid rounded shadow-lg mb-4 mb-md-0 product-image" 
                     alt="Sem imagem">
            @endif
        </div>

        {{-- Coluna de Detalhes --}}
        <div class="col-md-6 product-details">
            
            <h1 class="display-5 fw-bold">{{ $product->name }}</h1>
            
            <p class="lead text-muted mt-3">{{ $product->description }}</p>

            <h2 class="product-price my-4 fw-bold">
                R$ {{ number_format($product->price, 2, ',', '.') }}
            </h2>

            {{-- AÇÃO PRINCIPAL: Formulário para Adicionar ao Carrinho --}}
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                
                {{-- Campo de Quantidade (Opcional, mas útil) --}}
                <div class="mb-3" style="max-width: 150px;">
                    <label for="quantity" class="form-label fw-bold" style="color: var(--primary-color);">Quantidade:</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1">
                </div> 

                {{-- Botão de Ação Primária (CTA) --}}
                <button type="submit" class="btn btn-main-action btn-lg w-100 mb-3">
                    <i class="bi bi-cart-plus-fill me-2"></i> Adicionar ao Carrinho
                </button>
            </form>

            {{-- Ação Secundária: Voltar (com estilo mais sutil) --}}
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-secondary-action w-100">
                <i class="bi bi-arrow-left me-2"></i> Voltar ao Catálogo
            </a>
            
        </div>
    </div>
</div>
@endsection