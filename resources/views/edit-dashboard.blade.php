@extends('layouts.app')

@section('title', 'Edit Profile — Quillly')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-16 relative">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-950/20 via-gray-950 to-purple-950/20 pointer-events-none"></div>

    <div class="relative w-full max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-300 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to Dashboard
            </a>
        </div>

        <div class="glass rounded-3xl p-8">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-white mb-1">Edit Profile</h1>
                <p class="text-sm text-gray-500">Update your personal information.</p>
            </div>

            <form action="{{ route('dashboard.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="w-full bg-gray-900/80 border border-white/10 text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="w-full bg-gray-900/80 border border-white/10 text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Gender</label>
                    <div class="flex gap-4">
                        @foreach(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $val => $label)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="gender" value="{{ $val }}" {{ $user->gender == $val ? 'checked' : '' }} class="accent-indigo-500 w-4 h-4">
                                <span class="text-sm text-gray-300">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob', $user->dob) }}"
                           class="w-full bg-gray-900/80 border border-white/10 text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">State</label>
                        <input type="text" name="state" value="{{ old('state', $user->state) }}"
                               class="w-full bg-gray-900/80 border border-white/10 text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">District</label>
                        <input type="text" name="district" value="{{ old('district', $user->district) }}"
                               class="w-full bg-gray-900/80 border border-white/10 text-gray-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Profile Image</label>
                    <input type="file" name="profile_image" accept="image/jpg,image/jpeg,image/png"
                           class="w-full text-sm text-gray-400 bg-gray-900/80 border border-white/10 rounded-xl px-4 py-3 file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-indigo-500/10 file:text-indigo-400 hover:file:bg-indigo-500/20 file:transition-all cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                    <p class="text-xs text-gray-600 mt-1.5">JPG, JPEG or PNG. Max 2MB.</p>
                </div>

                @if($errors->any())
                    <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20">
                        <ul class="text-sm text-red-400 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl glass text-gray-400 hover:text-white text-sm font-medium transition-all">
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
