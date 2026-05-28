@extends('layouts.app')

@section('title', 'Analytics — Quillly')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    <div class="mb-8">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-medium mb-3">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 pulse-glow"></span>
            Live Data
        </div>
        <h1 class="text-2xl font-bold text-white mb-1">Website Analytics</h1>
        <p class="text-sm text-gray-500">Platform-wide user engagement overview</p>
    </div>

    @php
        $totalUsers = $users->count();
        $totalPosts = $users->sum('users_cool_posts_count');
        $totalLikes = $users->sum(fn($u) => $u->usersCoolPosts->sum(fn($p) => $p->likes_count));
        $activeUsers = $users->filter(fn($u) => $u->users_cool_posts_count > 0)->count();
    @endphp

    <!-- Platform Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="glass rounded-2xl p-5 bg-gradient-to-br from-indigo-500/20 to-indigo-600/10">
            <p class="text-xs text-gray-500 mb-2">Total Users</p>
            <p class="text-2xl font-bold text-indigo-400">{{ $totalUsers }}</p>
        </div>
        <div class="glass rounded-2xl p-5 bg-gradient-to-br from-emerald-500/20 to-emerald-600/10">
            <p class="text-xs text-gray-500 mb-2">Active Writers</p>
            <p class="text-2xl font-bold text-emerald-400">{{ $activeUsers }}</p>
        </div>
        <div class="glass rounded-2xl p-5 bg-gradient-to-br from-purple-500/20 to-purple-600/10">
            <p class="text-xs text-gray-500 mb-2">Total Posts</p>
            <p class="text-2xl font-bold text-purple-400">{{ $totalPosts }}</p>
        </div>
        <div class="glass rounded-2xl p-5 bg-gradient-to-br from-pink-500/20 to-pink-600/10">
            <p class="text-xs text-gray-500 mb-2">Total Likes</p>
            <p class="text-2xl font-bold text-pink-400">{{ $totalLikes }}</p>
        </div>
    </div>

    <!-- Users Table -->
    <div class="glass rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
            <h2 class="font-semibold text-gray-200">User Breakdown</h2>
            <span class="text-xs text-gray-500">{{ $totalUsers }} users</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Posts</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Likes</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Engagement</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($users as $user)
                        @php
                            $userLikes = $user->usersCoolPosts->sum(fn($post) => $post->likes_count);
                            $engagement = $user->users_cool_posts_count > 0 ? round($userLikes / $user->users_cool_posts_count, 1) : 0;
                        @endphp
                        <tr class="hover:bg-white/2 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-200">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-600">ID #{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-semibold {{ $user->users_cool_posts_count > 0 ? 'text-gray-200' : 'text-gray-600' }}">
                                    {{ $user->users_cool_posts_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-pink-400" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    <span class="text-sm font-semibold text-gray-200">{{ $userLikes }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 bg-gray-800 rounded-full h-1.5 max-w-24">
                                        @php $maxLikes = $users->max(fn($u) => $u->usersCoolPosts->sum(fn($p) => $p->likes_count)); @endphp
                                        <div class="h-1.5 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500"
                                             style="width: {{ $maxLikes > 0 ? min(100, ($userLikes / $maxLikes) * 100) : 0 }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $engagement }} avg</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($users->isEmpty())
            <div class="text-center py-12 text-gray-600 text-sm">No users found.</div>
        @endif
    </div>
</div>
@endsection
