@extends('layouts.app')

@section('title', 'Edit Post — Quillly')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-16 relative">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-950/20 via-gray-950 to-purple-950/20 pointer-events-none"></div>

    <div class="relative w-full max-w-2xl">
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-300 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back
            </a>
        </div>

        <div class="glass rounded-3xl p-8">
            <div class="mb-8">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-medium mb-3">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editing post
                </div>
                <h1 class="text-2xl font-bold text-white mb-1">Edit your post</h1>
                <p class="text-sm text-gray-500">Make changes to your post below.</p>
            </div>

            <form action="/edit-post/{{ $post->id }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Post Title</label>
                    <input type="text" name="title" value="{{ $post->title }}"
                           class="w-full bg-gray-900/80 border border-white/10 text-gray-100 placeholder-gray-600 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Content</label>
                    <textarea name="body" rows="10"
                              class="w-full bg-gray-900/80 border border-white/10 text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all resize-none leading-relaxed">{{ $post->body }}</textarea>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ url()->previous() }}" class="px-5 py-2.5 rounded-xl glass text-gray-400 hover:text-white text-sm font-medium transition-all">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary px-6 py-2.5 rounded-xl text-white font-semibold text-sm">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
