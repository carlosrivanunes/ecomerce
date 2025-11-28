<nav x-data="{ open: false }" class="bg-gray-900 shadow-xl"> 
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-[#ff6347]" /> 
                    </a>
                </div>

                {{-- ======================== MENU DESKTOP ======================== --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    
                    {{-- Nav Links Públicos/Comum --}}
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Início') }}
                    </x-nav-link>

                    @auth
                        {{-- Nav Links Autenticados (Agrupamento de Ações) --}}
                        <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                            <span class="flex items-center">
                                <svg class="h-5 w-5 me-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                                {{ __('Produtos') }}
                            </span>
                        </x-nav-link>

                        <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                            <span class="flex items-center">
                                <svg class="h-5 w-5 me-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c.51 0 .962-.343 1.087-.835l.383-1.437M7.5 14.25V5.106c0-.621.504-1.125 1.125-1.125h9.75c.621 0 1.125.504 1.125 1.125v9.144M7.5 14.25h11.218c.51 0 .962-.343 1.087-.835l.383-1.437M7.5 14.25H5.625m13.5 0H18m-7.5 0h7.5m-7.5 0l-1.125-1.125" />
                                </svg>
                                {{ __('Carrinho') }}
                            </span>
                        </x-nav-link>

                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                            <span class="flex items-center">
                                <svg class="h-5 w-5 me-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10.5 21l5.25-11.25M20.25 7.5H3.75m16.5 0l-1.125-1.5H4.875L3.75 7.5m16.5 0v-2.25A2.25 2.25 0 0017.25 3H6.75a2.25 2.25 0 00-2.25 2.25v2.25" />
                                </svg>
                                {{ __('Pedidos') }}
                            </span>
                        </x-nav-link>
                        
                        <x-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.index')">
                            <span class="flex items-center">
                                <svg class="h-5 w-5 me-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.099 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                                {{ __('Favoritos') }}
                            </span>
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            @auth
            {{-- Dropdown do Usuário (Desktop) --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    {{-- Dropdown Content: Garante texto escuro (text-gray-800) no fundo branco do dropdown padrão --}}
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-gray-800">
                            <span class="flex items-center">
                                <svg class="h-5 w-5 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ __('Perfil') }}
                            </span>
                        </x-dropdown-link>
                        @if(auth()->user()?->is_admin)
                        <x-dropdown-link :href="route('admin.dashboard')" class="text-gray-800">
                            <span class="flex items-center">
                                <svg class="h-5 w-5 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h16.5a2.25 2.25 0 012.25 2.25v13.5a2.25 2.25 0 01-2.25 2.25H3.75m0-18V18" />
                                </svg>
                                {{ __('Dashboard Admin') }}
                            </span>
                        </x-dropdown-link>
                        @endif
                        <div class="border-t border-gray-200 my-1"></div> {{-- Separador --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            {{-- Link de Sair: Cor Coral para destaque negativo --}}
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                <span class="flex items-center text-[#ff6347]">
                                    <svg class="h-5 w-5 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                    {{ __('Sair') }}
                                </span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endauth

            @guest
            {{-- Links de Guest (Desktop) --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                {{-- Link de Login: Texto Cinza Claro, hover em Coral --}}
                <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-[#ff6347] hover:bg-gray-800 rounded-md transition duration-150 ease-in-out">
                    {{ __('Entrar') }}
                </a>
                
                {{-- Botão Registrar: Fundo Coral para Call-to-Action --}}
                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm transition duration-150 ease-in-out" style="background-color: #ff6347; hover-bg: #e55336;">
                    {{ __('Registrar') }}
                </a>
            </div>
            @endguest

            {{-- Botão Hamburger (Mobile) --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-[#ff6347] hover:bg-gray-800 focus:outline-none focus:bg-gray-800 focus:text-[#ff6347] transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ======================== MENU RESPONSIVO (MOBILE) ======================== --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            
            {{-- Nav Links MOBILE: Usando o componente ResponsiveNavLink corrigido --}}
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Início') }}
            </x-responsive-nav-link>
            
            @auth
                <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                    <span class="flex items-center">
                        <svg class="h-5 w-5 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        {{ __('Produtos') }}
                    </span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                    <span class="flex items-center">
                        <svg class="h-5 w-5 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c.51 0 .962-.343 1.087-.835l.383-1.437M7.5 14.25V5.106c0-.621.504-1.125 1.125-1.125h9.75c.621 0 1.125.504 1.125 1.125v9.144M7.5 14.25h11.218c.51 0 .962-.343 1.087-.835l.383-1.437M7.5 14.25H5.625m13.5 0H18m-7.5 0h7.5m-7.5 0l-1.125-1.125" />
                        </svg>
                        {{ __('Carrinho') }}
                    </span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                    <span class="flex items-center">
                        <svg class="h-5 w-5 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10.5 21l5.25-11.25M20.25 7.5H3.75m16.5 0l-1.125-1.5H4.875L3.75 7.5m16.5 0v-2.25A2.25 2.25 0 0017.25 3H6.75a2.25 2.25 0 00-2.25 2.25v2.25" />
                        </svg>
                        {{ __('Meus Pedidos') }}
                    </span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.index')">
                    <span class="flex items-center">
                        <svg class="h-5 w-5 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.099 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                        {{ __('Favoritos') }}
                    </span>
                </x-responsive-nav-link>
            @endauth
        </div>

        @auth
        {{-- Dropdown do Usuário (Mobile) --}}
        <div class="pt-4 pb-1 border-t border-gray-700">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div> 
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div> 
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:bg-gray-700">
                    <span class="flex items-center">
                        <svg class="h-5 w-5 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('Perfil') }}
                    </span>
                </x-responsive-nav-link>

                @if(auth()->user()?->is_admin)
                <x-responsive-nav-link :href="route('admin.dashboard')" class="text-white hover:bg-gray-700">
                    <span class="flex items-center">
                        <svg class="h-5 w-5 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h16.5a2.25 2.25 0 012.25 2.25v13.5a2.25 2.25 0 01-2.25 2.25H3.75m0-18V18" />
                        </svg>
                        {{ __('Dashboard Admin') }}
                    </span>
                </x-responsive-nav-link>
                @endif
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        <span class="flex items-center text-[#ff6347] hover:text-white hover:bg-gray-700">
                            <svg class="h-5 w-5 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                            {{ __('Sair') }}
                        </span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth

        @guest
        {{-- Links de Guest (Mobile) --}}
        <div class="pt-4 pb-3 border-t border-gray-700">
            <div class="space-y-1">
                <x-responsive-nav-link :href="route('login')" class="text-gray-300 hover:text-white hover:bg-gray-700">
                    {{ __('Entrar') }}
                </x-responsive-nav-link>
                
                {{-- Botão Registrar MOBILE: Fundo Coral --}}
                <x-responsive-nav-link :href="route('register')" style="background-color: #ff6347; color: white; border-left: 4px solid #ff6347;" class="hover:bg-[#e55336] hover:text-white">
                    {{ __('Registrar') }}
                </x-responsive-nav-link>
            </div>
        </div>
        @endguest
    </div>
</nav>