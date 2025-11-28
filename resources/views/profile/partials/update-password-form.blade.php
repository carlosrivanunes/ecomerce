<section class="card shadow-sm p-4 mb-4">
    <header class="mb-4 border-bottom pb-3">
        {{-- Título agora usa a Primary Color mais escura do seu Catálogo --}}
        <h2 class="h4 fw-bold" style="color: #5d5d81;">
            <i class="bi bi-key-fill me-2" style="color: #5d5d81;"></i> {{ __('Atualizar Senha') }}
        </h2>

        <p class="text-muted mt-1 small">
            {{ __('Certifique-se de que sua conta esteja usando uma senha longa e aleatória para permanecer segura.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        {{-- Campos de Senha (Mantidos) --}}
        <div class="mb-3 form-group">
            <label for="current_password" class="form-label fw-semibold">{{ __('Senha Atual') }}</label>
            <input 
                id="current_password" 
                name="current_password" 
                type="password" 
                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                autocomplete="current-password"
            >
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-group">
            <label for="password" class="form-label fw-semibold">{{ __('Nova Senha') }}</label>
            <input 
                id="password" 
                name="password" 
                type="password" 
                class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                autocomplete="new-password"
            >
             @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4 form-group">
            <label for="password_confirmation" class="form-label fw-semibold">{{ __('Confirmar Senha') }}</label>
            <input 
                id="password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                autocomplete="new-password"
            >
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Botão Salvar AGORA usa o VERDE-ÁGUA (Accent Color) --}}
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-lg" style="background-color: #00897b; border-color: #00897b; color: white;">
                <i class="bi bi-save me-1"></i> {{ __('Salvar') }}
            </button>

            {{-- Mensagem de Confirmação (Mantida a cor de sucesso padrão do Bootstrap) --}}
            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)"
                    class="alert alert-success py-2 px-3 mb-0 small" role="alert">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ __('Salvo com sucesso!') }}
                </div>
            @endif
        </div>
    </form>
</section>