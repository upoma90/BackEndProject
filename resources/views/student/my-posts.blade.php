<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Tuition Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">My Tuition Posts</h3>
                        <a href="{{ route('student.create-post') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create New Post
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    @if($posts->count() > 0)
                        <div class="space-y-6">
                            @foreach($posts as $post)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-3">
                                                <h4 class="text-xl font-semibold text-gray-900">{{ $post->title }}</h4>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                    @if($post->status === 'approved') bg-green-100 text-green-800
                                                    @elseif($post->status === 'rejected') bg-red-100 text-red-800
                                                    @else bg-yellow-100 text-yellow-800 @endif">
                                                    {{ ucfirst($post->status) }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                                                <div>
                                                    <span class="text-sm font-medium text-gray-500">Subject:</span>
                                                    <p class="text-gray-900">{{ $post->subject->name }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-sm font-medium text-gray-500">Class Level:</span>
                                                    <p class="text-gray-900">{{ $post->class_level }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-sm font-medium text-gray-500">Location:</span>
                                                    <p class="text-gray-900">{{ $post->location }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-sm font-medium text-gray-500">Budget:</span>
                                                    <p class="text-gray-900">{{ $post->budget ? '৳' . $post->budget : 'Not specified' }}</p>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <span class="text-sm font-medium text-gray-500">Description:</span>
                                                <p class="text-gray-900 mt-1">{{ Str::limit($post->description, 150) }}</p>
                                            </div>

                                            @if($post->availability)
                                                <div class="mb-4">
                                                    <span class="text-sm font-medium text-gray-500">Availability:</span>
                                                    <p class="text-gray-900 mt-1">{{ $post->availability }}</p>
                                                </div>
                                            @endif

                                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                <span>Created: {{ $post->created_at->format('M d, Y') }}</span>
                                                <span>Applications: {{ $post->applications->count() }}</span>
                                            </div>
                                        </div>

                                        <div class="flex flex-col space-y-2">
                                            <a href="{{ route('student.post-details', $post) }}" 
                                               class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded">
                                                View Details
                                            </a>
                                            
                                            @if($post->status === 'pending')
                                                <a href="{{ route('student.posts.edit', $post) }}" 
                                                   class="bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium py-2 px-4 rounded">
                                                    Edit
                                                </a>
                                                
                                                <form action="{{ route('student.posts.delete', $post) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-2 px-4 rounded"
                                                            onclick="return confirm('Are you sure you want to delete this post?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No tuition posts yet</h3>
                            <p class="text-gray-500 mb-6">Create your first tuition post to find the perfect tutor for your needs.</p>
                            <a href="{{ route('student.create-post') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Your First Post
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 