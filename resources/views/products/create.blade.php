@extends('layouts.app')

@section('content')
<style>
    /* Variáveis de Estilo Padronizadas (Laranja/Vermelho) */
    :root {
        --primary-text: #34495e; /* Azul Escuro Sóbrio para Textos */
        --accent-color: #ff6633; /* Laranja Vívido para Ação Principal */
        --light-bg: #f4f7f9; /* Fundo principal da página */
        --form-bg: white; /* Fundo do Card do Formulário */
        --border-color: #dee2e6;
    }

    /* Container Principal da Página */
    .form-container-bg {
        background-color: var(--light-bg);
        padding: 50px 20px 80px;
        min-height: 90vh;
    }

    /* Card Principal do Formulário (Visual Minimalista) */
    .form-card {
        background-color: var(--form-bg);
        border-radius: 10px;
        border: none; 
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08); /* Sombra mais suave */
    }
    
    /* Título (Fora do Header, mais simples) */
    .form-title {
        color: var(--primary-text);
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 30px;
    }

    /* Estilo de Inputs e Labels */
    .form-label {
        color: var(--primary-text);
        font-weight: 600 !important;
        margin-bottom: 5px;
    }
    
    .input-group-text {
        background-color: transparent; /* Transparente para visual clean */
        color: var(--primary-text);
        border-right: none;
        border-color: var(--border-color);
    }
    
    .form-control {
        border-left: none;
        border-color: var(--border-color);
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.15rem rgba(255, 102, 51, 0.2); /* Sombra Laranja/Vermelha sutil */
    }
    
    .input-group:focus-within .input-group-text {
        color: var(--accent-color);
        border-color: var(--accent-color);
    }

    /* Botão Principal de Ação (Laranja/Vermelho) */
    .btn-main-action {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        color: white;
        font-weight: 600;
        padding: 10px 25px;
        border-radius: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: background-color 0.3s;
    }
    .btn-main-action:hover {
        background-color: #e65220;
        border-color: #e65220;
    }
    
    /* Botão Secundário (Cancelar/Voltar) */
    .btn-secondary-action {
        color: var(--primary-text);
        border: 1px solid var(--border-color);
        background-color: transparent;
        font-weight: 500;
        padding: 10px 25px;
        border-radius: 5px;
        transition: all 0.3s;
    }
    .btn-secondary-action:hover {
        background-color: #e9ecef;
    }

    /* Estilo de Alerta de Erro mais discreto */
    .alert-danger {
        background-color: #fff3f3;
        color: #c0392b;
        border-left: 4px solid #c0392b;
        border-radius: 4px;
        padding: 10px 15px;
    }
    
</style>

<div class="form-container-bg">
    <div class="container" style="max-width: 750px;">
        
        <h1 class="text-center form-title">
            <i class="bi bi-box-fill me-2" style="color: var(--accent-color);"></i> Cadastro de Novo Produto
        </h1>

        <div class="card form-card">
            <div class="card-body p-4 p-md-5">

                {{-- Mensagem de erro (Estilo discreto) --}}
                @if ($errors->any())
                    <div class="alert alert-danger mb-4" role="alert">
                        <h4 class="alert-heading h6"><i class="bi bi-exclamation-triangle-fill me-2"></i> Por favor, corrija os erros abaixo:</h4>
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            {{-- Nome do Produto --}}
                            <label for="name" class="form-label">Nome do Produto</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Monitor 4K..." required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            {{-- Preço --}}
                            <label for="price" class="form-label">Preço (R$)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                <input type="number" name="price" id="price" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="0.00" required>
                                @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Descrição --}}
                    <div class="mb-4">
                        <label for="description" class="form-label">Descrição Detalhada</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Descrição completa do produto e suas características." required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Imagem --}}
                    <div class="mb-5">
                        <label for="image" class="form-label">Imagem do Produto</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        <small class="form-text text-muted">Recomendado: Imagem de alta resolução em formato quadrado.</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between pt-4">
                        {{-- Botão Voltar/Cancelar --}}
                        <a href="{{ route('products.index') }}" class="btn btn-secondary-action">
                            <i class="bi bi-arrow-left me-1"></i>
                            Voltar
                        </a>
                        {{-- Botão Cadastrar (Cor de Destaque/Accent Color) --}}
                        <button type="submit" class="btn btn-main-action">
                            <i class="bi bi-plus-lg me-1"></i>
                            Cadastrar Produto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script de validação do Bootstrap 5 (Mantido)
    (function () {
    'use strict'

    var forms = document.querySelectorAll('.needs-validation')

    Array.prototype.slice.call(forms)
        .forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
        })
    })()
</script>
@endsection