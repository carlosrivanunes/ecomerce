<section class="card shadow-sm p-4 mb-4">
    <header class="mb-4 border-bottom pb-3">
        {{-- Título agora usa a cor mais escura do seu Catálogo: #5d5d81 --}}
        <h2 class="h4 fw-bold" style="color: #5d5d81;">
            <i class="bi bi-person-circle me-2" style="color: #5d5d81;"></i> {{ __('Informações do Perfil') }}
        </h2>

        <p class="text-muted mt-1 small">
            {{ __("Atualize as informações de perfil e endereço de e-mail da sua conta.") }}
        </p>
    </header>

    {{-- Formulário Oculto para Envio de Verificação --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-3">
        @csrf
        @method('patch')

        {{-- 1. Campo Nome --}}
        <div class="mb-3 form-group">
            <label for="name" class="form-label fw-semibold">{{ __('Nome') }}</label>
            <input 
                id="name" 
                name="name" 
                type="text" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus 
                autocomplete="name"
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 2. Campo Email --}}
        <div class="mb-4 form-group">
            <label for="email" class="form-label fw-semibold">{{ __('Email') }}</label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                class="form-control @error('email') is-invalid @enderror" 
                value="{{ old('email', $user->email) }}" 
                required 
                autocomplete="username"
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            {{-- Verificação de Email --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="alert alert-warning py-2 mt-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> 
                    {{ __('Seu endereço de e-mail não foi verificado.') }}

                    {{-- Botão link usa a cor do seu Accent Color: #00897b --}}
                    <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline text-decoration-underline fw-semibold" 
                        style="font-size: 0.9rem; color: #00897b;">
                        {{ __('Clique aqui para reenviar o e-mail de verificação.') }}
                    </button>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success py-2 mt-2" role="alert">
                        <i class="bi bi-check-circle-fill me-1"></i>
                        {{ __('Um novo link de verificação foi enviado para o seu endereço de e-mail.') }}
                    </div>
                @endif
            @endif
        </div>

        {{-- 3. Botão Salvar e Mensagem de Status --}}
        <div class="d-flex align-items-center gap-3">
            {{-- Botão Salvar AGORA usa o VERDE-ÁGUA (Accent Color) --}}
            <button type="submit" class="btn btn-lg" style="background-color: #00897b; border-color: #00897b; color: white;">
                <i class="bi bi-save me-1"></i> {{ __('Salvar') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)"
                    class="alert alert-success py-2 px-3 mb-0 small" role="alert">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ __('Salvo.') }}
                </div>
            @endif
        </div>
    </form>
</section>