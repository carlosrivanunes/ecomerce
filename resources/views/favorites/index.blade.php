@extends('layouts.app')

@section('content')
<style>
    /* Variáveis de Estilo Padronizadas (Laranja/Vermelho) */
    :root {
        --primary-color: #333; /* Cor escura para texto principal/títulos */
        --secondary-color: #555;
        --accent-color: #ff6347; /* Laranja para Ação (Cor principal do CTA) */
        --accent-dark: #e84c3c; /* Vermelho/Laranja Escuro para Hover */
        --light-bg: #f8f8f8; /* Fundo Muito Claro */
        --card-shadow-hover: 0 6px 15px rgba(0, 0, 0, 0.1);
        --price-color: var(--accent-dark); /* Destaque do preço em cor forte */
        --favorite-color: #e74c3c; /* Cor do Coração (vermelho padrão) */
    }

    /* Estilo do Container da Página */
    .favorites-bg {
        background: var(--light-bg);
        padding: 60px 20px 100px;
        min-height: 80vh;
    }

    /* Estilo do Cabeçalho da Página */
    .favorites-header {
        margin-bottom: 50px;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 15px;
    }

    .favorites-title {
        font-weight: 700;
        color: var(--primary-color);
        margin: 0;
        font-size: 2rem;
    }

    /* Estilo dos Cards de Produto (IDÊNTICO ao Catálogo) */
    .product-card {
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: none;
        background: white;
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
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.3rem;
    }
    .card-body .card-title a {
        text-decoration: none;
        color: inherit;
        transition: color 0.2s;
    }
    .card-body .card-title a:hover {
        color: var(--accent-color);
    }

    .product-price {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--price-color);
    }
    
    .product-details {
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-top: 10px;
    }

    /* Card Footer - Botões de Ação */
    .product-card-footer {
        background: #fcfcfc;
        border-top: 1px solid #eee;
        display: flex;
        gap: 8px;
        padding: 10px 15px;
        align-items: center;
    }
    
    /* Botão Ver Detalhes */
    .btn-view-details {
        background-color: var(--accent-color);
        border-color: var(--accent-dark);
        background: linear-gradient(180deg, var(--accent-color) 0%, var(--accent-dark) 100%);
        box-shadow: 0 3px 0 var(--accent-dark);
        color: white;
        font-weight: 700;
        transition: transform 0.2s, box-shadow 0.2s;
        flex-grow: 1;
        padding: 8px 10px;
        border-radius: 6px;
    }
    
    .btn-view-details:hover {
        transform: translateY(1px);
        box-shadow: 0 2px 0 var(--accent-dark);
    }
    .btn-view-details:active {
        transform: translateY(3px);
        box-shadow: none;
    }

    /* Botão Remover (Será usado no lugar do Admin Edit e deve seguir o padrão de AÇÃO SECUNDÁRIA) */
    .btn-remove-favorite {
        background-color: #e74c3c; /* Vermelho/Danger */
        border-color: #c0392b;
        background: linear-gradient(180deg, #e74c3c 0%, #c0392b 100%);
        box-shadow: 0 3px 0 #c0392b;
        color: white;
        font-weight: 600;
        transition: transform 0.2s, box-shadow 0.2s;
        border-radius: 6px;
        padding: 8px 10px;
    }
    
    .btn-remove-favorite:hover {
        transform: translateY(1px);
        box-shadow: 0 2px 0 #c0392b;
    }
    
    /* Botão Coração (Ícone) */
    .favorite-icon-filled {
        color: var(--favorite-color) !important;
    }

    /* Estilo de Carrinho Vazio */
    .card-empty {
        border-radius: 8px;
    }
    .card-empty .bi-heart-break {
        color: var(--favorite-color) !important;
        opacity: 0.6;
    }
    .card-empty h3 {
        color: var(--primary-color);
        font-weight: 600;
    }
    
</style>

<div class="favorites-bg">
    <div class="container">
        <div class="favorites-header">
            <h1 class="favorites-title"><i class="bi bi-heart-fill me-2" style="color: var(--favorite-color);"></i> Meus Favoritos</h1>
        </div>

        <div class="row g-4">
            @forelse($favorites as $product)
                @php
                    $isFavorite = true;
                @endphp

                <div class="col-sm-6 col-lg-4">
                    <div class="card h-100 product-card">
                        {{-- use $product diretamente --}}
                        <div class="card-image-wrapper">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                            @else
                                <i class="bi bi-image" style="font-size:2rem;color:#999;"></i>
                            @endif
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="text-muted">{{ Str::limit($product->description, 120) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">R$ {{ number_format($product->price,2,',','.') }}</span>
                                <form action="{{ route('favorites.toggle', $product->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Remover</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Você não tem favoritos.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection