@extends('layouts.app')

@section('content')
...
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="..." crossorigin="anonymous"></script>

<style>
    /* Variáveis de Estilo para Padronização (Laranja/Vermelho Padrão da Imagem) */
    :root {
        --primary-color: #34495e; /* Azul Escuro Suave para Títulos/Textos */
        --accent-color: #ff6633; /* Laranja Vívido para Ação Principal (Adicionar ao Carrinho) */
        --admin-edit-color: #ff9933; /* Amarelo/Laranja Suave para Editar (Padrão da Imagem) */
        --dark-bg: #2c3e50;
        --light-bg: #f8f9fa; /* Fundo Muito Claro */
        --card-shadow-hover: 0 4px 12px rgba(0, 0, 0, 0.1);
        --product-price-color: #ff6633; /* Preço cor de destaque */
    }

    /* Estilo Geral e Container */
    .product-catalog-bg {
        background: var(--light-bg);
        padding: 40px 15px 80px;
    }

    /* Cabeçalho */
    .catalog-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
        padding-bottom: 10px;
    }

    .catalog-title {
        font-weight: 700;
        color: var(--primary-color);
        margin: 0;
        font-size: 1.8rem;
    }
    
    /* Botão Novo Produto (Laranja/Vermelho) - Igual ao da imagem */
    .btn-new-product {
        background-color: #ff5533; /* Vermelho/Laranja mais próximo do exemplo */
        border-color: #ff5533;
        font-weight: 600;
        transition: background-color 0.3s;
        color: white;
    }

    .btn-new-product:hover {
        background-color: #e64d2e;
        border-color: #e64d2e;
    }

    /* Estilo dos Cards de Produto - PADRÃO LISTA VERTICAL DA IMAGEM */
    .product-card-list-item {
        margin-bottom: 20px;
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: box-shadow 0.3s ease-in-out;
    }

    .product-card-list-item:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Layout interno do Card (flexível para a imagem ao lado) */
    .product-card-content {
        display: flex;
        align-items: stretch; /* Garante que os itens tenham a mesma altura */
    }

    /* Área da Imagem (fixa na esquerda) */
    .card-image-list-wrapper {
        width: 150px; /* Largura fixa para a imagem, como na imagem de exemplo */
        height: 150px;
        overflow: hidden;
        position: relative;
        flex-shrink: 0;
        border-radius: 4px 0 0 4px;
    }
    
    /* Posição do Coração (PADRÃO DA IMAGEM) */
    .favorite-toggle-list {
        position: absolute; 
        top: 8px; 
        right: 8px;
        z-index: 10;
    }
    
    .favorite-toggle-list .btn-favorite {
        background: rgba(255, 255, 255, 0.9);
        border: none;
        padding: 4px 6px;
        line-height: 1;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .favorite-toggle-list .bi-heart, .favorite-toggle-list .bi-heart-fill {
        font-size: 1.1rem;
    }
    
    .favorite-icon-filled {
        color: #e74c3c !important; /* Coração preenchido vermelho */
    }

    /* Corpo dos Detalhes (flexível no centro) */
    .card-body-list {
        padding: 15px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    
    .card-title {
        color: var(--primary-color);
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 3px;
    }
    
    /* Preço e Avaliação */
    .product-details {
        display: flex;
        align-items: center;
        margin-top: 5px;
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--product-price-color); /* Preço com a cor de destaque (Laranja) */
        margin-right: 15px;
    }
    
    /* Área dos Botões (fixa na direita) */
    .card-actions-list {
        width: 250px; /* Largura para os botões */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 15px;
        border-left: 1px solid #f0f0f0;
        gap: 8px;
    }
    
    /* Botão Adicionar ao Carrinho (Padronização Laranja da Imagem) */
    .btn-add-cart-list {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        font-weight: 600;
        color: white;
        font-size: 0.9rem;
        transition: background-color 0.3s;
        width: 100%;
        text-transform: uppercase;
        padding: 8px 15px;
    }
    
    .btn-add-cart-list:hover {
        background-color: #e65220;
        border-color: #e65220;
    }

    /* Botões Admin */
    .admin-buttons-list {
        display: flex;
        gap: 5px;
        width: 100%;
        justify-content: flex-end;
    }

    /* Botão Editar (PADRÃO AMARELO/LARANJA DA IMAGEM) */
    .btn-edit-admin {
        background-color: var(--admin-edit-color); 
        border-color: var(--admin-edit-color);
        color: white;
        padding: 5px 10px;
    }
    
    .btn-edit-admin:hover {
        background-color: #e68a00;
        border-color: #e68a00;
    }
    
    /* Botão Excluir (Vermelho) */
    .btn-delete-admin {
        background-color: #e74c3c; 
        border-color: #e74c3c;
        color: white;
        padding: 5px 10px;
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .product-card-content {
            flex-direction: column;
        }
        .card-image-list-wrapper {
            width: 100%;
            height: 200px;
            border-radius: 4px 4px 0 0;
        }
        .card-actions-list {
            width: 100%;
            border-left: none;
            border-top: 1px solid #f0f0f0;
            flex-direction: row;
        }
        .card-body-list {
            padding-bottom: 5px;
        }
    }
</style>

<div class="product-catalog-bg">
    <div class="container">
        <div class="catalog-header">
            <h1 class="catalog-title">Catálogo de Produtos</h1>
            @if(auth()->user()?->is_admin)
                <a href="{{ route('products.create') }}" class="btn btn-new-product rounded-pill px-4 py-2">
                    <i class="bi bi-plus-circle"></i> Novo Produto
                </a>
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                @forelse($products as $product)
                    @php
                        $isFavorite = auth()->check() && auth()->user()->favorites()->where('product_id', $product->id)->exists();
                    @endphp
                    
                    <div class="product-card-list-item">
                        <div class="product-card-content">
                            
                            <div class="card-image-list-wrapper">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #999;">
                                        <i class="bi bi-image" style="font-size: 2rem;"></i>
                                    </div>
                                @endif
                                
                                <div class="favorite-toggle-list">
                                    @auth
                                        <form action="{{ route('favorites.toggle', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-favorite rounded-circle p-0" title="Favoritar">
                                                <i class="bi {{ $isFavorite ? 'bi-heart-fill favorite-icon-filled' : 'bi-heart' }}"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-sm btn-favorite rounded-circle p-0" title="Faça login para favoritar">
                                            <i class="bi bi-heart"></i>
                                        </a>
                                    @endauth
                                </div>
                            </div>

                            <div class="card-body-list">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 10px;">{{ Str::limit($product->description, 150) }}</p>
                                
                                <div class="product-details mt-auto"> <span class="product-price">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                                    <span style="color: #ffc107; font-size: 0.9rem;">
                                        <i class="bi bi-star-fill"></i> 4.5
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-actions-list">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-100">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-add-cart-list">
                                        ADICIONAR AO CARRINHO <i class="bi bi-cart-plus-fill"></i>
                                    </button>
                                </form>

                                @if(auth()->user()?->is_admin)
                                    <div class="admin-buttons-list">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-edit-admin rounded" title="Editar Produto">
                                            <i class="bi bi-pencil-fill"></i> 
                                        </a>
                                        
                                        <button type="button" class="btn btn-sm btn-delete-admin rounded" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $product->id }}" title="Excluir Produto">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-box-seam" style="font-size: 3rem; color: #aeb6bf;"></i>
                        <p class="text-muted mt-3 h5">Nenhum produto encontrado no catálogo.</p>
                        @if(auth()->user()?->is_admin)
                            <a href="{{ route('products.create') }}" class="btn btn-new-product mt-3">Cadastrar Novo Produto</a>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modais de Exclusão (FORA DO LOOP) -->
@if(auth()->user()?->is_admin)
    @foreach($products as $product)
        <div class="modal fade" id="deleteModal-{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel-{{ $product->id }}">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Tem certeza de que deseja excluir o produto <strong>"{{ $product->name }}"</strong>? Esta ação é irreversível.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Sim, Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

@endsection