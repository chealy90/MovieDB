<div class="container mx-auto px-6 py-4">
    <div class="flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center">
            <a href="{{ url('/') }}" class="text-3xl font-bold no-underline flex items-center">
                <i class="fas fa-film text-movie-accent mr-3"></i>
                <span class="text-white">MovieDB</span>
            </a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden lg:flex items-center space-x-10">
            <a href="{{ route('movies.index') }}" class="text-white nav-link font-medium text-lg">
                <i class="fas fa-fire mr-2 text-movie-accent"></i> Popular
            </a>
            <a href="#" class="text-white nav-link font-medium text-lg">
                <i class="fas fa-play-circle mr-2 text-movie-accent"></i> Now Playing
            </a>
            <a href="#" class="text-white nav-link font-medium text-lg">
                <i class="fas fa-star mr-2 text-movie-accent"></i> Top Rated
            </a>
            <a href="#" class="text-white nav-link font-medium text-lg">
                <i class="fas fa-calendar-alt mr-2 text-movie-accent"></i> Upcoming
            </a>

            <!-- Search Bar -->
            <div class="relative ml-6">
                <form action="{{ route('movies.search') }}" method="GET" id="search-form-desktop">
                    <input type="text"
                           name="query"
                           id="search-input-desktop"
                           placeholder="Search movies..."
                           class="search-box text-white px-5 py-2 rounded-full w-72 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all duration-300"
                           required>
                    <button type="submit" class="absolute right-4 top-2.5 text-gray-300 hover:text-movie-accent transition-colors duration-300">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- User Menu -->
            @auth
                <div class="relative ml-6">
                    <button @click="userMenuOpen = !userMenuOpen" class="flex items-center space-x-3 focus:outline-none">
                        <span class="text-white font-medium">{{ Auth::user()->name }}</span>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 flex items-center justify-center text-white user-avatar overflow-hidden">
                            @if (Auth::user()->pfp)
                                <img src="{{ Auth::user()->pfp }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user text-lg"></i>
                            @endif
                        </div>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-cloak
                         class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-2xl py-2 z-50 overflow-hidden">
                        <a href="{{ route('profile.private') }}" class="block px-5 py-3 text-gray-800 hover:bg-gray-100 transition-colors duration-300 flex items-center">
                            <i class="fas fa-user mr-3 text-cyan-500"></i> My Profile
                        </a>
                        <a href="/watchlist/{{ auth()->user()->id }}" class="block px-5 py-3 text-gray-800 hover:bg-gray-100 transition-colors duration-300 flex items-center">
                            <i class="fas fa-bookmark mr-3 text-purple-500"></i> Watchlist
                        </a>
                        <div class="border-t border-gray-200 my-1"></div>
                        <a href="#"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="block px-5 py-3 text-gray-800 hover:bg-gray-100 transition-colors duration-300 flex items-center">
                            <i class="fas fa-sign-out-alt mr-3 text-red-500"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <div class="flex space-x-4 ml-6">
                    <a href="{{ route('login.index') }}" class="px-5 py-2 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-medium hover:shadow-lg transition-all duration-300">
                        Login
                    </a>
                    <a href="{{ route('register.index') }}" class="px-5 py-2 rounded-full border-2 border-cyan-400 text-white font-medium hover:bg-cyan-500 hover:bg-opacity-20 transition-all duration-300">
                        Register
                    </a>
                </div>
            @endauth
        </nav>

        <!-- Mobile Menu Button -->
        <div class="lg:hidden flex items-center">
            @auth
                <div class="relative mr-5">
                    <button @click="userMenuOpen = !userMenuOpen" class="flex items-center focus:outline-none">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 flex items-center justify-center text-white user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                    </button>
                </div>
            @endauth
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white focus:outline-none">
                <i :class="{'fa-times': mobileMenuOpen, 'fa-bars': !mobileMenuOpen}" class="fas text-2xl"></i>
            </button>
        </div>
    </div>
</div>

<!-- Mobile Menu -->
<div x-show="mobileMenuOpen" x-cloak
     class="lg:hidden bg-gradient-to-b from-gray-900 to-gray-800 px-6 py-4 transition-all duration-500 ease-in-out">
    <div class="container mx-auto">
{{--        search--}}
        <div class="relative mb-4">
            <form action="{{ route('movies.search') }}" method="GET" id="search-form-mobile">
                <input type="text"
                       name="query"
                       id="search-input-mobile"
                       placeholder="Search movies..."
                       class="search-box text-white px-5 py-3 rounded-full w-full focus:outline-none focus:ring-2 focus:ring-purple-500"
                       required>
                <button type="submit" class="absolute right-4 top-3.5 text-gray-300 hover:text-movie-accent">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <a href="{{ route('movies.index') }}" class="block py-3 text-white hover:text-movie-accent transition-colors duration-300 border-b border-gray-700 flex items-center">
            <i class="fas fa-fire mr-3 text-movie-accent"></i> Popular Movies
        </a>
        <a href="#" class="block py-3 text-white hover:text-movie-accent transition-colors duration-300 border-b border-gray-700 flex items-center">
            <i class="fas fa-play-circle mr-3 text-movie-accent"></i> Now Playing
        </a>
        <a href="#" class="block py-3 text-white hover:text-movie-accent transition-colors duration-300 border-b border-gray-700 flex items-center">
            <i class="fas fa-star mr-3 text-movie-accent"></i> Top Rated
        </a>
        <a href="#" class="block py-3 text-white hover:text-movie-accent transition-colors duration-300 border-b border-gray-700 flex items-center">
            <i class="fas fa-calendar-alt mr-3 text-movie-accent"></i> Upcoming
        </a>

        @guest
            <div class="mt-4 pt-2">
                <a href="#" class="block w-full text-center py-2.5 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-medium mb-3">
                    Login
                </a>
                <a href="#" class="block w-full text-center py-2.5 rounded-full border-2 border-cyan-400 text-white font-medium">
                    Register
                </a>
            </div>
        @endguest
    </div>
</div>

<!-- Mobile User Menu -->
<div x-show="userMenuOpen && mobileMenuOpen" x-cloak
     class="lg:hidden bg-gray-800 px-6 py-3 transition-all duration-500 ease-in-out">
    <a href="{{ route('profile.private') }}" class="block px-5 py-3 text-gray-800 hover:bg-gray-100 transition-colors duration-300 flex items-center">
        <i class="fas fa-user mr-3 text-cyan-500"></i> My Profile
    </a>
    <a href={{ Auth::check() ?  "/watchlist/" . auth()->user()->id : "/login" }}" class="block py-3 text-white hover:text-movie-accent transition-colors duration-300 border-b border-gray-700 flex items-center">
       class="block py-3 text-white hover:text-movie-accent transition-colors duration-300 border-b border-gray-700 flex items-center">

        <i class="fas fa-bookmark mr-3 text-purple-400"></i> Watchlist
    </a>
    <a href="#" class="block py-3 text-white hover:text-movie-accent transition-colors duration-300 border-b border-gray-700 flex items-center">
        <i class="fas fa-cog mr-3 text-gray-400"></i> Settings
    </a>
    <div class="border-t border-gray-700 my-1"></div>
    <a href="#"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       class="block py-3 text-white hover:text-red-400 transition-colors duration-300 flex items-center">
        <i class="fas fa-sign-out-alt mr-3 text-red-400"></i> Logout
    </a>
</div>
