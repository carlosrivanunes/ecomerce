@extends('layouts.guest') {{-- Assume-se que 'layouts.guest' é sua estrutura base para autenticação --}}

@section('content')
<div class="card shadow-lg p-4 p-md-5 mx-auto" style="max-width: 400px;">
    
    <h2 class="h4 fw-bold text-center mb-4" style="color: #5d5d81;">
        <i class="bi bi-box-arrow-in-right me-2"></i> {{ __('Acessar Conta') }}
    </h2>

    {{-- 1. Status da Sessão (Mensagem de Sucesso/Erro Global) --}}
    @if (session('status'))
        <div class="alert alert-success mb-4" role="alert">
            <i class="bi bi-info-circle-fill me-1"></i> {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- 2. Email Address --}}
        <div class="mb-3">
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
            />
            
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 3. Password --}}
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">{{ __('Senha') }}</label>

            <input 
                id="password" 
                class="form-control @error('password') is-invalid @enderror"
                type="password"
                name="password"
                required 
                autocomplete="current-password" 
            />

            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 4. Remember Me --}}
        <div class="mb-4 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember" style="border-color: #00897b;">
            <label for="remember_me" class="form-check-label small" style="color: #5d5d81;">
                {{ __('Lembrar de mim') }}
            </label>
        </div>

        {{-- 5. Ações (Esqueci a Senha + Botão Login) --}}
        <div class="d-flex align-items-center justify-content-between">
            
            @if (Route::has('password.request'))
                {{-- Link usa a cor do seu Accent Color: #00897b --}}
                <a class="text-decoration-underline small" style="color: #00897b;" href="{{ route('password.request') }}">
                    {{ __('Esqueceu sua senha?') }}
                </a>
            @endif

            {{-- Botão Login AGORA usa o VERDE-ÁGUA (Accent Color) --}}
            <button type="submit" class="btn btn-lg" style="background-color: #00897b; border-color: #00897b; color: white;">
                <i class="bi bi-box-arrow-in-right me-1"></i> {{ __('Entrar') }}
            </button>
        </div>
    </form>
</div>
@endsection