<div class="container mx-auto px-6 py-12">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
        <!-- Column 1 -->
        <div class="md:col-span-2">
            <a href="{{ url('/') }}" class="text-3xl font-bold flex items-center mb-4">
                <i class="fas fa-film text-movie-accent mr-3"></i>
                <span class="text-white">MovieDB</span>
            </a>
            <p class="text-gray-400 mb-6">Discover, explore, and enjoy the world of cinema with our extensive collection of movies from every genre and era.</p>

            <div class="flex space-x-5">
                <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-300 hover:text-white hover:bg-gradient-to-r hover:from-cyan-500 hover:to-blue-500 transition-all duration-300">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-300 hover:text-white hover:bg-gradient-to-r hover:from-cyan-500 hover:to-blue-500 transition-all duration-300">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-300 hover:text-white hover:bg-gradient-to-r hover:from-cyan-500 hover:to-blue-500 transition-all duration-300">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-300 hover:text-white hover:bg-gradient-to-r hover:from-cyan-500 hover:to-blue-500 transition-all duration-300">
                    <i class="fab fa-github"></i>
                </a>
            </div>
        </div>

        <!-- Column 2 -->
        <div>
            <h3 class="text-white text-lg font-semibold mb-5 relative pb-2 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-10 after:h-0.5 after:bg-gradient-to-r after:from-cyan-500 after:to-blue-500">
                Quick Links
            </h3>
            <ul class="space-y-3">
                <li><a href="{{ route('movies.index') }}" class="text-gray-400 hover:text-movie-accent transition-colors duration-300">Popular Movies</a></li>
                <li><a href="#" class="text-gray-400 hover:text-movie-accent transition-colors duration-300">Now Playing</a></li>
                <li><a href="#" class="text-gray-400 hover:text-movie-accent transition-colors duration-300">Top Rated</a></li>
                <li><a href="#" class="text-gray-400 hover:text-movie-accent transition-colors duration-300">Upcoming</a></li>
            </ul>
        </div>

        <!-- Column 3 -->
        <div>
            <h3 class="text-white text-lg font-semibold mb-5 relative pb-2 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-10 after:h-0.5 after:bg-gradient-to-r after:from-cyan-500 after:to-blue-500">
                Information
            </h3>
            <ul class="space-y-3">
                <li><a href="#" class="text-gray-400 hover:text-movie-accent transition-colors duration-300">About Us</a></li>
                <li><a href="#" class="text-gray-400 hover:text-movie-accent transition-colors duration-300">Contact</a></li>
                <li><a href="#" class="text-gray-400 hover:text-movie-accent transition-colors duration-300">Privacy Policy</a></li>
                <li><a href="#" class="text-gray-400 hover:text-movie-accent transition-colors duration-300">Terms of Service</a></li>
            </ul>
        </div>

        <!-- Column 4 -->
        <div>
            <h3 class="text-white text-lg font-semibold mb-5 relative pb-2 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-10 after:h-0.5 after:bg-gradient-to-r after:from-cyan-500 after:to-blue-500">
                Newsletter
            </h3>
            <p class="text-gray-400 mb-4">Subscribe to our newsletter for the latest movie updates.</p>
            <div class="flex">
                <input type="email" placeholder="Your email" class="bg-gray-800 text-white px-4 py-2 rounded-l-full focus:outline-none focus:ring-1 focus:ring-cyan-500 w-full">
                <button class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white px-4 py-2 rounded-r-full hover:opacity-90 transition-opacity duration-300">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="border-t border-gray-800 mt-12 pt-8 text-center">
        <p class="text-gray-500 text-sm">
            &copy; {{ date('Y') }} MovieDB. All rights reserved.
            <span class="block mt-1">Data provided by <a href="https://www.themoviedb.org/" class="text-movie-accent hover:underline">TMDb</a></span>
        </p>
    </div>
</div>
