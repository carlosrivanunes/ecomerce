<section class="space-y-6">
    <header>
        <h2 class="h4 fw-bold text-danger mb-1">
            <i class="bi bi-person-fill-dash me-2"></i> Excluir Conta (Zona de Perigo)
        </h2>

        <p class="mt-1 text-muted">
            Uma vez que sua conta for excluída, todos os seus recursos e dados serão **permanentemente apagados**. Antes de excluir sua conta, por favor, certifique-se de que não precisa de nenhum dado.
        </p>
    </header>

    {{-- Botão que dispara o Modal --}}
    <button 
        type="button" 
        class="btn btn-danger mt-3" 
        data-bs-toggle="modal" 
        data-bs-target="#confirmUserDeletionModal"
    >
        <i class="bi bi-trash-fill me-1"></i> {{ __('Excluir Conta') }}
    </button>

    {{-- ========================================================== --}}
    {{-- MODAL DE CONFIRMAÇÃO --}}
    {{-- ========================================================== --}}
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                
                {{-- Cabeçalho do Modal --}}
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold" id="confirmUserDeletionLabel">
                        Confirmação de Exclusão
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Formulário de Exclusão (Submissão via POST/DELETE) --}}
                <form method="POST" action="{{ route('profile.destroy') }}" class="p-0">
                    @csrf
                    @method('DELETE')

                    {{-- Corpo do Formulário (dentro do Modal) --}}
                    <div class="modal-body pb-4">
                        <p class="mb-3 text-danger fw-semibold">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> 
                            Tem certeza de que deseja excluir sua conta? Esta ação é **irreversível**.
                        </p>

                        <p class="mb-4 text-muted">
                            Para confirmar esta ação crítica, por favor, digite sua senha.
                        </p>

                        {{-- Campo de senha para confirmação --}}
                        <div class="form-group">
                            <label for="password_delete" class="form-label fw-semibold">
                                {{ __('Senha') }}
                            </label>

                            <input 
                                id="password_delete" 
                                name="password" 
                                type="password" 
                                {{-- Usa a diretiva do Laravel para verificar erro no contexto 'userDeletion' --}}
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                                placeholder="{{ __('Digite sua senha para confirmar') }}"
                                required
                            >

                            {{-- Mensagem de erro customizada (d-block é crucial para modals) --}}
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Rodapé do Modal --}}
                    <div class="modal-footer pt-3 border-top">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Cancelar') }}
                        </button>

                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash-fill me-1"></i> {{ __('Excluir Conta') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>