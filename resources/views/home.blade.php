@extends('layouts.app')

@section('content')
<style>
    /* 1. Estilos Base e Cores - Elegante e Profundo */
    :root {
        --primary-color: #5d5d81; /* Índigo Suave */
        --accent-color: #00897b; /* Verde-Água (Teal) para Ação */
        --dark-bg: #1f2833; /* Azul Escuro Quase Preto */
        --light-bg: #f4f7f9; /* Fundo Muito Claro */
        --card-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); /* Sombra Leve */
    }

    /* 2. Hero Section */
    .hero-section {
        /* Mantendo o gradiente forte para a seção principal */
        background: linear-gradient(135deg, #4a148c 0%, #283593 100%); 
        color: white;
        padding: 120px 20px;
        text-align: center;
    }

    .hero-title {
        font-size: 3.8rem;
        font-weight: 800;
        margin-bottom: 25px;
        letter-spacing: -1px;
    }

    .hero-btn {
        padding: 15px 50px;
        font-weight: 600;
        font-size: 1.1rem;
        background-color: white !important;
        border-color: white !important;
        color: #4a148c !important;
        transition: all 0.3s;
        border-radius: 8px;
    }

    .hero-btn:hover {
        background-color: #f0f0f0 !important;
        transform: translateY(-2px);
    }

    /* 3. Products Section */
    .products-section {
        padding: 80px 20px;
        background: var(--light-bg);
    }

    .section-title {
        text-align: center;
        margin-bottom: 60px;
        font-weight: 700;
        color: var(--primary-color);
    }

    /* 4. Product Card (Clean Look) */
    .product-card {
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: none;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--card-shadow);
    }

    .card-image-wrapper {
        height: 240px;
        overflow: hidden;
        background: #fcfcfc;
    }
    
    .card-img-top {
        transition: transform 0.5s;
        width: 100%; /* Garantir que a imagem cubra o wrapper */
        height: 100%;
        object-fit: cover;
    }

    .product-card:hover .card-img-top {
        transform: scale(1.03);
    }

    .card-body .card-title {
        color: #333;
        font-weight: 600;
        font-size: 1.15rem;
        margin-bottom: 8px;
    }
    
    /* Link para o título */
    .card-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s;
    }
    .card-title a:hover {
        color: var(--accent-color);
    }

    .product-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 15px; 
        display: block; 
        width: 100%;
        text-align: left; 
    }
    
    /* 5. Botão de Ação do Card (Ver Detalhes) */
    .btn-view-details {
        background-color: var(--accent-color) !important; /* Verde-Água */
        border-color: var(--accent-color) !important;
        border-radius: 4px;
        padding: 8px 15px;
        font-weight: 600;
        width: 100%; /* Ocupa a largura total da div, para ficar abaixo do preço */
    }
    
    .btn-view-details:hover {
        background-color: #00695c !important;
        border-color: #00695c !important;
    }
    
    /* 6. Footer */
    .app-footer {
        background: var(--dark-bg);
        color: #aeb6bf;
        padding: 40px 20px;
        text-align: center;
        margin-top: 60px;
        font-size: 0.9rem;
    }
</style>


<section class="hero-section">
    <div class="container">
        <h1 class="hero-title">ShopHub: Qualidade, Preço e Elegância.</h1>
        <p style="font-size: 1.25rem; margin-bottom: 50px; font-weight: 300;">Selecione os melhores produtos com a curadoria que você merece.</p>
        <a href="{{ route('products.index') }}" class="btn hero-btn btn-lg">
            <i class="bi bi-tag-fill"></i> Ver Todos os Produtos
        </a>
    </div>
</section>

---

<section class="products-section">
    <div class="container">
        <h2 class="section-title">✨ Nossas Escolhas da Semana</h2>
        
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 product-card">
                        
                        <a href="{{ route('products.show', $product->id) }}" class="card-image-wrapper">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            @else
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #bdbdbd; background-color: #fcfcfc;">
                                    <i class="bi bi-box-fill" style="font-size: 3.5rem;"></i>
                                </div>
                            @endif
                        </a>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <a href="{{ route('products.show', $product->id) }}">
                                    {{ $product->name }}
                                </a>
                            </h5>
                            <p class="card-text text-muted mb-4" style="font-size: 0.9rem;">{{ Str::limit($product->description, 60) }}</p>
                            
                            <div class="mt-auto d-flex flex-column align-items-start"> 
                                <span class="product-price">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                                
                                {{-- MUDANÇA: Botão para Ver Detalhes --}}
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-view-details">
                                    <i class="bi bi-eye-fill"></i> Ver Detalhes
                                </a>
                                {{-- FIM DA MUDANÇA --}}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-archive" style="font-size: 2rem; color: #aeb6bf;"></i>
                    <p class="text-muted mt-3">Nenhum produto em destaque no momento.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

---

<footer class="app-footer">
    <div class="container">
        <p>&copy; 2025 ShopHub. Todos os direitos reservados. | Design Elegante.</p>
    </div>
</footer>

{{-- O script addToCart não é mais necessário, mas se você o usar em outro lugar, pode mantê-lo no layout. --}}

@endsection