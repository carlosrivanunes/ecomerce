@extends('layouts.app')

@section('content')
<style>
    /* Variáveis de Estilo para Consistência */
    :root {
        --primary-color: #5d5d81; /* Índigo Suave */
        --danger-color: #dc3545; /* Vermelho Padrão do Bootstrap */
        --danger-light: #f8d7da; /* Fundo leve para zona de perigo */
    }

    .page-title {
        color: var(--primary-color);
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 10px;
        margin-bottom: 30px !important;
    }

    /* Estilo Específico para a Zona de Perigo (Card de Exclusão) */
    .danger-zone-card {
        border-left: 5px solid var(--danger-color) !important;
        background-color: var(--danger-light);
        border-radius: 8px; /* Arredondamento suave */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    
    /* Título do Card (para os includes) */
    .card-body h2 {
        color: var(--primary-color);
        font-weight: 700;
    }
</style>

<div class="container py-5" style="max-width: 900px;"> {{-- Aumentei ligeiramente o container para melhor visualização --}}

    {{-- Breadcrumb/Link de Volta --}}
    <p class="mb-3">
        <a href="{{ url('/') }}" class="text-decoration-none text-muted small"><i class="bi bi-house-door-fill me-1"></i> Home</a> 
        <i class="bi bi-chevron-right small mx-1"></i> 
        <span class="fw-semibold text-primary">Configurações de Perfil</span>
    </p>

    {{-- Título da Página --}}
    <h1 class="h3 page-title fw-bold">
        <i class="bi bi-person-fill me-2"></i> Configurações da Conta
    </h1>

    {{-- 1. Card: Informações do Perfil --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4 p-md-5">
            {{-- Inclui o formulário de informações do perfil (Nome e Email) --}}
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>
    
    {{-- Linha divisória --}}
    <hr class="my-5">

    {{-- 2. Card: Atualizar Senha --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4 p-md-5">
            {{-- Inclui o formulário de atualização de senha --}}
            @include('profile.partials.update-password-form')
        </div>
    </div>
    
    {{-- Linha divisória --}}
    <hr class="my-5">

    {{-- 3. Card: Excluir Conta (Zona de Perigo) --}}
    <div class="card danger-zone-card mb-5">
        <div class="card-body p-4 p-md-5">
            {{-- Inclui o formulário de exclusão de conta --}}
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection