<div class="container mx-auto px-4 py-4">
    <div class="flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-white no-underline flex items-center">
                <i class="fas fa-film text-movie-accent mr-2"></i>
                <span>MovieDB</span>
            </a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center space-x-8">
            <a href="{{ route('movies.index') }}" class="text-white hover:text-movie-accent transition-colors duration-200">
                <i class="fas fa-fire mr-1"></i> Popular
            </a>
            <a href="#" class="text-white hover:text-movie-accent transition-colors duration-200">
                <i class="fas fa-play-circle mr-1"></i> Now Playing
            </a>
            <a href="#" class="text-white hover:text-movie-accent transition-colors duration-200">
                <i class="fas fa-star mr-1"></i> Top Rated
            </a>
            <a href="#" class="text-white hover:text-movie-accent transition-colors duration-200">
                <i class="fas fa-calendar-alt mr-1"></i> Upcoming
            </a>

            <!-- Search Bar -->
            <div class="relative ml-4">
                <input type="text" placeholder="Search movies..."
                       class="bg-movie-primary text-white px-4 py-2 rounded-full w-64 focus:outline-none focus:ring-2 focus:ring-movie-accent">
                <button class="absolute right-3 top-2 text-gray-400 hover:text-movie-accent">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <!-- User Menu -->
            @auth
                <div class="relative ml-4">
                    <button @click="userMenuOpen = !userMenuOpen" class="flex items-center space-x-2 focus:outline-none">
                        <span class="text-white">{{ Auth::user()->name }}</span>
                        <div class="w-8 h-8 rounded-full bg-movie-primary flex items-center justify-center text-white">
                            <i class="fas fa-user"></i>
                        </div>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-cloak
                         class="absolute right-0 mt-2 w-48 bg-movie-primary rounded-md shadow-lg py-1 z-50">
                        <a href="#" class="block px-4 py-2 text-white hover:bg-gray-700">My Profile</a>
                        <a href="#" class="block px-4 py-2 text-white hover:bg-gray-700">Watchlist</a>
                        <a href="#" class="block px-4 py-2 text-white hover:bg-gray-700">Settings</a>
                        <div class="border-t border-gray-700"></div>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="block px-4 py-2 text-white hover:bg-gray-700">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <div class="flex space-x-4 ml-4">
                    {{--                            <a href="{{ route('login') }}" class="text-white hover:text-movie-accent transition-colors duration-200">--}}
                    {{--                                Login--}}
                    {{--                            </a>--}}
                    {{--                            <a href="{{ route('register') }}" class="text-white hover:text-movie-accent transition-colors duration-200">--}}
                    {{--                                Register--}}
                    {{--                            </a>--}}
                </div>
            @endauth
        </nav>

        <!-- Mobile Menu Button -->
        <div class="md:hidden flex items-center">
            @auth
                <div class="relative mr-4">
                    <button @click="userMenuOpen = !userMenuOpen" class="flex items-center focus:outline-none">
                        <div class="w-8 h-8 rounded-full bg-movie-primary flex items-center justify-center text-white">
                            <i class="fas fa-user"></i>
                        </div>
                    </button>
                </div>
            @endauth
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white focus:outline-none">
                <i :class="{'fa-times': mobileMenuOpen, 'fa-bars': !mobileMenuOpen}" class="fas text-xl"></i>
            </button>
        </div>
    </div>
</div>

<!-- Mobile Menu -->
<div x-show="mobileMenuOpen" x-cloak class="md:hidden bg-movie-primary px-4 py-2">
    <div class="container mx-auto">
        <a href="{{ route('movies.index') }}" class="block py-2 text-white hover:text-movie-accent">
            <i class="fas fa-fire mr-2"></i> Popular Movies
        </a>
        <a href="#" class="block py-2 text-white hover:text-movie-accent">
            <i class="fas fa-play-circle mr-2"></i> Now Playing
        </a>
        <a href="#" class="block py-2 text-white hover:text-movie-accent">
            <i class="fas fa-star mr-2"></i> Top Rated
        </a>
        <a href="#" class="block py-2 text-white hover:text-movie-accent">
            <i class="fas fa-calendar-alt mr-2"></i> Upcoming
        </a>

        <div class="relative my-2">
            <input type="text" placeholder="Search movies..."
                   class="bg-movie-dark text-white px-4 py-2 rounded-full w-full focus:outline-none focus:ring-2 focus:ring-movie-accent">
            <button class="absolute right-3 top-2 text-gray-400 hover:text-movie-accent">
                <i class="fas fa-search"></i>
            </button>
        </div>

        @guest
            <div class="border-t border-gray-700 mt-2 pt-2">
                {{--                        <a href="{{ route('login') }}" class="block py-2 text-white hover:text-movie-accent">--}}
                {{--                            <i class="fas fa-sign-in-alt mr-2"></i> Login--}}
                {{--                        </a>--}}
                {{--                        <a href="{{ route('register') }}" class="block py-2 text-white hover:text-movie-accent">--}}
                {{--                            <i class="fas fa-user-plus mr-2"></i> Register--}}
                {{--                        </a>--}}
            </div>
        @endguest
    </div>
</div>

<!-- Mobile User Menu -->
<div x-show="userMenuOpen && mobileMenuOpen" x-cloak class="md:hidden bg-movie-primary px-4 py-2">
    <a href="#" class="block py-2 text-white hover:text-movie-accent">
        <i class="fas fa-user mr-2"></i> My Profile
    </a>
    <a href="#" class="block py-2 text-white hover:text-movie-accent">
        <i class="fas fa-bookmark mr-2"></i> Watchlist
    </a>
    <a href="#" class="block py-2 text-white hover:text-movie-accent">
        <i class="fas fa-cog mr-2"></i> Settings
    </a>
    <div class="border-t border-gray-700"></div>
    {{--            <a href="{{ route('logout') }}"--}}
    {{--               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"--}}
    {{--               class="block py-2 text-white hover:text-movie-accent">--}}
    {{--                <i class="fas fa-sign-out-alt mr-2"></i> Logout--}}
    {{--            </a>--}}
</div>
