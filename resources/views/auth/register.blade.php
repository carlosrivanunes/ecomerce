@extends('layouts.guest') {{-- Assume-se que 'layouts.guest' é sua estrutura base para autenticação --}}

@section('content')
<div class="card shadow-lg p-4 p-md-5 mx-auto" style="max-width: 450px;">
    
    <h2 class="h4 fw-bold text-center mb-4" style="color: #5d5d81;">
        <i class="bi bi-person-plus-fill me-2"></i> {{ __('Criar Nova Conta') }}
    </h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- 1. Campo Nome --}}
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">{{ __('Nome') }}</label>
            <input 
                id="name" 
                class="form-control @error('name') is-invalid @enderror" 
                type="text" 
                name="name" 
                value="{{ old('name') }}" 
                required 
                autofocus 
                autocomplete="name" 
            />
            
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 2. Campo Email --}}
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">{{ __('Email') }}</label>
            <input 
                id="email" 
                class="form-control @error('email') is-invalid @enderror" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autocomplete="username" 
            />
            
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 3. Campo Senha --}}
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">{{ __('Senha') }}</label>
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

        {{-- 4. Campo Confirmar Senha --}}
        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold">{{ __('Confirmar Senha') }}</label>
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

        {{-- 5. Ações (Link para Login + Botão de Registro) --}}
        <div class="d-flex align-items-center justify-content-end pt-2">
            
            {{-- Link para Login (Já Registrado?) usa a cor do seu Accent Color: #00897b --}}
            <a class="text-decoration-underline small" style="color: #00897b;" href="{{ route('login') }}">
                {{ __('Já tem cadastro?') }}
            </a>

            {{-- Botão Registro AGORA usa o VERDE-ÁGUA (Accent Color) --}}
            <button type="submit" class="btn btn-lg ms-4" style="background-color: #00897b; border-color: #00897b; color: white;">
                <i class="bi bi-person-plus-fill me-1"></i> {{ __('Registrar') }}
            </button>
        </div>
    </form>
</div>
@endsection