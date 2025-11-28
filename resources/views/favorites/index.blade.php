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
    
    .card-image-wrapper img {
        width: 100%; 
        height: 100%; 
        object-fit: cover;
        transition: transform 0.3s;
    }
    .product-card:hover .card-image-wrapper img {
        transform: scale(1.05);
    }

    /* Preço, Título e Descrição */
    .card-body .card-title {
        color: #333;
        font-weight: 600;
        font-size: 1.2rem;
    }
    /* Link do Título para Detalhes */
    .card-body .card-title a {
        text-decoration: none;
        color: inherit;
        transition: color 0.2s;
    }
    .card-body .card-title a:hover {
        color: var(--accent-color);
    }

    .product-price {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .product-details {
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
    
    /* NOVO ESTILO: Botão Ver Detalhes */
    .btn-view-details {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        font-weight: 600; /* Mais destaque para o CTA */
        color: white;
        transition: background-color 0.3s;
        flex-grow: 1;
        padding: 8px 10px; /* Padronizando padding */
    }
    
    .btn-view-details:hover {
        background-color: #00695c;
        border-color: #00695c;
    }
    /* FIM NOVO ESTILO */

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
            <h1 class="catalog-title"><i class="bi bi-shop-window me-2"></i> Catálogo de Produtos</h1>
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
                        
                        {{-- IMAGEM/LINK PARA DETALHES --}}
                        <a href="{{ route('products.show', $product->id) }}" class="card-image-wrapper">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #999;">
                                    <i class="bi bi-image" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            
                            {{-- BOTÃO DE FAVORITO (Sempre por cima) --}}
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
                        </a>

                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('products.show', $product->id) }}">
                                    {{ $product->name }}
                                </a>
                            </h5>
                            <p class="text-muted" style="font-size: 0.85rem; margin-bottom: 15px;">{{ Str::limit($product->description, 80) }}</p>
                            
                            <div class="product-details">
                                <span class="product-price">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                                <span style="color: #ffc107; font-size: 0.9rem;">
                                    <i class="bi bi-star-fill"></i> 4.5 (120) </span>
                            </div>
                        </div>

                        <div class="product-card-footer">
                            
                            {{-- MUDANÇA: BOTÃO VER DETALHES --}}
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-view-details w-100">
                                <i class="bi bi-eye-fill"></i> Ver Detalhes
                            </a>
                            {{-- FIM MUDANÇA --}}

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
                    @if(auth()->user()?->is_admin)
                        <a href="{{ route('products.create') }}" class="btn btn-new-product mt-3">
                            <i class="bi bi-plus-circle"></i> Criar Primeiro Produto
                        </a>
                    @endif
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection