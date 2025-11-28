@extends('layouts.app')

@section('content')
<style>
    /* Variáveis de Estilo da Página Inicial (Padronização) */
    :root {
        --primary-color: #5d5d81; /* Índigo Suave */
        --accent-color: #00897b; /* Verde-Água (Teal) para Ação */
        --dark-bg: #1f2833;
        --light-bg: #f4f7f9; /* Fundo Muito Claro */
        --card-shadow-hover: 0 4px 10px rgba(0, 0, 0, 0.1); /* Sombra mais visível no hover */
    }

    /* Estilo do Container da Página */
    .product-catalog-bg {
        background: var(--light-bg);
        padding: 60px 20px 100px;
    }

    /* Estilo do Cabeçalho da Página */
    .catalog-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 50px;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 15px;
    }

    .catalog-title {
        font-weight: 700;
        color: var(--primary-color);
        margin: 0;
        font-size: 2rem;
    }
    
    .btn-new-product {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        font-weight: 600;
        transition: background-color 0.3s;
    }

    .btn-new-product:hover {
        background-color: #00695c;
        border-color: #00695c;
    }

    /* Estilo dos Cards de Produto (Padronizado com a Index) */
    .product-card {
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: none;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--card-shadow-hover);
    }

    .card-image-wrapper {
        height: 280px;
        overflow: hidden;
        background: #fcfcfc;
        position: relative;
    }
    
    /* Preço, Título e Descrição */
    .card-body .card-title {
        color: #333;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .product-price {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .product-details {
        /* Alinhamento dos detalhes (preço/avaliação) */
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-top: 10px;
    }

    /* Card Footer - Botões de Ação */
    .product-card-footer {
        background: white;
        border-top: 1px solid #eee;
        display: flex;
        gap: 8px;
        padding: 10px 15px;
        align-items: center;
    }
    
    .btn-add-cart-form {
        flex-grow: 1;
        display: flex;
        gap: 5px;
    }
    
    .btn-add-cart {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        font-weight: 500;
        transition: background-color 0.3s;
    }
    
    .btn-add-cart:hover {
        background-color: #00695c;
        border-color: #00695c;
    }

    /* Botão Favoritos */
    .btn-favorite {
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid #eee;
        transition: color 0.3s, background 0.3s;
    }
    
    .btn-favorite:hover {
        background: white;
        color: #e74c3c !important;
    }
    
    .favorite-icon-filled {
        color: #e74c3c !important;
    }

    /* Botão Admin */
    .btn-edit-admin {
        background-color: #f39c12;
        border-color: #f39c12;
        color: white;
    }
</style>

<div class="product-catalog-bg">
    <div class="container">
        <div class="catalog-header">
            <h1 class="catalog-title">Catálogo de Produtos</h1>
            @if(auth()->user()?->is_admin)
                <a href="{{ route('products.create') }}" class="btn btn-new-product">
                    <i class="bi bi-plus-circle"></i> Novo Produto
                </a>
            @endif
        </div>

        <div class="row g-4">
            @forelse($products as $product)
                @php
                    // Recalcula o estado do favorito para cada card
                    $isFavorite = auth()->check() && auth()->user()->favorites()->where('product_id', $product->id)->exists();
                @endphp
                
                <div class="col-sm-6 col-lg-4">
                    <div class="card h-100 product-card">
                        
                        <div class="card-image-wrapper">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #999;">
                                    <i class="bi bi-image" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            
                            @auth
                                <form action="{{ route('favorites.toggle', $product->id) }}" method="POST" style="position: absolute; top: 10px; right: 10px;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-favorite">
                                        <i class="bi {{ $isFavorite ? 'bi-heart-fill favorite-icon-filled' : 'bi-heart' }}" style="font-size: 1.1rem;"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-sm btn-favorite" style="position: absolute; top: 10px; right: 10px;">
                                    <i class="bi bi-heart" style="font-size: 1.1rem;"></i>
                                </a>
                            @endauth
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="text-muted" style="font-size: 0.85rem; margin-bottom: 15px;">{{ Str::limit($product->description, 80) }}</p>
                            
                            <div class="product-details">
                                <span class="product-price">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                                <span style="color: #ffc107; font-size: 0.9rem;">
                                    <i class="bi bi-star-fill"></i> 4.5 (120) </span>
                            </div>
                        </div>

                        <div class="product-card-footer">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="btn-add-cart-form">
                                @csrf
                                <input type="number" name="quantity" value="1" min="1" class="form-control form-control-sm" style="width: 60px; text-align: center;">
                                <button type="submit" class="btn btn-sm btn-add-cart flex-grow-1">
                                    <i class="bi bi-cart-plus"></i> Adicionar
                                </button>
                            </form>

                            @if(auth()->user()?->is_admin)
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-edit-admin" title="Editar Produto">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            @endif
                            
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-box-seam" style="font-size: 2.5rem; color: #aeb6bf;"></i>
                    <p class="text-muted mt-3">Nenhum produto encontrado no catálogo.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection