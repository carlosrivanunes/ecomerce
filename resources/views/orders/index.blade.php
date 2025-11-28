@extends('layouts.app')

@section('content')
<style>
    /* Variáveis de Estilo Padronizadas */
    :root {
        --primary-color: #5d5d81; /* Índigo Suave */
        --accent-color: #00897b; /* Verde-Água (Teal) para Ação */
        --light-bg: #f4f7f9;
        --border-color: #e0e0e0;
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

    /* Estilo do Card Vazio */
    .card-empty {
        border-radius: 8px;
    }
    .card-empty .bi-journal-x {
        color: var(--primary-color) !important;
        opacity: 0.6;
    }
    .card-empty h3 {
        color: var(--price-color);
        font-weight: 600;
    }

    /* Estilo da Tabela */
    .table-orders thead th {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        border-bottom: none;
        letter-spacing: 0.5px;
    }
    
    .table-orders tbody tr:hover {
        background-color: #f9f9f9;
    }

    .table-orders tbody td {
        color: #333;
    }
    
    .table-orders tbody .fw-medium {
        color: var(--primary-color);
    }

    /* Botão Primário (Usado na mensagem de Vazio) */
    .btn-primary {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        font-weight: 500;
    }
    .btn-primary:hover {
        background-color: #00695c;
        border-color: #00695c;
    }

    /* Botão de Detalhes (Outline na cor de destaque) */
    .btn-outline-primary {
        color: var(--accent-color);
        border-color: var(--accent-color);
    }
    .btn-outline-primary:hover {
        background-color: var(--accent-color);
        color: white;
    }

    /* Badge de Status - Para garantir que as cores sejam vibrantes */
    .badge {
        font-weight: 600;
        padding: 0.4em 0.8em;
    }
    
</style>

<div class="container py-5">
    <h1 class="orders-title"><i class="bi bi-receipt me-3"></i>Meus Pedidos</h1>

    {{-- Verifica se há pedidos --}}
    @if ($orders->isEmpty())
        {{-- Mensagem de "Nenhum Pedido" melhorada --}}
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
        {{-- Lista de Pedidos --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-orders">
                        <thead>
                            <tr>
                                <th class="py-3 px-4">ID do Pedido</th>
                                <th class="py-3 px-4">Data</th>
                                <th class="py-3 px-4 text-end">Total</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="py-3 px-4 fw-medium">#{{ $order->id }}</td>
                                    <td class="py-3 px-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="py-3 px-4 text-end fw-bold text-success">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-center">
                                        {{-- Usar Badges para o Status --}}
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
                                    </td>
                                    <td class="py-3 px-4 text-end">
                                        {{-- Botão para Ver Detalhes --}}
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary" title="Ver Detalhes">
                                            <i class="bi bi-eye-fill"></i> Detalhes
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Adicionar Paginação (opcional, dependendo da implementação do controller) --}}
        @if (method_exists($orders, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
        @endif
    @endif
</div>
@endsection