@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<style>
    /* Variáveis de cor (Alto Contraste) */
    :root {
        --text-dark: #222;
        --text-light: #666;
        --highlight-color: #ff6347; /* Vermelho Coral Vibrante */
    }

    /* 1. Estilos do Carrossel */
    .carousel-item {
        height: 350px; 
        background-color: #333; 
        color: white;
    }
    .carousel-caption h5 {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--highlight-color);
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    .carousel-caption p {
        font-size: 1.1rem;
        font-weight: 300;
        margin-bottom: 20px;
    }
    .carousel-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.6; 
    }
    
    /* 2. Estilo para Value Proposition Banner */
    .value-proposition-container {
        background-color: var(--text-dark); /* Fundo Preto/Escuro */
        padding: 30px 0;
        margin-top: -30px; 
        margin-bottom: 40px;
        position: relative;
        z-index: 10;
    }

    .value-item {
        color: white;
        text-align: center;
        padding: 0 15px;
    }

    .value-icon {
        font-size: 2.5rem;
        color: var(--highlight-color); 
        margin-bottom: 10px;
    }

    .value-item h4 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .value-item p {
        font-size: 0.9rem;
        color: #ccc;
        margin: 0;
    }
    
    /* 3. Estilo para o Botão de Catálogo (Chama a atenção) */
    .catalog-action-container {
        text-align: center;
        margin-top: 30px;
        margin-bottom: 60px;
    }

    .catalog-btn {
        background-color: var(--highlight-color) !important;
        border-color: var(--highlight-color) !important;
        font-size: 1.5rem;
        padding: 15px 60px;
        font-weight: 800;
        border-radius: 50px;
        box-shadow: 0 6px 15px rgba(255, 99, 71, 0.4);
        transition: all 0.3s;
        text-transform: uppercase;
    }
    .catalog-btn:hover {
        background-color: #e55336 !important;
        border-color: #e55336 !important;
        transform: scale(1.05);
    }

    /* --- Novo Estilo para Seção Quem Somos --- */
    .about-section {
        padding: 40px 0;
        background-color: #fff; /* Fundo branco ou claro para contraste */
    }
    .about-section h3 {
        color: var(--highlight-color);
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 20px;
    }
    .about-section p {
        color: var(--text-dark);
        line-height: 1.8;
    }

</style>

{{-- 1. Carrossel de Destaques --}}
<div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
    
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    
    <div class="carousel-inner">
        {{-- Item 1 --}}
        <div class="carousel-item active">
            <img src="https://picsum.photos/1200/350?random=1" class="carousel-image" alt="Promoção">
            <div class="carousel-caption d-none d-md-block">
                <h5>🔥 O Poder do Toque</h5>
                <p>Confira os tablets mais recentes com a melhor tecnologia do mercado.</p>
            </div>
        </div>
        
        {{-- Item 2 --}}
        <div class="carousel-item">
            <img src="https://picsum.photos/1200/350?random=2" class="carousel-image" alt="Novidades">
            <div class="carousel-caption d-none d-md-block">
                <h5>Acessórios Essenciais</h5>
                <p>Proteção e produtividade para o seu dispositivo.</p>
            </div>
        </div>
        
        {{-- Item 3 --}}
        <div class="carousel-item">
            <img src="https://picsum.photos/1200/350?random=3" class="carousel-image" alt="Destaque">
            <div class="carousel-caption d-none d-md-block">
                <h5>Lançamentos 2025</h5>
                <p>Fique por dentro das novidades com telas de alta resolução.</p>
            </div>
        </div>
    </div>
    
    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

{{-- 2. Banner de Proposta de Valor --}}
<div class="value-proposition-container">
    <div class="container">
        <div class="row">
            
            {{-- Vantagem 1: Frete --}}
            <div class="col-md-4 value-item">
                <i class="bi bi-truck value-icon"></i>
                <h4>Frete Rápido para Todo o Brasil</h4>
                <p>Receba seu novo tablet com agilidade e segurança.</p>
            </div>
            
            {{-- Vantagem 2: Garantia --}}
            <div class="col-md-4 value-item">
                <i class="bi bi-shield-lock-fill value-icon"></i>
                <h4>Garantia Oficial de 1 Ano</h4>
                <p>Todos os produtos com selo de qualidade e proteção.</p>
            </div>
            
            {{-- Vantagem 3: Suporte --}}
            <div class="col-md-4 value-item">
                <i class="bi bi-headset value-icon"></i>
                <h4>Suporte Técnico Especializado</h4>
                <p>Ajuda rápida e focada em dispositivos móveis e tablets.</p>
            </div>
            
        </div>
    </div>
</div>

{{-- 3. Botão de Ação para o Catálogo (Chama a atenção) --}}
<div class="container">
    <div class="catalog-action-container">
        <a href="{{ route('products.index') }}" class="btn catalog-btn text-white">
            <i class="bi bi-search me-2"></i> Ver Todos os Tablets
        </a>
    </div>
</div>

{{-- 4. NOVO BLOCO: Quem Somos (Enchimento de Linguiça com Propósito) --}}
<section class="container about-section">
    <div class="row justify-content-center">
        <div class="col-lg-10 text-center">
            <h3>Quem Somos</h3>
            <p>
                Nascemos da paixão pela tecnologia móvel e da crença no potencial dos tablets como ferramentas essenciais para produtividade, estudo e entretenimento. 
                Nossa loja é **especializada exclusivamente em tablets e seus acessórios**, o que nos permite oferecer uma curadoria de produtos superior e um conhecimento técnico aprofundado que você não encontra em grandes varejistas genéricos. 
                Trabalhamos apenas com marcas renomadas e modelos que realmente entregam performance e valor. Seu próximo tablet ideal está aqui.
            </p>
        </div>
    </div>
</section>
{{-- FIM DO NOVO BLOCO --}}

<hr class="my-5" style="border-top: 1px solid var(--text-light);">

{{-- 5. Footer --}}
<footer class="bg-dark text-white-50 mt-5 py-4">
    <div class="container text-center">
        <p class="mb-0">&copy; 2025 Tablet Store. Todos os direitos reservados. | Design Minimalista.</p>
    </div>
</footer>

@endsection