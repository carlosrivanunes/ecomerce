<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Faz o login (Laravel Breeze / Fortify)
        $request->authenticate();

        // Regenera a sessão para segurança
        $request->session()->regenerate();

        // Redireciona dependendo do tipo de usuário
        if (Auth::user()->is_admin) {
            // Redireciona para dashboard do admin
            return redirect()->intended('/dashboard');
        }

        // Redireciona para página normal para clientes
        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        //return redirect('/');
        return redirect()->intended(route('home', absolute: false));
    }
}
