@extends('layouts.app')

@section('title', 'Explore — Quillly')

@section('content')

<!-- Hero Section -->
<section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-950/60 via-gray-950 to-purple-950/40 pointer-events-none"></div>
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative max-w-4xl mx-auto px-4 py-20 text-center fade-in">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full glass text-xs text-indigo-300 mb-6 border border-indigo-500/20">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 pulse-glow"></span>
            Stories from the community
        </div>
        <h1 class="text-4xl md:text-6xl font-extrabold mb-5 leading-tight">
            Uncover Stories That
            <span class="gradient-text"> Resonate</span>
        </h1>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto mb-8 leading-relaxed">
            Your space to write, express, and share. Create blogs, keep them private, or share them with the world — all in one place.
        </p>
        <div class="flex items-center justify-center gap-3 flex-wrap">
            @auth
                <a href="{{ route('create-post') }}" class="btn-primary px-6 py-3 rounded-xl text-white font-semibold text-sm shadow-lg">
                    ✍️ Write a Post
                </a>
                <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-xl glass text-gray-300 hover:text-white font-medium text-sm transition-all hover:border-indigo-500/40">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-primary px-6 py-3 rounded-xl text-white font-semibold text-sm shadow-lg">
                    Get Started Free
                </a>
                <a href="#posts" class="px-6 py-3 rounded-xl glass text-gray-300 hover:text-white font-medium text-sm transition-all">
                    Browse Posts ↓
                </a>
            @endauth
        </div>
    </div>
</section>

<!-- Search + Filter Bar -->
<div class="max-w-5xl mx-auto px-4 py-8" id="posts">
    <!-- Search -->
    <form action="{{ route('explore.posts') }}" method="GET" class="flex gap-2 mb-6">
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search posts by title or user ID..."
                class="w-full bg-gray-900 border border-white/10 text-gray-100 placeholder-gray-500 rounded-xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
        </div>
        <button type="submit" class="btn-primary px-5 py-3 rounded-xl text-white text-sm font-medium">
            Search
        </button>
        @if(request('search'))
            <a href="{{ route('explore.posts', $category ?? null) }}" class="px-4 py-3 rounded-xl glass text-gray-400 hover:text-white text-sm transition-all">
                Clear
            </a>
        @endif
    </form>

    <!-- Category Filters -->
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('explore.posts') }}"
           class="px-4 py-2 text-xs font-medium rounded-full transition-all {{ !$category ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/25' : 'glass text-gray-400 hover:text-white hover:border-indigo-500/30' }}">
            All Posts
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('explore.posts', $cat->name) }}"
               class="px-4 py-2 text-xs font-medium rounded-full transition-all {{ $category == $cat->name ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/25' : 'glass text-gray-400 hover:text-white hover:border-indigo-500/30' }}">
                {{ $cat->name }}
            </a>
        @endforeach
        @if($category)
            <a href="{{ route('explore.posts') }}" class="px-4 py-2 text-xs font-medium rounded-full glass text-red-400 hover:text-red-300 border border-red-500/20 hover:border-red-500/40 transition-all">
                ✕ Clear Filter
            </a>
        @endif
    </div>

    <!-- Posts Count -->
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gray-500">
            Showing <span class="text-gray-300 font-medium">{{ $posts->total() }}</span> public posts
            @if($category) in <span class="text-indigo-400 font-medium">{{ $category }}</span>@endif
        </p>
    </div>

    <!-- Posts Grid -->
    @forelse ($posts as $post)
        <article class="glass rounded-2xl p-6 mb-5 card-hover fade-in" x-data="{ commentsOpen: false }">
            <!-- Post Header -->
            <div class="flex items-start justify-between gap-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                        {{ strtoupper(substr($post->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-200">{{ $post->user->name ?? 'Unknown' }}</p>
                        <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @if($post->category)
                    <span class="px-2.5 py-1 text-xs rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 flex-shrink-0">
                        {{ $post->category->name }}
                    </span>
                @endif
            </div>

            <!-- Post Content -->
            <h3 class="text-xl font-bold text-white mb-2 leading-snug">{{ $post->title }}</h3>
            <p class="text-gray-400 text-sm leading-relaxed mb-5 line-clamp-3">{{ $post->body }}</p>

            <!-- Actions Bar -->
            <div class="flex items-center gap-4 pt-4 border-t border-white/5">
                <!-- Like Button -->
                @auth
                    <form action="{{ route('like.store', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-1.5 text-sm transition-all group
                            {{ $post->likes->contains('user_id', auth()->id()) ? 'text-indigo-400' : 'text-gray-500 hover:text-indigo-400' }}">
                            <svg class="w-4 h-4 transition-transform group-hover:scale-110 {{ $post->likes->contains('user_id', auth()->id()) ? 'fill-indigo-400' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span class="font-medium">{{ $post->likes->count() }}</span>
                        </button>
                    </form>
                @else
                    <span class="flex items-center gap-1.5 text-sm text-gray-500">
                        <svg class="w-4 h-4 fill-none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span>{{ $post->likes->count() }}</span>
                    </span>
                @endauth

                <!-- Comment Toggle -->
                <button @click="commentsOpen = !commentsOpen"
                    class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-purple-400 transition-all group">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span class="font-medium">{{ $post->comments->count() }}</span>
                    <span class="text-xs" x-text="commentsOpen ? 'Hide' : 'Comments'"></span>
                </button>

                <span class="ml-auto text-xs text-gray-600">{{ $post->created_at->format('M j, Y') }}</span>
            </div>

            <!-- Comments Panel -->
            <div x-show="commentsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="mt-5 pt-5 border-t border-white/5">

                @auth
                    <!-- Comment Form -->
                    <form action="{{ route('comment.store', $post->id) }}" method="POST" class="flex gap-2 mb-5">
                        @csrf
                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-xs font-bold text-white flex-shrink-0 mt-1">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 flex gap-2">
                            <input type="text" name="body" placeholder="Add a comment..."
                                class="flex-1 bg-gray-900/80 border border-white/10 text-gray-100 placeholder-gray-600 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500/40 transition-all">
                            <button type="submit" class="btn-primary px-4 py-2.5 rounded-xl text-white text-sm font-medium flex-shrink-0">
                                Post
                            </button>
                        </div>
                    </form>
                @else
                    <div class="mb-4 p-3 rounded-xl bg-indigo-500/5 border border-indigo-500/15 text-center">
                        <p class="text-sm text-gray-400">
                            <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-medium">Login</a> to like and comment
                        </p>
                    </div>
                @endauth

                <!-- Comments List -->
                @if($post->comments->count())
                    <div class="space-y-3 max-h-64 overflow-y-auto pr-1 custom-scroll">
                        @foreach ($post->comments as $comment)
                            <div class="flex gap-3">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center text-xs font-bold text-gray-300 flex-shrink-0 mt-0.5">
                                    {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex-1 bg-gray-900/60 rounded-xl px-4 py-2.5">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xs font-semibold text-gray-300">{{ $comment->user->name ?? 'Unknown' }}</span>
                                        <span class="text-xs text-gray-600">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-400">{{ $comment->body }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-600 text-center py-4">No comments yet. Be the first!</p>
                @endif
            </div>
        </article>
    @empty
        <div class="text-center py-20">
            <div class="w-16 h-16 rounded-2xl glass flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-400 mb-2">No posts found</h3>
            <p class="text-sm text-gray-600 mb-6">
                @if(request('search'))
                    No results for "{{ request('search') }}"
                @else
                    Be the first to share something!
                @endif
            </p>
            @auth
                <a href="{{ route('create-post') }}" class="btn-primary px-5 py-2.5 rounded-xl text-white text-sm font-medium inline-block">Write a Post</a>
            @else
                <a href="{{ route('login') }}" class="btn-primary px-5 py-2.5 rounded-xl text-white text-sm font-medium inline-block">Get Started</a>
            @endauth
        </div>
    @endforelse

    <!-- Pagination -->
    <div class="mt-10">
        {{ $posts->links() }}
    </div>
</div>

<!-- How It Works Section -->
<section class="max-w-5xl mx-auto px-4 py-16">
    <div class="glass rounded-3xl p-8 md:p-12">
        <div class="grid md:grid-cols-2 gap-10 items-center">
            <div>
                <p class="text-xs font-semibold text-indigo-400 uppercase tracking-widest mb-3">Get Started</p>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 leading-tight">How to publish your first blog?</h2>
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-indigo-400 hover:text-indigo-300 font-semibold text-sm transition-colors">
                    Register now →
                </a>
            </div>
            <div class="space-y-5">
                @foreach([
                    ['01', 'Register by filling in your details — name, email, location.'],
                    ['02', 'Once logged in, click "Write" in the header to create a post.'],
                    ['03', 'Write your title, body, pick a category and set visibility.'],
                    ['04', 'Set to Public and hit Create — your post goes live instantly.'],
                    ['05', 'Set to Private to keep it just for yourself in My Posts.'],
                    ['06', 'Edit or delete any post anytime from the My Posts section.'],
                ] as [$num, $text])
                    <div class="flex gap-4 items-start">
                        <span class="text-xs font-bold text-indigo-400 bg-indigo-500/10 border border-indigo-500/20 rounded-lg px-2 py-1 flex-shrink-0 mt-0.5">{{ $num }}</span>
                        <p class="text-sm text-gray-400 leading-relaxed">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection
