<header class="p-3 bg-neutral-800 text-white">
    <div class="container mx-auto">
        <div id="header-flex-container" class="flex flex-wrap items-center justify-between flex-row">
            <div class="flex items-center">
                <a href="/" class="mb-2 mb-lg-0 text-white">
                    <img src="{{url('/images/cine.png')}}" width="50">
                </a>
            </div>

            <div class="flex items-center justify-between">
                <form method="GET" action="{{ route('search') }}" class="mr-3" role="search">
                    <input name="query" type="search" class="bg-slate-700 rounded text-white w-80 focus:border-white focus:ring-0" placeholder="Buscar pelicula..." aria-label="Search">
                </form>

                <div id="buttons-header">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('favoritas') }}" class="border border-yellow-400 text-yellow-400 hover:bg-yellow-400 hover:text-gray-800 rounded px-4 py-2"><i class="fa-solid fa-star"></i> Mis Favoritas</a>
                        @else
                            <a href="{{ route('login') }}" class="border border-yellow-400 text-yellow-400 hover:bg-yellow-400 hover:text-gray-800 rounded px-4 py-2"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
                        @endauth
                        
                        @if (Route::has('register'))
                            @auth
                                <form method="POST" action="{{ route('logout') }}" class="inline-block">
                                    @csrf
                
                                    <a href="{{ route('logout') }}" class="border border-red-500 text-red-500 hover:bg-red-500 hover:text-white px-4 py-2 rounded"
                                                onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                        <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
                                    </a>
                                </form>
                            @else
                                <a href="{{ route('register') }}" class="border border-teal-500 text-teal-500 hover:bg-teal-500 hover:text-gray-100 rounded px-4 py-2"><i class="fa-solid fa-user-plus"></i> Registrarse</a>
                            @endguest
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>