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
                        onclick="toggleModal()">
                        Edit Profile
                    </button>
                </div>
            </div>

            <!-- Modal -->
            <div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                <div class="bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
                    <h2 class="text-2xl font-bold text-white mb-6 text-center">Edit Profile</h2>
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Profile Picture -->
                        <div class="flex flex-col items-center mb-6">
                            <div class="w-24 h-24 rounded-full bg-gray-700 flex items-center justify-center text-gray-500 mb-4">
                                <img
                                    id="profilePicturePreview"
                                    src="{{ $user->pfp ? $user->pfp : '' }}"
                                    alt="{{ $user->name }}"
                                    class="w-full h-full rounded-full object-cover"
                                    onerror="this.src='{{ asset('default-profile.png') }}'; this.onerror=null;">
                            </div>
                            <label class="cursor-pointer bg-cyan-500 text-white px-4 py-2 rounded-lg hover:bg-cyan-600 transition-all">
                                <span>Change Picture</span>
                                <input
                                    type="file"
                                    id="pfp"
                                    name="pfp"
                                    class="hidden"
                                    accept="image/*"
                                    onchange="previewProfilePicture(event)">
                            </label>
                            <p class="text-sm text-gray-400 mt-2">Accepted formats: jpeg, png, jpg, gif. Max size: 2MB.</p>
                        </div>

                        <!-- Name Input -->
                        <div class="mb-6">
                            <label for="name" class="block text-gray-400 mb-2">Name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ $user->name }}"
                                class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                required>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-4">
                            <button
                                type="button"
                                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all"
                                onclick="toggleModal()">
                                Cancel
                            </button>
                            <button
                                type="submit"
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
                    <h2 class="text-xl font-bold text-white">{{ $followers }}</h2>
                    <p class="text-gray-400 text-sm">Followers</p>
                </div>
                <div class="text-center">
                    <h2 class="text-xl font-bold text-white">{{ $following }}</h2>
                    <p class="text-gray-400 text-sm">Following</p>
                </div>
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
            <h2 class="text-2xl font-bold text-white mb-4">My Lists</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($lists as $list)
                    <div class="bg-gray-800 p-4 rounded-lg">
                        <h3 class="text-white font-bold">{{ $list->name }}</h3>
                        <p class="text-gray-400">{{ $list->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Diary -->
        <div>
            <h2 class="text-2xl font-bold text-white mb-4">My Diary</h2>
            <ul class="space-y-4">
                @foreach ($diaryEntries as $entry)
                    <li class="bg-gray-800 p-4 rounded-lg">
                        <h3 class="text-white font-bold">{{ $entry->title }}</h3>
                        <p class="text-gray-400">{{ $entry->content }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        function toggleModal() {
            const modal = document.getElementById('editProfileModal');
            modal.classList.toggle('hidden');
        }

        function previewProfilePicture(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('profilePicturePreview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
