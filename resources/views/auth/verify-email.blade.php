@extends('layouts.guest') {{-- Assume-se que 'layouts.guest' é sua estrutura base para autenticação --}}

@section('content')
<div class="card shadow-lg p-4 p-md-5 mx-auto" style="max-width: 450px;">
    
    <h2 class="h4 fw-bold text-center mb-4" style="color: #5d5d81;">
        <i class="bi bi-patch-check-fill me-2"></i> {{ __('Verifique seu E-mail') }}
    </h2>
    
    {{-- Mensagem Principal --}}
    <div class="mb-4 small" style="color: #5d5d81;">
        <p>
            {{ __('Obrigado por se cadastrar! Antes de começar, você poderia verificar seu endereço de e-mail clicando no link que acabamos de enviar para você? Se você não recebeu o e-mail, teremos prazer em lhe enviar outro.') }}
        </p>
    </div>

    {{-- Mensagem de Confirmação de Reenvio --}}
    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mb-4 small" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i>
            {{ __('Um novo link de verificação foi enviado para o endereço de e-mail que você forneceu durante o cadastro.') }}
        </div>
    @endif

    {{-- Ações: Reenviar e Sair --}}
    <div class="d-flex align-items-center justify-content-between mt-4">
        
        {{-- Formulário para Reenviar E-mail --}}
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                {{-- Botão Reenviar usa o VERDE-ÁGUA (Accent Color) --}}
                <button type="submit" class="btn btn-lg" style="background-color: #00897b; border-color: #00897b; color: white;">
                    <i class="bi bi-envelope-check-fill me-1"></i> {{ __('Reenviar E-mail de Verificação') }}
                </button>
            </div>
        </form>

        {{-- Formulário para Sair --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="btn btn-link text-decoration-underline small" style="color: #5d5d81;">
                {{ __('Sair') }}
            </button>
        </form>
    </div>
</div>
@endsection