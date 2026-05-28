@extends('layouts.app')

@section('title', 'Write a Post — Quillly')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-16 relative">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-950/20 via-gray-950 to-purple-950/20 pointer-events-none"></div>

    <div class="relative w-full max-w-2xl">
        <div class="mb-6">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-300 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back
            </a>
        </div>

        <div class="glass rounded-3xl p-8">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-white mb-1">Write a new post</h1>
                <p class="text-sm text-gray-500">Share your thoughts with the world or keep it private.</p>
            </div>

            <form action="/create-post" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Post Title</label>
                    <input type="text" name="title" placeholder="Give your post a compelling title..."
                           class="w-full bg-gray-900/80 border border-white/10 text-gray-100 placeholder-gray-600 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Content</label>
                    <textarea name="body" rows="8" placeholder="Write your story here..."
                              class="w-full bg-gray-900/80 border border-white/10 text-gray-100 placeholder-gray-600 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all resize-none leading-relaxed"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Category</label>
                        <select name="category_id" required
                                class="w-full bg-gray-900/80 border border-white/10 text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Visibility</label>
                        <div class="flex gap-3 h-[46px] items-center">
                            <label class="flex items-center gap-2.5 cursor-pointer group flex-1 bg-gray-900/80 border border-white/10 rounded-xl px-4 py-3 hover:border-indigo-500/30 transition-all has-[:checked]:border-indigo-500/50 has-[:checked]:bg-indigo-500/5">
                                <input type="radio" name="visibility" value="public" checked class="accent-indigo-500 w-4 h-4">
                                <span class="text-sm text-gray-300">Public</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer group flex-1 bg-gray-900/80 border border-white/10 rounded-xl px-4 py-3 hover:border-indigo-500/30 transition-all has-[:checked]:border-indigo-500/50 has-[:checked]:bg-indigo-500/5">
                                <input type="radio" name="visibility" value="private" class="accent-indigo-500 w-4 h-4">
                                <span class="text-sm text-gray-300">Private</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <p class="text-xs text-gray-600">Public posts are visible to everyone. Private posts are only visible to you.</p>
                    <button type="submit" class="btn-primary px-6 py-3 rounded-xl text-white font-semibold text-sm flex-shrink-0 ml-4">
                        Publish Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
