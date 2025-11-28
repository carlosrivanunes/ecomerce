@extends('layouts.guest') {{-- Assume-se que 'layouts.guest' é sua estrutura base para autenticação --}}

@section('content')
<div class="card shadow-lg p-4 p-md-5 mx-auto" style="max-width: 400px;">
    
    {{-- Descrição do Propósito --}}
    <div class="mb-4 small" style="color: #5d5d81;">
        <p>
            <i class="bi bi-question-circle-fill me-1"></i> 
            {{ __('Esqueceu sua senha? Sem problemas. Basta nos informar seu endereço de e-mail e enviaremos um link de redefinição de senha que permitirá que você escolha uma nova.') }}
        </p>
    </div>

    {{-- 1. Status da Sessão (Mensagem de Sucesso/Erro) --}}
    @if (session('status'))
        <div class="alert alert-success mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        {{-- Campo Email --}}
        <div class="mb-4">
            <label for="email" class="form-label fw-semibold">{{ __('Email') }}</label>
            <input 
                id="email" 
                class="form-control @error('email') is-invalid @enderror" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus 
                autocomplete="username"
            >
            
            {{-- Exibe Erro de Validação --}}
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Botão de Submissão --}}
        <div class="d-flex justify-content-end mt-4">
            {{-- Botão usa o VERDE-ÁGUA (Accent Color) --}}
            <button type="submit" class="btn btn-lg" style="background-color: #00897b; border-color: #00897b; color: white;">
                <i class="bi bi-send-fill me-1"></i> {{ __('Enviar Link de Redefinição') }}
            </button>
        </div>
    </form>
</div>
@endsection