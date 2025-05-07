@extends('layouts.app')

@section('title', $movie['title'])





@section('content')
    <div>
        <div class="container mx-auto px-4">
            <!-- Back Button -->
            <a href="{{ route('movies.index') }}"
               class="inline-flex items-center text-movie-accent hover:text-white mb-6 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back to Popular Movies
            </a>

            <!-- Movie Header Section -->
            <div class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden mb-8 border border-gray-700">
                <div class="md:flex">
                    <!-- Movie Poster -->
                    <div class="md:w-1/3 relative">
                        @if ($movie['poster_path'])
                            <img
                                src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                                alt="{{ $movie['title'] }}"
                                class="w-full h-full object-cover"
                            >
                        @else
                            <div class="w-full h-96 bg-gray-700 flex items-center justify-center text-gray-500">
                                <i class="fas fa-image text-5xl"></i>
                            </div>
                        @endif

                        <!-- Action Buttons (Mobile) -->
                        <div class="md:hidden flex justify-center space-x-4 p-4 bg-gray-900/80">
                            <button
                                class="watchlist-btn-mobile flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 text-white">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button
                                class="watched-btn-mobile flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 text-white">
                                <i class="fas fa-check"></i>
                            </button>
                            <button
                                class="like-btn-mobile flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-red-500 to-yellow-500 text-white">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Movie Details -->
                    <div class="p-6 md:w-2/3">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-3xl font-bold text-white mb-2">{{ $movie['title'] }}</h1>
                                <div class="flex flex-wrap items-center gap-3 mb-4">
                                <span class="px-3 py-1 rounded-full bg-gray-700 text-white text-sm">
                                    {{ $movie['release_date'] ? substr($movie['release_date'], 0, 4) : 'N/A' }}
                                </span>
                                    <span class="text-gray-400">•</span>
                                    <span class="text-gray-300">{{ $movie['runtime'] ?? 'N/A' }} mins</span>
                                    <span class="text-gray-400">•</span>
                                    @foreach ($movie['genres'] as $genre)
                                        <span
                                            class="px-3 py-1 rounded-full bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-200 text-sm border border-cyan-500/30">
                                    {{ $genre['name'] }}
                                </span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Action Buttons (Desktop) -->
                            <form action="{{ route('watchlist.add', ['movie'=>$movie['id'], 'user'=>auth()->user()->id]) }}" method="POST" x-ref="watchlistAddForm">@csrf</form>
                            <form action="{{ route('watchlist.remove', ['movie'=>$movie['id'], 'user'=>auth()->user()->id]) }}" method="POST" x-ref="watchlistRemoveForm">@csrf</form>

                            <div class="hidden md:flex space-x-3">

                                <!-- add to watchlist button -->
                                <button 
                                    @if($inWatchlist) 
                                        class="watchlist-btn flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 text-white  opacity-70 transition-opacity"
                                        @click="$refs.watchlistRemoveForm.submit()"
                                    @else
                                        class="watchlist-btn flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 text-white hover:opacity-90 transition-opacity"
                                        @click="$refs.watchlistAddForm.submit()"
                                    @endif
                                >
                                    <i class="fas fa-plus mr-2"></i>
                                    @if($inWatchlist)
                                        In Watchlist
                                    @else
                                        Watchlist
                                    @endif
                                </button>


                                <!-- watched button -->
                                <form action="{{ route('watched.add', ['movie'=>$movie['id']]) }}" method="POST" x-ref="watchedAddForm">@csrf</form>
                                <form action="{{ route('watched.remove', ['movie'=>$movie['id']]) }}" method="POST" x-ref="watchedRemoveForm">@csrf</form>

                                <button 
                                    @if ($isWatched)
                                        @click="$refs.watchedRemoveForm.submit()"
                                    @else 
                                        @click="$refs.watchedAddForm.submit()"
                                    @endif
                                    class="watched-btn flex items-center justify-center w-10 h-10 rounded-full transition-opacity
                                        {{ $isWatched ? 'bg-green-500 opacity-70' : 'bg-gradient-to-r from-purple-500 to-pink-500 hover:opacity-90 text-white' }}"
                                    
                                >
                                    <i class="fas fa-check"></i>
                                </button>


                                <button onclick="toggleModal('addToPlaylistModal')" class="text-white bg-cyan-500 hover:bg-cyan-600 rounded-full p-2">
                                    <i class="fas fa-plus"></i>
                                </button>
                                
                            </div>
                        </div>


                        <!-- Add to Playlist Modal -->
                        
                        <div id="addToPlaylistModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                            <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
                                <h2 class="text-2xl font-bold text-white mb-4">Add to Playlist</h2>
                                <form action="{{ route('playlist.addMovie') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="movieID" value="{{ $movie['id'] }}"> <!-- assumes $movie is an array -->

                                    <div class="mb-4">
                                        <label for="playlistID" class="block text-gray-300 mb-2">Choose Playlist</label>
                                        <select name="playlistID" id="playlist" class="w-full bg-gray-700 text-white rounded-lg px-4 py-2">
                                            @foreach ($playlists as $playlist)
                                                <option value="{{ $playlist->id }}">{{ $playlist->playlist_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="button" onclick="toggleModal('addToPlaylistModal')" class="mr-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Cancel</button>
                                        <button type="submit" class="px-4 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>





                        <!-- Rating -->
                        <div class="flex items-center mb-6">
                            <div class="relative w-16 h-16 mr-4">
                                <svg class="w-full h-full" viewBox="0 0 36 36">
                                    <path d="M18 2.0845
                                      a 15.9155 15.9155 0 0 1 0 31.831
                                      a 15.9155 15.9155 0 0 1 0 -31.831"
                                          fill="none" stroke="#333" stroke-width="3" stroke-dasharray="100, 100"/>
                                    <path d="M18 2.0845
                                      a 15.9155 15.9155 0 0 1 0 31.831
                                      a 15.9155 15.9155 0 0 1 0 -31.831"
                                          fill="none" stroke="#00dbde" stroke-width="3"
                                          stroke-dasharray="{{ $movie['vote_average'] * 10 }}, 100"/>
                                </svg>
                                <div
                                    class="absolute inset-0 flex items-center justify-center text-white font-bold text-sm">
                                    {{ number_format($movie['vote_average'], 1) }}
                                </div>
                            </div>
                            <span class="text-gray-300">({{ $movie['vote_count'] }} votes)</span>
                        </div>

                        <!-- Overview -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-white mb-3 relative pb-2 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-10 after:h-0.5 after:bg-gradient-to-r after:from-cyan-500 after:to-blue-500">
                                Overview
                            </h2>
                            <p class="text-gray-300 leading-relaxed">{{ $movie['overview'] ?? 'No overview available.' }}</p>
                        </div>

                        <!-- Director & Cast -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-white mb-3">Cast & Crew</h2>
                            <div class="space-y-4">
                                <!-- Director -->
                                @if (!empty($movie['credits']['crew']))
                                    <div>
                                        <h3 class="text-gray-400 font-medium mb-2">Director</h3>
                                        <div class="flex flex-wrap gap-3">
                                            @foreach ($movie['credits']['crew'] as $crew)
                                                @if ($crew['job'] === 'Director')
                                                    <a href="{{ route('person.show', $crew['id']) }}"
                                                       class="px-4 py-2 bg-gray-700 rounded-full text-white">
                                                        {{ $crew['name'] }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Main Cast -->
                                @if (!empty($movie['credits']['cast']))
                                    <div>
                                        <h3 class="text-gray-400 font-medium mb-2">Main Cast</h3>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                            @foreach (array_slice($movie['credits']['cast'], 0, 8) as $cast)
                                                <div class="flex items-center space-x-3">
                                                    @if ($cast['profile_path'])
                                                        <img
                                                            src="https://image.tmdb.org/t/p/w92{{ $cast['profile_path'] }}"
                                                            alt="{{ $cast['name'] }}"
                                                            class="w-10 h-10 rounded-full object-cover"
                                                        >
                                                    @else
                                                        <div
                                                            class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center text-gray-500">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <a href="{{ route('person.show', $cast['id']) }}"
                                                           class="text-white text-sm font-medium hover:underline">
                                                            {{ $cast['name'] }}
                                                        </a>
                                                        <p class="text-gray-400 text-xs">{{ $cast['character'] }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trailer Section -->

            <div class="bg-gray-800 rounded-2xl shadow-xl p-6 mb-8 border border-gray-700">
                <h2 class="text-2xl font-bold text-white mb-6 relative pb-2 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-10 after:h-0.5 after:bg-gradient-to-r after:from-cyan-500 after:to-blue-500">
                    Official Trailer
                </h2>
                <div class="aspect-w-16 aspect-h-9 bg-black rounded-lg overflow-hidden">
                    @if(isset($movie['videos']['results']))
                        @php
                            // Find the first official trailer
                            $trailer = collect($movie['videos']['results'])->firstWhere('type', 'Trailer');

                            // If no official trailer, try to find any YouTube video
                            if (!$trailer) {
                                $trailer = collect($movie['videos']['results'])->firstWhere('site', 'YouTube');
                            }
                        @endphp

                        @if ($trailer)
                            <iframe
                                class="w-full h-96"
                                src="https://www.youtube.com/embed/{{ $trailer['key'] }}?autoplay=0&rel=0"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        @else
                            <div class="w-full h-96 bg-gray-700 flex items-center justify-center text-gray-500">
                                <div class="text-center">
                                    <i class="fas fa-film text-5xl mb-3"></i>
                                    <p>Trailer not available</p>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="w-full h-96 bg-gray-700 flex items-center justify-center text-gray-500">
                            <div class="text-center">
                                <i class="fas fa-film text-5xl mb-3"></i>
                                <p>Trailer information not loaded</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Stats Section -->
            <div class="bg-gray-800 rounded-2xl shadow-xl p-6 mb-8 border border-gray-700">
                <h2 class="text-2xl font-bold text-white mb-6 relative pb-2 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-10 after:h-0.5 after:bg-gradient-to-r after:from-cyan-500 after:to-blue-500">
                    Movie Stats
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Views Counter -->
                    <div class="bg-gray-700/50 rounded-xl p-5 text-center border border-cyan-500/20">
                        <div class="text-4xl text-movie-accent font-bold mb-2">1.2M</div>
                        <div class="text-gray-300">Total Views</div>
                    </div>

                    <!-- Watchlist Counter -->
                    <div class="bg-gray-700/50 rounded-xl p-5 text-center border border-blue-500/20">
                        <div class="text-4xl text-blue-400 font-bold mb-2">45K</div>
                        <div class="text-gray-300">In Watchlists</div>
                    </div>

                    <!-- Likes Counter -->
                    <div class="bg-gray-700/50 rounded-xl p-5 text-center border border-red-500/20">
                        <div class="text-4xl text-red-400 font-bold mb-2">89K</div>
                        <div class="text-gray-300">Likes</div>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="bg-gray-800 rounded-2xl shadow-xl p-6 mb-8 border border-gray-700">
                <h2 class="text-2xl font-bold text-white mb-6 relative pb-2 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-10 after:h-0.5 after:bg-gradient-to-r after:from-cyan-500 after:to-blue-500">
                    User Reviews
                </h2>

                <!-- Review Form -->
                <div class="bg-gray-700 rounded-xl p-5 mb-8" x-data="{ rating:0 }">
                    <h3 class="text-lg font-semibold text-white mb-4">Write a Review</h3>
                    <form
                        action="{{ auth()->check() ? route('postReview', ['movie' => $movie['id'], 'user' => auth()->user()->id]) : route('login.index') }}"
                        method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-300 mb-2">Your Rating</label>
                            <div class="flex space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button"
                                            class="text-2xl text-gray-400 hover:text-yellow-400 focus:outline-none"
                                            :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-400'"
                                            @click="rating = {{ $i }}">
                                        ★
                                    </button>
                                @endfor
                            </div>
                        </div>
                        <input type="hidden" name="rating" :value="rating">
                        <div class="mb-4">
                        <textarea
                            name="description"
                            class="w-full bg-gray-800 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-cyan-500"
                            rows="4"
                            placeholder="Share your thoughts about this movie..."></textarea>
                        </div>
                        <button
                            type="submit"
                            class="px-6 py-2 bg-gradient-to-r from-cyan-500 to-blue-500 text-white rounded-full hover:opacity-90 transition-opacity">
                            Submit Review
                        </button>
                    </form>
                </div>


                <!-- Reviews List -->
                <div class="space-y-6">
                    @if ($reviews->isEmpty())
                        <div class="bg-gray-700 text-gray-300 p-6 rounded-xl text-center">
                            <h3 class="text-xl font-semibold mb-2">No Reviews Yet</h3>
                            <p>Be the first to share your thoughts about this movie. We'd love to hear what you
                                think!</p>
                        </div>
                    @else
                        @foreach($reviews as $review)
                            <div class="bg-gray-700 rounded-xl p-5">
                                <div class="flex items-start space-x-4">
                                    <!-- Profile Picture -->
                                    <a href="{{ auth()->check() && auth()->id() === $review['userID'] ? route('profile.private') : route('profile.public', ['user' => $review['userID']]) }}"
                                       class="w-12 h-12 rounded-full bg-gray-600 flex items-center justify-center text-gray-300 overflow-hidden">
                                        @if ($review['user_pfp'])
                                            <img src="{{ $review['user_pfp'] }}" alt="{{ $review['username'] }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-user text-xl"></i>
                                        @endif
                                    </a>

                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <!-- Username -->
                                            <a href="{{ auth()->check() && auth()->id() === $review['userID'] ? route('profile.private') : route('profile.public', ['user' => $review['userID']]) }}"
                                               class="text-white font-medium hover:underline">
                                                {{ $review['username'] }}
                                            </a>
                                            <div class="flex items-center">
                                <span class="text-yellow-400 mr-1">
                                    @for ($i = 0; $i < $review['rating']; $i++)
                                        ★
                                    @endfor
                                </span>
                                                <span class="text-gray-400 text-sm">{{ $review['rating'] }}/5</span>
                                            </div>
                                        </div>
                                        <p class="text-gray-400 text-sm mb-2">{{ \Carbon\Carbon::parse($review['created_at'])->diffForHumans() }}</p>
                                        <p class="text-gray-300">{{ $review['description'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                

                <!-- View All Reviews Button -->
-
                @if ($reviews->count() > 4)
                    <div class="mt-6 text-center">
                        <button
                            class="px-6 py-2 border border-cyan-500 text-cyan-400 rounded-full hover:bg-cyan-500/10 transition-colors">
                            View All Reviews
                        </button>
                    </div>

                @endif
            </div>

            <!-- Similar Movies Section -->
            @if (!empty($similarMovies))
                <div class="mb-10">
                    <h2 class="text-2xl font-bold text-white mb-6 relative pb-2 after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-10 after:h-0.5 after:bg-gradient-to-r after:from-cyan-500 after:to-blue-500">
                        You May Also Like
                    </h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                        @foreach ($similarMovies as $similar)
                            <div
                                class="group relative rounded-xl overflow-hidden transition-all duration-300 hover:transform hover:scale-105 hover:shadow-2xl">
                                <a href="{{ route('movies.show', $similar['id']) }}" class="block">
                                    <div class="relative pb-[150%]">
                                        @if ($similar['poster_path'])
                                            <img
                                                src="https://image.tmdb.org/t/p/w500{{ $similar['poster_path'] }}"
                                                alt="{{ $similar['title'] }}"
                                                class="absolute h-full w-full object-cover"
                                                loading="lazy"
                                            >
                                        @else
                                            <div
                                                class="absolute h-full w-full bg-gray-700 flex items-center justify-center text-gray-500">
                                                <i class="fas fa-image text-4xl"></i>
                                            </div>
                                        @endif
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>

                                        <!-- Mobile: Always show basic info -->
                                        <div
                                            class="md:hidden absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent">
                                            <div class="absolute bottom-0 left-0 right-0 p-3">
                                                <h3 class="text-white font-bold text-sm truncate">{{ $similar['title'] }}</h3>
                                                <div class="flex justify-between items-center text-xs">
                                        <span class="text-movie-accent font-medium">
                                            <i class="fas fa-star mr-1"></i>{{ number_format($similar['vote_average'], 1) }}
                                        </span>
                                                    <span class="text-gray-300">
                                            {{ $similar['release_date'] ? substr($similar['release_date'], 0, 4) : 'N/A' }}
                                        </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Desktop: Full details on hover only -->
                                        <div
                                            class="hidden md:flex absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 items-end p-4">
                                            <div
                                                class="w-full transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                                <h3 class="text-white font-bold text-lg mb-1">{{ $similar['title'] }}</h3>
                                                <div class="flex justify-between items-center text-sm mb-3">
                                        <span class="text-movie-accent font-medium">
                                            <i class="fas fa-star mr-1"></i>{{ number_format($similar['vote_average'], 1) }}
                                        </span>
                                                    <span class="text-gray-300">
                                            {{ $similar['release_date'] ? substr($similar['release_date'], 0, 4) : 'N/A' }}
                                        </span>
                                                </div>
                                                <button
                                                    class="w-full py-1.5 bg-gradient-to-r from-cyan-500 to-blue-500 text-white rounded-full text-sm font-medium hover:opacity-90 transition-opacity">
                                                    <i class="fas fa-plus mr-1"></i> Watchlist
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>



    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
        }
    </script>
    
@endsection
