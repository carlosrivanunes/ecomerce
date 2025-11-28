@extends('layouts.app')

@section('content')
<style>
    /* Variáveis de Estilo Padronizadas */
    :root {
        --primary-color: #5d5d81; /* Índigo Suave */
        --accent-color: #00897b; /* Verde-Água (Teal) para Ação */
        --light-bg: #f4f7f9;
        --success-color: #27ae60; /* Verde para Sucesso */
    }

    /* Container Principal */
    .success-wrapper {
        background-color: var(--light-bg);
        padding: 80px 20px;
        min-height: 80vh;
    }

    /* Card de Confirmação */
    .success-card {
        max-width: 500px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        text-align: center;
        border: 1px solid var(--success-color); /* Borda sutil de sucesso */
    }

    /* Ícone de Sucesso */
    .success-icon {
        font-size: 4rem;
        color: var(--success-color);
        margin-bottom: 20px;
        animation: scaleIn 0.5s ease-out;
    }

    @keyframes scaleIn {
        from { transform: scale(0.5); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    /* Título Principal */
    .success-card h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 10px;
    }
    
    /* Mensagens de Texto */
    .success-card p {
        color: #555;
        font-size: 1.1rem;
        margin-bottom: 25px;
    }

    /* Número do Pedido */
    .order-number {
        font-size: 1rem;
        font-weight: 500;
        color: var(--primary-color);
        padding: 5px 10px;
        border-radius: 4px;
        background-color: #f7f7fa;
        display: inline-block;
        margin-bottom: 30px;
    }

    /* Botões de Ação */
    .btn-main-action {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        color: white;
        padding: 10px 20px;
        font-weight: 600;
        transition: background-color 0.3s;
    }
    .btn-main-action:hover {
        background-color: #00695c;
        border-color: #00695c;
    }

    .btn-secondary-action {
        background-color: #f0f0f0;
        border: 1px solid #ddd;
        color: #555;
        padding: 10px 20px;
        font-weight: 600;
        transition: background-color 0.3s;
    }
    .btn-secondary-action:hover {
        background-color: #e0e0e0;
    }
</style>

<div class="success-wrapper">
    <div class="success-card">
        
        <i class="bi bi-check-circle-fill success-icon"></i>
        
        <h1>Compra Validada!</h1>
        <p>Obrigado — sua compra foi processada e validada com sucesso.</p>

        @if(!empty($orderId))
            <p class="order-number">Pedido #{{ $orderId }}</p>
        @else
            <p class="text-muted small">ID do pedido não disponível.</p>
        @endif
        
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('products.index') }}" class="btn btn-main-action">
                <i class="bi bi-shop me-1"></i> Explorar Mais Ofertas
            </a>
            
            <a href="{{ url('/') }}" class="btn btn-secondary-action">
                <i class="bi bi-house-door-fill me-1"></i> Voltar para a Home
            </a>
            
        </div>
    </div>
</div>
@endsection