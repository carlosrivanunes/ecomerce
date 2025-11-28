@extends('layouts.app') {{-- Assumindo que você trocou x-app-layout por layouts.app que usa Bootstrap --}}

@section('content')
<style>
    /* Estilos de cor padronizados (se necessário, mas o Tailwind lida com isso) */
    .icon-box {
        display: flex;
        align-items: center;
        justify-content: center;
        /* Tailwind classes: flex-shrink-0 bg-COLOR-500 rounded-md p-3 */
        border-radius: 0.375rem;
        padding: 0.75rem;
    }
    .icon-box i {
        font-size: 1.5rem; /* h-6 w-6 */
        color: white;
    }
    .card-link {
        color: #5d5d81; /* Primary Color de outros arquivos */
        font-weight: 500;
        text-decoration: none;
        transition: color 0.2s;
    }
    .card-link:hover {
        color: #00897b; /* Accent Color de outros arquivos */
    }
</style>

<div class="py-5 bg-light"> {{-- Equivalente a py-12 bg-gray-100 --}}
    <div class="container" style="max-width: 1100px;"> {{-- Equivalente a max-w-7xl mx-auto sm:px-6 lg:px-8 --}}

        {{-- 1. Mensagem de Boas-Vindas --}}
        <div class="card shadow-sm border-0 mb-4"> {{-- Equivalente a bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 --}}
            <div class="card-body p-4 p-md-5"> {{-- Equivalente a p-6 text-gray-900 --}}
                <h3 class="h5 fw-bold text-primary"> {{-- h3 text-lg font-medium text-gray-900 --}}
                    Bem-vindo(a) de volta, {{ Auth::user()->name }}! 
                    <i class="bi bi-hand-thumbs-up-fill ms-2"></i>
                </h3>
                <p class="text-muted mt-1 small"> {{-- mt-1 text-sm text-gray-600 --}}
                    Aqui estão alguns atalhos rápidos para gerenciar sua conta e suas compras.
                </p>
            </div>
        </div>

        {{-- 2. Grade de Atalhos Rápidos --}}
        <div class="row g-4"> {{-- Equivalente a grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 --}}

            {{-- Card: Ver Produtos --}}
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            {{-- Ícone (Índigo) --}}
                            <div class="icon-box bg-indigo-500">
                                <i class="bi bi-shop"></i>
                            </div>
                            <div class="ms-4">
                                <h4 class="h6 fw-bold text-dark mb-0">Ver Produtos</h4>
                                <p class="text-muted small mb-0">Navegue pelo nosso catálogo.</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('products.index') }}" class="card-link">
                                Ir para o Catálogo &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Meu Carrinho --}}
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            {{-- Ícone (Verde) --}}
                            <div class="icon-box bg-success"> {{-- bg-green-500 --}}
                                <i class="bi bi-cart3"></i>
                            </div>
                            <div class="ms-4">
                                <h4 class="h6 fw-bold text-dark mb-0">Meu Carrinho</h4>
                                <p class="text-muted small mb-0">Veja os itens adicionados.</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('cart.index') }}" class="card-link">
                                Ver Carrinho &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Meus Pedidos --}}
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            {{-- Ícone (Amarelo) --}}
                            <div class="icon-box bg-warning"> {{-- bg-yellow-500 --}}
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div class="ms-4">
                                <h4 class="h6 fw-bold text-dark mb-0">Meus Pedidos</h4>
                                <p class="text-muted small mb-0">Acompanhe suas compras.</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('orders.index') }}" class="card-link">
                                Ver Histórico &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Gerenciar Perfil --}}
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            {{-- Ícone (Azul) --}}
                            <div class="icon-box bg-info"> {{-- bg-blue-500 --}}
                                <i class="bi bi-person-gear"></i>
                            </div>
                            <div class="ms-4">
                                <h4 class="h6 fw-bold text-dark mb-0">Gerenciar Perfil</h4>
                                <p class="text-muted small mb-0">Atualize seus dados.</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('profile.edit') }}" class="card-link">
                                Editar Perfil &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Adicionar Produto (Admin) --}}
            @if(auth()->user()?->is_admin) {{-- Exemplo de verificação de admin --}}
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            {{-- Ícone (Roxo) --}}
                            <div class="icon-box bg-purple-500">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <div class="ms-4">
                                <h4 class="h6 fw-bold text-dark mb-0">Adicionar Produto</h4>
                                <p class="text-muted small mb-0">Cadastre um novo item.</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('products.create') }}" class="card-link">
                                Novo Produto &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div> {{-- Fim da Grade --}}
    </div>
</div>
@endsection