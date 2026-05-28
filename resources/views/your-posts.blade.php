@extends('layouts.app')

@section('title', 'My Posts — Quillly')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">My Posts</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $posts->count() }} post{{ $posts->count() !== 1 ? 's' : '' }} total</p>
        </div>
        <a href="{{ route('create-post') }}" class="btn-primary px-5 py-2.5 rounded-xl text-white text-sm font-medium">
            + New Post
        </a>
    </div>

    @forelse ($posts as $post)
        <div class="glass rounded-2xl p-6 mb-4 card-hover fade-in">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            {{ $post->visibility === 'public' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-gray-500/10 text-gray-400 border border-gray-500/20' }}">
                            {{ $post->visibility === 'public' ? 'Public' : 'Private' }}
                        </span>
                        @if($post->category)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                                {{ $post->category->name }}
                            </span>
                        @endif
                        <span class="text-xs text-gray-600">{{ $post->created_at->format('M j, Y') }}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2 truncate">{{ $post->title }}</h3>
                    <p class="text-sm text-gray-400 line-clamp-2 leading-relaxed">{{ $post->body }}</p>

                    <div class="flex items-center gap-4 mt-3">
                        <span class="flex items-center gap-1.5 text-xs text-gray-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            {{ $post->likes->count() }} likes
                        </span>
                        <span class="flex items-center gap-1.5 text-xs text-gray-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            {{ $post->comments->count() }} comments
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="/edit-post/{{ $post->id }}"
                       class="p-2 rounded-lg glass text-gray-400 hover:text-indigo-400 hover:border-indigo-500/30 transition-all" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    <form action="/delete-post/{{ $post->id }}" method="POST" onsubmit="return confirm('Delete this post?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 rounded-lg glass text-gray-400 hover:text-red-400 hover:border-red-500/30 transition-all" title="Delete">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-20">
            <div class="w-16 h-16 rounded-2xl glass flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-400 mb-2">No posts yet</h3>
            <p class="text-sm text-gray-600 mb-6">Start writing and your posts will appear here.</p>
            <a href="{{ route('create-post') }}" class="btn-primary px-5 py-2.5 rounded-xl text-white text-sm font-medium inline-block">Write your first post</a>
        </div>
    @endforelse
</div>
@endsection
