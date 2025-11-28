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
    
    /* Cabeçalho do Pedido */
    .order-header h1 {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 2rem;
    }
    
    .order-header .order-date {
        font-size: 1rem;
        color: #777;
    }

    /* Card Principal */
    .order-details-card {
        border-radius: 8px;
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    /* Cabeçalho do Card (Status e Total) */
    .order-details-card .card-header {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-color);
    }
    
    .order-details-card .card-header .badge {
        font-size: 0.9em;
        font-weight: 700;
        margin-left: 5px;
    }
    
    .order-details-card .card-header .fw-bold {
        color: #fff; /* Total no cabeçalho */
    }

    /* Lista de Itens */
    .list-group-item {
        border-color: #f0f0f0;
        padding-left: 20px;
        padding-right: 20px;
    }
    
    .list-group-item:last-child {
        border-bottom: none;
    }

    /* Estilo do Imagem do Item */
    .list-group-item .img-thumbnail {
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    /* Preço do Item */
    .list-group-item .text-end {
        font-weight: 600;
        color: var(--price-color);
    }
    .list-group-item small {
        font-weight: 400;
    }

    /* Rodapé */
    .order-details-card .card-footer {
        border-top: 1px solid var(--border-color);
        padding: 15px 20px;
        background-color: #fcfcfc !important;
    }
    
    /* Botão Voltar */
    .btn-outline-secondary {
        color: var(--primary-color);
        border-color: var(--primary-color);
        font-weight: 500;
    }
    .btn-outline-secondary:hover {
        background-color: var(--primary-color);
        color: white;
    }

</style>

<div class="container py-5">
    
    {{-- Cabeçalho com ID do Pedido e Data --}}
    <div class="d-flex justify-content-between align-items-center mb-4 order-header">
        <h1 class="h3 mb-0">Detalhes do Pedido <span class="text-secondary fw-bold">#{{ $order->id }}</span></h1>
        <span class="text-muted order-date">Feito em: {{ $order->created_at->format('d/m/Y H:i') }}</span>
    </div>

    {{-- Card Principal --}}
    <div class="card shadow-sm border-0 order-details-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            {{-- Status --}}
            <span>Status: 
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
            </span>
            {{-- Total --}}
            <span class="fw-bold">Total: R$ {{ number_format($order->total, 2, ',', '.') }}</span>
        </div>
        
        <div class="card-body">
            <h5 class="card-title mb-3" style="color: var(--primary-color); font-weight: 600;">Itens Comprados</h5>

            {{-- Lista de Itens --}}
            <ul class="list-group list-group-flush">
                @foreach ($order->items as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            {{-- Imagem do Produto --}}
                            @php
                                $imageUrl = $item->product && $item->product->image 
                                            ? asset('storage/' . $item->product->image) 
                                            : 'https://via.placeholder.com/50?text=Img';
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $item->product->name ?? 'Produto' }}" class="img-thumbnail me-3" style="width: 50px; height: 50px; object-fit: contain;">
                            
                            {{-- Nome e Quantidade --}}
                            <div>
                                <span class="fw-medium" style="color: #333;">{{ $item->product->name ?? 'Produto Indisponível' }}</span> <br>
                                <small class="text-muted">Quantidade: {{ $item->quantity }}</small>
                            </div>
                        </div>
                        {{-- Preço Total do Item --}}
                        <span class="text-end">
                            R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }} <br>
                            <small class="text-muted">(R$ {{ number_format($item->price, 2, ',', '.') }} cada)</small>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="card-footer text-end">
             {{-- Botão para voltar para a lista de pedidos --}}
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Voltar para Meus Pedidos
            </a>
        </div>
    </div>
    
    {{-- Você pode adicionar aqui informações de endereço e pagamento se disponíveis --}}
    
</div>
@endsection