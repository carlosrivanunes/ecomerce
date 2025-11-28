@extends('layouts.app')

@section('content')
<style>
    /* Variáveis de Estilo Padronizadas (Laranja/Vermelho) */
    :root {
        --primary-color: #333; /* Cor escura para texto principal/títulos */
        --secondary-color: #555;
        --accent-color: #ff6347; /* Laranja para Ação */
        --accent-dark: #e84c3c; /* Vermelho/Laranja Escuro para Hover */
        --light-bg: #f8f8f8;
        --border-color: #ddd;
        --price-color: #2c3e50;
    }

    /* Container Principal */
    .container {
        padding-top: 50px;
        padding-bottom: 50px;
        background-color: var(--light-bg);
        min-height: 80vh;
    }

    /* Título da Página */
    .orders-title {
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 30px;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 10px;
        font-size: 2rem;
    }

    /* Estilo do Card Vazio (Mantido) */
    .card-empty {
        border-radius: 8px;
    }
    .card-empty .bi-journal-x {
        color: var(--secondary-color) !important;
        opacity: 0.6;
    }
    .card-empty h3 {
        color: var(--price-color);
        font-weight: 600;
    }

    /* Estilo do Card de Pedido (Novo) */
    .order-card {
        margin-bottom: 20px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        transition: box-shadow 0.3s, transform 0.3s;
    }
    .order-card:hover {
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    
    /* Cabeçalho do Card */
    .order-card-header {
        background-color: #fcfcfc;
        border-bottom: 1px solid var(--border-color);
        padding: 15px 20px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .order-id {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.15rem;
    }
    .order-date {
        color: var(--secondary-color);
        font-size: 0.9rem;
    }
    
    /* Corpo do Card */
    .order-card-body {
        padding: 20px;
    }
    .order-total-label {
        font-weight: 600;
        color: var(--secondary-color);
    }
    .order-total-amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: green; /* Mantendo verde para valores positivos */
    }

    /* Badges de Status - Cores mantidas */
    .badge {
        font-weight: 600;
        padding: 0.4em 0.8em;
    }

    /* Botão Primário (Estilo Laranja/Vermelho para "Ir para Produtos") */
    .btn-primary {
        background-color: var(--accent-color);
        border-color: var(--accent-dark);
        background: linear-gradient(180deg, var(--accent-color) 0%, var(--accent-dark) 100%);
        box-shadow: 0 3px 0 var(--accent-dark);
        font-weight: 700;
        padding: 10px 20px;
        border-radius: 6px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-primary:hover {
        background-color: var(--accent-dark);
        border-color: var(--accent-dark);
        transform: translateY(1px);
        box-shadow: 0 2px 0 var(--accent-dark);
    }
    .btn-primary:active {
        transform: translateY(3px);
        box-shadow: none;
    }

    /* Botão de Detalhes (Outline na cor de destaque) */
    .btn-outline-primary {
        color: var(--accent-dark);
        border-color: var(--accent-color);
        font-weight: 600;
    }
    .btn-outline-primary:hover {
        background-color: var(--accent-color);
        color: white;
    }
    
</style>

<div class="container py-5">
    <h1 class="orders-title"><i class="bi bi-receipt me-3"></i>Meus Pedidos</h1>

    {{-- Verifica se há pedidos --}}
    @if ($orders->isEmpty())
        {{-- Mensagem de "Nenhum Pedido" --}}
        <div class="card border-0 shadow-sm text-center py-5 card-empty">
            <div class="card-body">
                <i class="bi bi-journal-x" style="font-size: 4rem;"></i>
                <h3 class="mt-4">Você ainda não fez nenhum pedido.</h3>
                <p class="text-muted">Explore nossos produtos e faça sua primeira compra!</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-shop me-1"></i> Ir para Produtos
                </a>
            </div>
        </div>
    @else
        {{-- Novo Grid de Cards para a Lista de Pedidos --}}
        <div class="row">
            @foreach ($orders as $order)
                <div class="col-lg-6 col-xl-4"> {{-- Colunas responsivas (2 ou 3 pedidos por linha) --}}
                    <div class="card shadow-sm order-card bg-white">
                        
                        <div class="order-card-header">
                            <span class="order-id">Pedido #{{ $order->id }}</span>
                            <span class="order-date">{{ $order->created_at->format('d/m/Y') }}</span>
                        </div>

                        <div class="order-card-body">
                            
                            {{-- Status do Pedido (Em destaque) --}}
                            <div class="mb-3">
                                <span class="order-total-label me-2">Status:</span>
                                @php
                                    $statusClass = 'bg-secondary';
                                    if (strtolower($order->status) == 'pago' || strtolower($order->status) == 'concluído' || strtolower($order->status) == 'entregue') {
                                        $statusClass = 'bg-success';
                                    } elseif (strtolower($order->status) == 'pendente' || strtolower($order->status) == 'processando') {
                                        $statusClass = 'bg-warning text-dark';
                                    } elseif (strtolower($order->status) == 'cancelado') {
                                        $statusClass = 'bg-danger';
                                    }
                                @endphp
                                <span class="badge rounded-pill {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                            </div>

                            {{-- Total do Pedido --}}
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <p class="order-total-label mb-0">Total:</p>
                                    <p class="order-total-amount mb-0">R$ {{ number_format($order->total, 2, ',', '.') }}</p>
                                </div>
                                
                                {{-- Botão de Detalhes --}}
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary" title="Ver Detalhes">
                                    Ver Detalhes <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>

                            <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                Última atualização: {{ $order->updated_at->format('d/m/Y H:i') }}
                            </p>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Adicionar Paginação --}}
        @if (method_exists($orders, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
        @endif
    @endif
</div>
@endsection