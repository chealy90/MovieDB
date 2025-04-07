<div class="container mx-auto px-4">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div class="mb-4 md:mb-0">
            <a href="{{ url('/') }}" class="text-xl font-bold flex items-center">
                <i class="fas fa-film text-movie-accent mr-2"></i>
                MovieDB
            </a>
            <p class="text-gray-400 mt-2">Discover your next favorite movie</p>
        </div>

        <div class="flex space-x-6">
            <a href="#" class="text-gray-400 hover:text-white">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-white">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-white">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-white">
                <i class="fab fa-github"></i>
            </a>
        </div>
    </div>

    <div class="border-t border-gray-800 mt-6 pt-6 text-center text-gray-400 text-sm">
        <p>&copy; {{ date('Y') }} MovieDB. All rights reserved.</p>
        <p class="mt-2">Data provided by <a href="https://www.themoviedb.org/" class="text-movie-accent hover:underline">TMDb</a></p>
    </div>
</div>
