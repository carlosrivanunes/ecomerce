@extends('layouts.app')

@section('content')
<style>
    /* Variáveis de Estilo Padronizadas */
    :root {
        --primary-color: #5d5d81; /* Índigo Suave */
        --accent-color: #00897b; /* Verde-Água (Teal) para Ação */
        --light-bg: #f4f7f9;
        --border-color: #e0e0e0;
        --success-custom: #27ae60; /* Verde Customizado para sucesso/validade */
    }

    /* Container Principal */
    .container {
        padding-top: 50px;
        padding-bottom: 50px;
        background-color: var(--light-bg);
        min-height: 80vh;
    }

    /* Card Principal do Formulário */
    .form-card {
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }
    
    /* Cabeçalho do Card */
    .form-card .card-header {
        background-color: var(--primary-color) !important;
        color: white;
        border-bottom: 1px solid var(--border-color);
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .form-card .card-header h1 {
        font-weight: 600;
        color: white; /* Cor do título no cabeçalho */
    }

    /* Estilo de Inputs e Labels */
    .form-label {
        color: var(--primary-color);
        font-weight: 600 !important;
    }
    
    .input-group-text {
        background-color: #f7f7f7;
        color: var(--primary-color);
        border-color: var(--border-color);
    }
    
    /* Estilo do Botão de Ação (Cadastrar) */
    .btn-main-action {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        color: white;
        font-weight: 600;
        transition: background-color 0.3s;
    }
    .btn-main-action:hover {
        background-color: #00695c;
        border-color: #00695c;
    }
    
    /* Estilo do Botão Secundário (Cancelar) */
    .btn-outline-secondary {
        color: var(--primary-color);
        border-color: var(--primary-color);
        font-weight: 500;
    }
    .btn-outline-secondary:hover {
        background-color: var(--primary-color);
        color: white;
    }

    /* Alerta de erro */
    .alert-danger {
        border-color: #f5c6cb;
    }
    
</style>

<div class="container mt-5" style="max-width: 700px;">

    <div class="card shadow-lg border-0 form-card">
        
        <div class="card-header py-3">
            <h1 class="h4 mb-0 text-center"><i class="bi bi-plus-circle me-2"></i> Cadastrar Novo Produto</h1>
        </div>

        <div class="card-body p-4 p-md-5">

            {{-- Mensagem de erro --}}
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf

                {{-- Nome do Produto --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nome do Produto</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Descrição --}}
                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Descrição</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Preço --}}
                <div class="mb-3">
                    <label for="price" class="form-label fw-semibold">Preço</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" name="price" id="price" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                        @error('price')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Imagem --}}
                <div class="mb-4">
                    <label for="image" class="form-label fw-semibold">Imagem</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between pt-3">
                    {{-- Botão Cancelar (Outline com Primary Color) --}}
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg me-1"></i>
                        Cancelar
                    </a>
                    {{-- Botão Cadastrar (Cor de Destaque/Accent Color) --}}
                    <button type="submit" class="btn btn-main-action">
                        <i class="bi bi-check-lg me-1"></i>
                        Cadastrar Produto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Script de validação do Bootstrap 5
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