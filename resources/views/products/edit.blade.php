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
    .py-5 {
        padding-top: 50px !important;
        padding-bottom: 50px !important;
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
        background-color: var(--primary-color);
        color: white;
        border-bottom: 1px solid var(--border-color);
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        padding: 15px; /* Adiciona padding para centralizar */
    }

    .form-card .card-header h4 {
        font-weight: 600;
        color: white; /* Cor do título no cabeçalho */
    }

    /* Estilo de Inputs e Labels */
    .form-label {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 0.95rem;
    }
    
    .input-group-text {
        background-color: #f7f7f7;
        color: var(--primary-color);
        border-color: var(--border-color);
    }
    
    /* Imagem Atual */
    .current-image-preview {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        background-color: #fff;
    }

    /* Botão Principal de Ação (Salvar) */
    .btn-main-action {
        background-color: var(--accent-color); /* Verde-Água */
        border-color: var(--accent-color);
        color: white;
        font-weight: 600;
        transition: background-color 0.3s;
    }
    .btn-main-action:hover {
        background-color: #00695c;
        border-color: #00695c;
    }
    
    /* Botão Secundário (Cancelar) */
    .btn-outline-secondary {
        color: var(--primary-color);
        border-color: var(--primary-color);
        font-weight: 500;
        transition: background-color 0.3s;
    }
    .btn-outline-secondary:hover {
        background-color: var(--primary-color);
        color: white;
    }

    /* Alerta de Sucesso */
    .alert-success {
        background-color: #e6fff7;
        color: var(--accent-color);
        border-color: #99e6d4;
    }
    
</style>

<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            {{-- Usa a classe form-card e shadow-lg --}}
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card shadow-lg form-card">
                    <div class="card-header text-center">
                        <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Editar Produto</h4>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        
                        {{-- Certificando-se de que a rota 'products.update' é usada se 'admin.products.update' não existir --}}
                        <form action="@if(Route::has('admin.products.update')){{ route('admin.products.update', $product->id) }}@elseif(Route::has('products.update')){{ route('products.update', $product->id) }}@else # @endif"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Nome do Produto --}}
                            <div class="mb-4">
                                <label for="name" class="form-label">Nome do Produto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-box"></i></span>
                                    <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $product->name) }}" required>
                                </div>
                                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Descrição --}}
                            <div class="mb-4">
                                <label for="description" class="form-label">Descrição</label>
                                <div class="input-group">
                                    <span class="input-group-text align-items-start pt-2"><i class="bi bi-card-text"></i></span>
                                    <textarea id="description" name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
                                </div>
                                @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                {{-- Preço --}}
                                <div class="col-md-6 mb-4">
                                    <label for="price" class="form-label">Preço</label>
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input id="price" name="price" type="number" step="0.01" class="form-control" value="{{ old('price', $product->price) }}" required>
                                    </div>
                                    @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                {{-- Imagem (opcional) --}}
                                <div class="col-md-6 mb-4">
                                    <label for="image" class="form-label">Nova Imagem (opcional)</label>
                                    <input id="image" name="image" type="file" class="form-control">
                                    @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Imagem Atual --}}
                            <div class="mb-4">
                                <label class="form-label">Imagem atual</label>
                                <div class="current-image-preview">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Imagem atual do produto" class="img-thumbnail" style="max-width:220px;">
                                    @else
                                        <div class="text-muted fst-italic">Nenhuma imagem cadastrada</div>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-3">
                                {{-- Botão Cancelar --}}
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-lg me-1"></i> Cancelar
                                </a>

                                {{-- Botão Salvar (usando a classe main-action) --}}
                                <button type="submit" class="btn btn-main-action">
                                    <i class="bi bi-check-lg me-1"></i> Salvar alterações
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection