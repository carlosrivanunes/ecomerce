@extends('layouts.app')

@section('content')
<style>
    /* Variáveis de Estilo Padronizadas (Laranja/Vermelho - Iguais ao Cadastro) */
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

    /* Botão Principal de Ação (Salvar) */
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
    
    /* Botão Secundário (Voltar/Cancelar) */
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

    /* Imagem Atual (Estilo mais limpo) */
    .current-image-preview-wrapper {
        border: 1px solid var(--border-color);
        border-radius: 6px;
        padding: 10px;
        background-color: #f8f9fa; /* Fundo cinza claro para destacar a área */
        display: inline-block;
    }
    .current-image-preview-wrapper .img-thumbnail {
        max-width: 180px; /* Tamanho ligeiramente reduzido */
        height: auto;
        border: none;
        padding: 0;
    }
    
    /* Alerta de Sucesso */
    .alert-success {
        background-color: #e6f7e9;
        color: #27ae60;
        border-left: 4px solid #27ae60;
        border-color: #e6f7e9;
    }
    
</style>

<div class="form-container-bg">
    <div class="container" style="max-width: 750px;">
        
        <h1 class="text-center form-title">
            <i class="bi bi-pencil-square me-2" style="color: var(--accent-color);"></i> Editar Produto: {{ Str::limit($product->name, 25) }}
        </h1>

        <div class="card form-card">
            <div class="card-body p-4 p-md-5">

                {{-- Mensagem de Sucesso (mantida com novo estilo) --}}
                @if(session('success'))
                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
                @endif
                
                {{-- Mensagem de Erro (reutilizando o estilo do Cadastro) --}}
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

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            {{-- Nome do Produto --}}
                            <label for="name" class="form-label">Nome do Produto</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
                                <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $product->name) }}" required>
                            </div>
                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            {{-- Preço --}}
                            <label for="price" class="form-label">Preço (R$)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                <input id="price" name="price" type="number" step="0.01" min="0" class="form-control" value="{{ old('price', $product->price) }}" required>
                            </div>
                            @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Descrição --}}
                    <div class="mb-4">
                        <label for="description" class="form-label">Descrição Detalhada</label>
                        <textarea id="description" name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
                        @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                             {{-- Nova Imagem (opcional) --}}
                            <label for="image" class="form-label">Nova Imagem (opcional)</label>
                            <input id="image" name="image" type="file" class="form-control">
                            <small class="form-text text-muted">Selecione para substituir a imagem atual.</small>
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            {{-- Imagem Atual (Repete a estrutura da coluna) --}}
                            <label class="form-label">Imagem Atual</label>
                            <div class="current-image-preview-wrapper">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Imagem atual do produto" class="img-thumbnail">
                                @else
                                    <div class="text-muted fst-italic small p-2">Nenhuma imagem cadastrada</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between pt-4 border-top">
                        {{-- Botão Cancelar --}}
                        <a href="{{ route('products.index') }}" class="btn btn-secondary-action">
                            <i class="bi bi-arrow-left me-1"></i> Voltar
                        </a>

                        {{-- Botão Salvar (Cor de Destaque/Accent Color) --}}
                        <button type="submit" class="btn btn-main-action">
                            <i class="bi bi-save me-1"></i> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection