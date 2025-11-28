@extends('layouts.app') 

@section('content')

<style>
    /* 1. COR PRINCIPAL: LARANJA CORAL (#ff6347) */
    .bg-coral {
        background-color: #ff6347 !important;
    }
    .text-coral {
        color: #ff6347 !important;
    }
    .border-coral {
        border-color: #ff6347 !important;
    }
    
    /* 2. ESTILOS DE ÍCONES, LINKS E HOVER */
    .feature-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 3rem;
        height: 3rem;
        border-radius: 0.5rem;
        font-size: 1.5rem;
        color: white; /* Ícones brancos dentro da caixa colorida */
    }
    .feature-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .feature-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    /* Link de destaque no tema claro */
    .link-coral-darker {
        color: #e55336; /* Um coral mais escuro para links (hover) */
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s;
    }
    .link-coral-darker:hover {
        color: #d1492c; 
    }
    /* Sobrescrevendo o botão outline-primary para outline-coral */
    .btn-outline-coral {
        color: #ff6347;
        border-color: #ff6347;
    }
    .btn-outline-coral:hover {
        background-color: #ff6347;
        color: white;
        border-color: #ff6347;
    }
</style>

<div class="py-5 bg-light min-vh-100"> 
    <div class="container" style="max-width: 1000px;">

        {{-- 1. HEADER E MENSAGEM DE BOAS-VINDAS (Jumbotron/Hero Compacto) --}}
        <div class="p-5 mb-5 bg-white border rounded-3 shadow-sm">
            <h1 class="display-6 fw-bold text-coral">
                Painel de Controle
            </h1>
            <p class="fs-4 text-secondary">
                Bem-vindo(a), **{{ Auth::user()->name }}**! Gerencie suas atividades aqui.
            </p>
            <hr class="my-4">
            {{-- Botão Outline Coral --}}
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-coral btn-sm">
                <i class="bi bi-person-gear me-2"></i> Configurar Perfil
            </a>
        </div>

        {{-- 2. GRADE DE INFORMAÇÕES E ATALHOS --}}
        <div class="row g-4">

            {{-- COLUNA PRINCIPAL (8 COLUNAS) --}}
            <div class="col-lg-8">
                
                <h3 class="h5 fw-bold mb-3 text-dark">Ações de Compra e Catálogo</h3>

                {{-- CARD DE ATALHO COMPACTO: Ver Produtos (BG Info) --}}
                <a href="{{ route('products.index') }}" class="card feature-card mb-3 text-decoration-none text-dark border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="feature-icon bg-info me-4">
                            <i class="bi bi-shop"></i>
                        </div>
                        <div>
                            <h5 class="h6 fw-bold mb-0">Explorar Catálogo de Produtos</h5>
                            <p class="text-muted small mb-0">Encontre as últimas novidades.</p>
                        </div>
                        <i class="bi bi-chevron-right ms-auto text-muted"></i>
                    </div>
                </a>

                {{-- CARD DE ATALHO COMPACTO: Meu Carrinho (BG Success) --}}
                <a href="{{ route('cart.index') }}" class="card feature-card mb-3 text-decoration-none text-dark border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="feature-icon bg-success me-4">
                            <i class="bi bi-cart3"></i>
                        </div>
                        <div>
                            <h5 class="h6 fw-bold mb-0">Revisar Meu Carrinho</h5>
                            <p class="text-muted small mb-0">Itens prontos para a compra.</p>
                        </div>
                        <i class="bi bi-chevron-right ms-auto text-muted"></i>
                    </div>
                </a>

                {{-- CARD DE ATALHO COMPACTO: Meus Pedidos (BG Warning) --}}
                <a href="{{ route('orders.index') }}" class="card feature-card mb-3 text-decoration-none text-dark border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="feature-icon bg-warning me-4">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div>
                            <h5 class="h6 fw-bold mb-0">Acompanhar Meus Pedidos</h5>
                            <p class="text-muted small mb-0">Status e histórico de suas compras.</p>
                        </div>
                        <i class="bi bi-chevron-right ms-auto text-muted"></i>
                    </div>
                </a>

                @if(auth()->user()?->is_admin)
                {{-- CARD DE ATALHO COMPACTO: Admin (BG Danger, Borda Coral) --}}
                <a href="{{ route('admin.dashboard') }}" class="card feature-card mb-3 text-decoration-none text-dark border-0 shadow-sm border-coral border-start border-3">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="feature-icon bg-danger me-4">
                            <i class="bi bi-person-workspace"></i>
                        </div>
                        <div>
                            <h5 class="h6 fw-bold mb-0 text-danger">Acesso Administrativo</h5>
                            <p class="text-muted small mb-0">Ferramentas de gestão de produtos e usuários.</p>
                        </div>
                        <i class="bi bi-chevron-right ms-auto text-danger"></i>
                    </div>
                </a>
                @endif
            </div>

            {{-- COLUNA LATERAL (4 COLUNAS) --}}
            <div class="col-lg-4">
                
                {{-- BLOCO DE LINKS RÁPIDOS (List Group) --}}
                <h3 class="h5 fw-bold mb-3 text-dark">Sua Conta</h3>
                <div class="list-group shadow-sm mb-4">
                    {{-- Destaque Coral no ícone --}}
                    <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-person me-2 text-coral"></i> Gerenciar Dados Pessoais
                        </div>
                        <i class="bi bi-arrow-right small"></i>
                    </a>
                    {{-- Destaque Coral no ícone --}}
                    <a href="{{ route('favorites.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-heart me-2 text-coral"></i> Meus Produtos Favoritos
                        </div>
                        <i class="bi bi-arrow-right small"></i>
                    </a>
                    {{-- Suporte e Ajuda (Mantendo o link que funciona) --}}
                    <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-headset me-2 text-secondary"></i> Suporte e Ajuda
                        </div>
                        <i class="bi bi-arrow-right small"></i>
                    </a>
                </div>

                {{-- BLOCO DE SAUDAÇÃO/ALERTA (Fundo Coral) --}}
                <div class="card bg-coral text-white shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Pronto para a Próxima Compra?</h5>
                        <p class="card-text small mb-3">Temos milhares de ofertas esperando por você hoje.</p>
                        {{-- Link Branco com borda branca para contraste no BG Coral --}}
                        <a href="{{ route('products.index') }}" class="link-coral-darker text-white fw-bold border-bottom border-white pb-1">
                            Ver Ofertas Agora <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div> {{-- Fim da Grade --}}
    </div>
</div>
@endsection