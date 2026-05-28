@extends('layouts.app')

@section('title', 'My Report — Quillly')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">Blog Report</h1>
            <p class="text-sm text-gray-500 mt-1">Performance overview of your posts</p>
        </div>
        <a href="{{ route('your-posts') }}" class="px-4 py-2 rounded-xl glass text-gray-300 hover:text-white text-sm font-medium transition-all">
            View Posts
        </a>
    </div>

    @if($posts->count() > 0)
        <!-- Summary Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            @php
                $totalLikes = $posts->sum(fn($p) => $p->likes->count());
                $totalComments = $posts->sum(fn($p) => $p->comments->count());
                $topPost = $posts->sortByDesc(fn($p) => $p->likes->count())->first();
            @endphp
            <div class="glass rounded-2xl p-5 bg-gradient-to-br from-indigo-500/20 to-indigo-600/10">
                <p class="text-xs text-gray-500 mb-2">Total Posts</p>
                <p class="text-2xl font-bold text-indigo-400">{{ $posts->count() }}</p>
            </div>
            <div class="glass rounded-2xl p-5 bg-gradient-to-br from-pink-500/20 to-pink-600/10">
                <p class="text-xs text-gray-500 mb-2">Total Likes</p>
                <p class="text-2xl font-bold text-pink-400">{{ $totalLikes }}</p>
            </div>
            <div class="glass rounded-2xl p-5 bg-gradient-to-br from-purple-500/20 to-purple-600/10">
                <p class="text-xs text-gray-500 mb-2">Total Comments</p>
                <p class="text-2xl font-bold text-purple-400">{{ $totalComments }}</p>
            </div>
            <div class="glass rounded-2xl p-5 bg-gradient-to-br from-amber-500/20 to-amber-600/10">
                <p class="text-xs text-gray-500 mb-2">Avg Likes/Post</p>
                <p class="text-2xl font-bold text-amber-400">{{ $posts->count() > 0 ? round($totalLikes / $posts->count(), 1) : 0 }}</p>
            </div>
        </div>

        <!-- Posts Table -->
        <div class="glass rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-white/5">
                <h2 class="font-semibold text-gray-200">Post Performance</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/5">
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Post Title</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Visibility</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Likes</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Comments</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($posts as $post)
                            <tr class="hover:bg-white/2 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500/20 to-purple-500/20 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-200 truncate max-w-xs">{{ $post->title }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                        {{ $post->visibility === 'public' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-gray-500/10 text-gray-400 border border-gray-500/20' }}">
                                        {{ ucfirst($post->visibility) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-pink-400" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                        <span class="text-sm font-semibold text-gray-200">{{ $post->likes->count() }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                        <span class="text-sm font-semibold text-gray-200">{{ $post->comments->count() }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $post->created_at->format('M j, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-20">
            <div class="w-16 h-16 rounded-2xl glass flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-400 mb-2">No data yet</h3>
            <p class="text-sm text-gray-600 mb-6">Create some posts to see your report here.</p>
            <a href="{{ route('create-post') }}" class="btn-primary px-5 py-2.5 rounded-xl text-white text-sm font-medium inline-block">Write a Post</a>
        </div>
    @endif
</div>
@endsection
