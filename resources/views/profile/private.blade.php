@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Profile Header -->
        <div class="flex items-center justify-between gap-6 mb-8">
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 rounded-full bg-gray-700 flex items-center justify-center text-gray-500">
                    @if ($user->pfp)
                        <img
                            src="{{ $user->pfp }}"
                            alt="{{ $user->name }}"
                            class="w-full h-full rounded-full object-cover">
                    @else
                        <i class="fas fa-user text-4xl"></i>
                    @endif
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">{{ $user->name }}</h1>
                    <!-- Edit Profile Button -->
                    <button
                            class="px-4 py-2 mt-2 inline-block bg-cyan-500 text-white rounded-full hover:bg-cyan-600 transition-all"
                            onclick="toggleModal('editProfileModal')">
                        Edit Profile
                    </button>
                </div>
            </div>


            <!-- Edit Profile Modal -->
            <div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold text-white">Edit Profile</h2>
                        <button onclick="toggleModal('editProfileModal')" class="text-gray-400 hover:text-white">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Profile Picture Upload -->
                        <div class="mb-6 text-center">
                            <div class="relative mx-auto w-32 h-32 rounded-full overflow-hidden bg-gray-700 mb-4">
                                @if ($user->pfp)
                                    <img id="profilePicturePreview" src="{{ $user->pfp }}" alt="Current Profile Picture"
                                         class="w-full h-full object-cover">
                                @else
                                    <div id="profilePicturePreview" class="w-full h-full flex items-center justify-center text-gray-500">
                                        <i class="fas fa-user text-5xl"></i>
                                    </div>
                                @endif
                            </div>

                            <label for="pfp" class="cursor-pointer">
                                <div class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-all inline-flex items-center">
                                    <i class="fas fa-camera mr-2"></i>
                                    <span>Change Photo</span>
                                    <input type="file" name="pfp" id="pfp" accept="image/*"
                                           class="hidden" onchange="previewProfilePicture(event)">
                                </div>
                            </label>
                        </div>

                        <!-- Name Field -->
                        <div class="mb-4">
                            <label for="name" class="block text-gray-300 mb-2">Name</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}"
                                   class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>

                        <div class="flex justify-end gap-2 pt-4">
                            <button type="button"
                                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all"
                                    onclick="toggleModal('editProfileModal')">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600 transition-all">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Stats -->
            <div class="flex gap-4">
                <div class="text-center">
                    <h2 class="text-xl font-bold text-white">{{ $moviesLiked }}</h2>
                    <p class="text-gray-400 text-sm">Movies Liked</p>
                </div>
                <div class="text-center">
                    <h2 class="text-xl font-bold text-white">{{ $reviewsCount }}</h2>
                    <p class="text-gray-400 text-sm">Reviews</p>
                </div>
                <div class="text-center">
                    <h2 class="text-xl font-bold text-white cursor-pointer" onclick="toggleModal('followersModal')">{{ $followers }}</h2>
                    <p class="text-gray-400 text-sm">Followers</p>
                </div>
                <div class="text-center">
                    <h2 class="text-xl font-bold text-white cursor-pointer" onclick="toggleModal('followingModal')">{{ $following }}</h2>
                    <p class="text-gray-400 text-sm">Following</p>
                </div>
            </div>
        </div>

        <!-- Followers Modal -->
        <div id="followersModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
                <h2 class="text-2xl font-bold text-white mb-6 text-center">Followers</h2>
                <ul class="space-y-4">
                    @foreach ($user->followers as $follower)
                        <li class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-gray-700 overflow-hidden">
                                    @if ($follower->pfp)
                                        <img src="{{ $follower->pfp }}" alt="{{ $follower->name }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-user text-gray-500 text-xl"></i>
                                    @endif
                                </div>
                                <a href="{{ route('profile.public', ['user' => $follower->id]) }}" class="text-white hover:underline">
                                    {{ $follower->name }}
                                </a>
                            </div>
                            @if (auth()->user()->following->contains($follower->id))
                                <form action="{{ route('profile.unfollow', ['user' => $follower->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition-all">
                                        Unfollow
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('profile.follow', ['user' => $follower->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-cyan-500 text-white rounded-full hover:bg-cyan-600 transition-all">
                                        Follow
                                    </button>
                                </form>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <button class="mt-6 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all" onclick="toggleModal('followersModal')">
                    Close
                </button>
            </div>
        </div>

        <!-- Following Modal -->
        <div id="followingModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
                <h2 class="text-2xl font-bold text-white mb-6 text-center">Following</h2>
                <ul class="space-y-4">
                    @foreach ($user->following as $followed)
                        <li class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-gray-700 overflow-hidden">
                                    @if ($followed->pfp)
                                        <img src="{{ $followed->pfp }}" alt="{{ $followed->name }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-user text-gray-500 text-xl"></i>
                                    @endif
                                </div>
                                <a href="{{ route('profile.public', ['user' => $followed->id]) }}" class="text-white hover:underline">
                                    {{ $followed->name }}
                                </a>
                            </div>
                            <form action="{{ route('profile.unfollow', ['user' => $followed->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition-all">
                                    Unfollow
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
                <button class="mt-6 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all" onclick="toggleModal('followingModal')">
                    Close
                </button>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-white mb-4">Recent Activity</h2>
            <ul class="space-y-4">
                @foreach ($recentActivity as $activity)
                    <li class="bg-gray-800 p-4 rounded-lg">
                        <p class="text-white">{{ $activity }}</p>
                    </li>
                @endforeach
            </ul>
        </div>


        <!-- Lists -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-white mb-4">My Playlists</h2>
                <button
                    onclick="toggleModal('createPlaylistModal')"
                    class="px-4 py-2 bg-cyan-500 text-white rounded-full hover:bg-cyan-600 transition-all">
                    + Create Playlist
                </button>
            </div>
            <!-- playlists -->
            <!-- User's Playlists -->
            <div class="mb-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($playlists as $playlist)
                        <a href="{{ route('playlist.show', [$playlist['id']]) }}" class="block bg-gray-800 p-4 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                            <h3 class="text-white font-bold text-lg">{{ $playlist->playlist_name }}</h3>
                            <p class="text-gray-400 text-sm mt-1">{{ $playlist->description }}</p>
                        </a>
                    @empty
                        <p class="text-gray-400">You haven't created any playlists yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Create Playlist Modal -->
        <div id="createPlaylistModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
                <h2 class="text-2xl font-bold text-white mb-4">Create New Playlist</h2>
                <form action="{{ route('playlist.create') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="playlist_name" class="block text-gray-300 mb-2">Name</label>
                        <input type="text" name="playlist_name" id="name" required
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-300 mb-2">Description</label>
                        <textarea name="description" id="description" rows="3"
                                class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all mr-2" onclick="toggleModal('createPlaylistModal')">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600 transition-all">Create</button>
                    </div>
                </form>
            </div>
        </div>



        <!-- Diary -->
        <div>

            <h2 class="text-2xl font-bold text-white mb-4">My Diary</h2>

            <ul class="space-y-4">
                <!--
                @foreach ($diaryEntries as $entry)
                    <li class="bg-gray-800 p-4 rounded-lg">
                        <h3 class="text-white font-bold">{{ $entry->title }}</h3>
                        <p class="text-gray-400">{{ $entry->content }}</p>
                    </li>
                @endforeach
                -->

                @foreach ($watchedMovies as $watched)
                    @if ($watched && is_object($watched))
                        <li class="bg-gray-800 p-4 rounded-lg flex items-center gap-4">
                            <div class="w-16 h-24 rounded overflow-hidden bg-gray-700">
                                @if (!empty($watched->poster_path))
                                    <img src="https://image.tmdb.org/t/p/w200{{ $watched->poster_path }}" alt="{{ $watched->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-500">
                                        <i class="fas fa-film text-xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-white font-bold">{{ \Carbon\Carbon::parse($watched->watched_at)->format('jS F Y') }} - watched {{ $watched->title }}</h3>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>



        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }

        function previewProfilePicture(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('profilePicturePreview');

            if (file) {
                // If it's a div with icon, convert it to an img element
                if (preview.tagName === 'DIV') {
                    const img = document.createElement('img');
                    img.id = 'profilePicturePreview';
                    img.className = 'w-full h-full object-cover';
                    preview.parentNode.replaceChild(img, preview);
                    preview = img;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
