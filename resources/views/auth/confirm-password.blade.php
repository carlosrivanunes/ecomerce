@extends('layouts.guest') {{-- Assume-se que 'layouts.guest' é sua estrutura base para autenticação --}}

@section('content')
<div class="card shadow-lg p-4 p-md-5 mx-auto" style="max-width: 400px;">
    
    {{-- Descrição do Propósito --}}
    <div class="mb-4 small" style="color: #5d5d81;">
        <p class="fw-semibold">
            <i class="bi bi-shield-lock-fill me-1"></i> 
            {{ __('Esta é uma área segura do aplicativo. Por favor, confirme sua senha antes de continuar.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        {{-- Campo da Senha --}}
        <div class="mb-4">
            <label for="password" class="form-label fw-semibold">{{ __('Senha') }}</label>

            <input 
                id="password" 
                class="form-control @error('password') is-invalid @enderror" 
                type="password"
                name="password"
                required 
                autocomplete="current-password"
            >

            {{-- Exibe Erro de Validação --}}
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Botão de Submissão --}}
        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-lg" style="background-color: #00897b; border-color: #00897b; color: white;">
                <i class="bi bi-check-circle-fill me-1"></i> {{ __('Confirmar') }}
            </button>
        </div>
    </form>
</div>
@endsection