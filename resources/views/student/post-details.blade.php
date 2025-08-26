<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Tuition Post Details</h3>
                        <a href="{{ route('student.my-posts') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to My Posts
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Post Details -->
                    <div class="mb-8">
                        <div class="flex items-center space-x-3 mb-4">
                            <h4 class="text-2xl font-semibold text-gray-900">{{ $post->title }}</h4>
                            <span class="px-3 py-1 text-sm font-medium rounded-full 
                                @if($post->status === 'approved') bg-green-100 text-green-800
                                @elseif($post->status === 'rejected') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($post->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <h5 class="text-lg font-medium text-gray-900 mb-3">Post Information</h5>
                                <div class="space-y-3">
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
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Created:</span>
                                        <p class="text-gray-900">{{ $post->created_at->format('F d, Y \a\t g:i A') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h5 class="text-lg font-medium text-gray-900 mb-3">Description</h5>
                                <p class="text-gray-900">{{ $post->description }}</p>
                                
                                @if($post->availability)
                                    <div class="mt-4">
                                        <h6 class="text-sm font-medium text-gray-500">Availability:</h6>
                                        <p class="text-gray-900 mt-1">{{ $post->availability }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($post->status === 'pending')
                            <div class="flex space-x-3">
                                <a href="{{ route('student.posts.edit', $post) }}" 
                                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Edit Post
                                </a>
                                
                                <form action="{{ route('student.posts.delete', $post) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                            onclick="return confirm('Are you sure you want to delete this post?')">
                                        Delete Post
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <!-- Applications Section -->
                    <div class="border-t border-gray-200 pt-6">
                        <h5 class="text-lg font-medium text-gray-900 mb-4">Applications ({{ $post->applications->count() }})</h5>
                        
                        @if($post->applications->count() > 0)
                            <div class="space-y-4">
                                @foreach($post->applications as $application)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-3 mb-2">
                                                    <h6 class="font-medium text-gray-900">{{ $application->tutor->name }}</h6>
                                                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                        @if($application->status === 'accepted') bg-green-100 text-green-800
                                                        @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                                        @else bg-yellow-100 text-yellow-800 @endif">
                                                        {{ ucfirst($application->status) }}
                                                    </span>
                                                </div>
                                                
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                                                    <div>
                                                        <span class="text-sm font-medium text-gray-500">Rating:</span>
                                                        <p class="text-gray-900">{{ $application->tutor->rating }}/5.0 ({{ $application->tutor->total_reviews }} reviews)</p>
                                                    </div>
                                                    <div>
                                                        <span class="text-sm font-medium text-gray-500">Location:</span>
                                                        <p class="text-gray-900">{{ $application->tutor->address }}</p>
                                                    </div>
                                                    <div>
                                                        <span class="text-sm font-medium text-gray-500">Proposed Rate:</span>
                                                        <p class="text-gray-900">{{ $application->proposed_rate ? '৳' . $application->proposed_rate : 'Not specified' }}</p>
                                                    </div>
                                                </div>

                                                @if($application->tutor->bio)
                                                    <div class="mb-3">
                                                        <span class="text-sm font-medium text-gray-500">Bio:</span>
                                                        <p class="text-gray-900 mt-1">{{ Str::limit($application->tutor->bio, 200) }}</p>
                                                    </div>
                                                @endif

                                                <div class="mb-3">
                                                    <span class="text-sm font-medium text-gray-500">Message:</span>
                                                    <p class="text-gray-900 mt-1">{{ $application->message }}</p>
                                                </div>

                                                <div class="text-sm text-gray-500">
                                                    Applied: {{ $application->created_at->format('M d, Y \a\t g:i A') }}
                                                </div>
                                            </div>

                                            <div class="flex flex-col space-y-2 ml-4">
                                                @if($application->status === 'pending')
                                                    <form action="{{ route('student.applications.accept', $application) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" 
                                                                class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2 px-4 rounded">
                                                            Accept
                                                        </button>
                                                    </form>
                                                    
                                                    <form action="{{ route('student.applications.reject', $application) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" 
                                                                class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-2 px-4 rounded">
                                                            Reject
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-gray-400 mb-4">
                                    <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No applications yet</h3>
                                <p class="text-gray-500">Tutors will be able to apply to your post once it's approved by the admin.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 