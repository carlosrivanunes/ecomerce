@extends('layouts.guest') {{-- Assume-se que 'layouts.guest' é sua estrutura base para autenticação --}}

@section('content')
<div class="card shadow-lg p-4 p-md-5 mx-auto" style="max-width: 450px;">
    
    <h2 class="h4 fw-bold text-center mb-4" style="color: #5d5d81;">
        <i class="bi bi-key me-2"></i> {{ __('Redefinir Senha') }}
    </h2>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        {{-- Campo Oculto para o Token de Redefinição --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- 1. Campo Email (Geralmente pré-preenchido) --}}
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">{{ __('Email') }}</label>
            <input 
                id="email" 
                class="form-control @error('email') is-invalid @enderror" 
                type="email" 
                name="email" 
                value="{{ old('email', $request->email) }}" 
                required 
                autofocus 
                autocomplete="username" 
            />
            
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 2. Campo Nova Senha --}}
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">{{ __('Nova Senha') }}</label>
            <input 
                id="password" 
                class="form-control @error('password') is-invalid @enderror" 
                type="password" 
                name="password" 
                required 
                autocomplete="new-password" 
            />
            
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 3. Campo Confirmar Nova Senha --}}
        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold">{{ __('Confirmar Nova Senha') }}</label>
            <input 
                id="password_confirmation" 
                class="form-control @error('password_confirmation') is-invalid @enderror"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password" 
            />
            
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 4. Botão de Submissão --}}
        <div class="d-flex justify-content-end mt-4">
            {{-- Botão usa o VERDE-ÁGUA (Accent Color) --}}
            <button type="submit" class="btn btn-lg" style="background-color: #00897b; border-color: #00897b; color: white;">
                <i class="bi bi-arrow-repeat me-1"></i> {{ __('Redefinir Senha') }}
            </button>
        </div>
    </form>
</div>
@endsection