<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/home.css') }}">
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    {{-- Aplica min-vh-100 (altura mínima de 100% da viewport) e fundo cinza claro --}}
    <body class="bg-light min-vh-100 d-flex justify-content-center align-items-center py-5">
        
        {{-- Container principal, centralizado --}}
        <div class="container d-flex flex-column align-items-center">
            
            {{-- Slot para o Logo (Pode ser ajustado para um <img> ou texto simples) --}}
            <div class="mb-4">
                <a href="/" class="text-decoration-none h1 fw-bold" style="color: #5d5d81;">
                    {{ config('app.name', 'App') }} 
                </a>
            </div>

            {{-- 
                Container do Formulário: 
                - w-100 (largura total)
                - max-w-md (ajustado via max-width no formulário)
                - shadow-md (shadow-lg)
                - rounded-lg
            --}}
            <div class="w-100">
                {{-- AQUI ESTÁ O CONTEÚDO INJETADO: O SEU FORMULÁRIO DE LOGIN/REGISTRO --}}
                @yield('content')
            </div>
        </div>

        {{-- Script do Bootstrap (Obrigatório para Modals, Dropdowns, etc.) --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    </body>
</html>