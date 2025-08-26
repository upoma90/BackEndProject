<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900">Welcome back, {{ auth()->user()->name }}!</h3>
                    <p class="text-gray-600">Manage your tuition posts and find the perfect tutor for your needs.</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <a href="{{ route('student.create-post') }}" class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 hover:shadow-2xl transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Create New Post</p>
                            <p class="text-sm text-gray-500">Post your tuition requirements</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('student.browse-tutors') }}" class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 hover:shadow-2xl transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Browse Tutors</p>
                            <p class="text-sm text-gray-500">Find qualified tutors</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('student.my-posts') }}" class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 hover:shadow-2xl transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">My Posts</p>
                            <p class="text-sm text-gray-500">View your tuition posts</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- My Posts -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">My Tuition Posts</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($myPosts as $post)
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $post->title }}</h4>
                                    <p class="text-sm text-gray-500">{{ $post->subject->name }} • {{ $post->class_level }}</p>
                                    <p class="text-xs text-gray-400">{{ $post->location }} • {{ $post->created_at->diffForHumans() }}</p>
                                    <div class="mt-2">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full 
                                            @if($post->status === 'approved') bg-green-100 text-green-800
                                            @elseif($post->status === 'rejected') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                        @if($post->applications_count > 0)
                                            <span class="ml-2 px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                {{ $post->applications_count }} applications
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-4 flex space-x-2">
                                    <a href="{{ route('student.post-details', $post) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View</a>
                                    <a href="{{ route('student.posts.edit', $post) }}" class="text-green-600 hover:text-green-900 text-sm font-medium">Edit</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-4 text-center text-gray-500">
                            <p>You haven't created any tuition posts yet.</p>
                            <a href="{{ route('student.create-post') }}" class="mt-2 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Create Your First Post
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Applications -->
            @if($recentApplications->count() > 0)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Recent Applications</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($recentApplications as $application)
                            <div class="px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $application->tutor->name }}</h4>
                                        <p class="text-sm text-gray-500">Applied for: {{ $application->tuitionPost->title }}</p>
                                        <p class="text-xs text-gray-400">{{ $application->created_at->diffForHumans() }}</p>
                                        <div class="mt-2">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                @if($application->status === 'accepted') bg-green-100 text-green-800
                                                @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <a href="{{ route('student.post-details', $application->tuitionPost) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 