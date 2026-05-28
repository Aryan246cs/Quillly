@extends('layouts.app')

@section('title', auth()->check() ? 'Dashboard — Quillly' : 'Login — Quillly')

@section('content')

@auth
<div class="max-w-4xl mx-auto px-4 py-10">

    <div class="relative overflow-hidden glass rounded-3xl p-8 mb-8 fade-in">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <div class="relative flex-shrink-0">
                @if(Auth::user()->profile_image)
                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" class="w-24 h-24 rounded-2xl object-cover ring-4 ring-indigo-500/30">
                @else
                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-3xl font-bold text-white ring-4 ring-indigo-500/30">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full border-2 border-gray-950"></div>
            </div>
            <div class="flex-1 text-center sm:text-left">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-medium mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Active
                </div>
                <h1 class="text-2xl font-bold text-white mb-1">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-400 text-sm">{{ Auth::user()->email }}</p>
            </div>
            <div class="flex flex-wrap gap-2 flex-shrink-0">
                <a href="{{ route('create-post') }}" class="btn-primary px-4 py-2 rounded-xl text-white text-sm font-medium">Write Post</a>
                <a href="{{ route('dashboard.edit') }}" class="px-4 py-2 rounded-xl glass text-gray-300 hover:text-white text-sm font-medium transition-all">Edit Profile</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        @php
            $totalPosts = auth()->user()->usersCoolPosts()->count();
            $publicPosts = auth()->user()->usersCoolPosts()->where('visibility','public')->count();
            $totalLikes = auth()->user()->usersCoolPosts()->withCount('likes')->get()->sum('likes_count');
            $totalComments = auth()->user()->usersCoolPosts()->withCount('comments')->get()->sum('comments_count');
        @endphp
        <div class="glass rounded-2xl p-5 bg-gradient-to-br from-indigo-500/20 to-indigo-600/10">
            <p class="text-xs text-gray-500 mb-2">Total Posts</p>
            <p class="text-2xl font-bold text-indigo-400">{{ $totalPosts }}</p>
        </div>
        <div class="glass rounded-2xl p-5 bg-gradient-to-br from-emerald-500/20 to-emerald-600/10">
            <p class="text-xs text-gray-500 mb-2">Public</p>
            <p class="text-2xl font-bold text-emerald-400">{{ $publicPosts }}</p>
        </div>
        <div class="glass rounded-2xl p-5 bg-gradient-to-br from-pink-500/20 to-pink-600/10">
            <p class="text-xs text-gray-500 mb-2">Likes</p>
            <p class="text-2xl font-bold text-pink-400">{{ $totalLikes }}</p>
        </div>
        <div class="glass rounded-2xl p-5 bg-gradient-to-br from-purple-500/20 to-purple-600/10">
            <p class="text-xs text-gray-500 mb-2">Comments</p>
            <p class="text-2xl font-bold text-purple-400">{{ $totalComments }}</p>
        </div>
    </div>

    <div class="glass rounded-2xl overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
            <h2 class="font-semibold text-gray-200">Profile Details</h2>
            <a href="{{ route('dashboard.edit') }}" class="text-xs text-indigo-400 hover:text-indigo-300 transition-colors">Edit</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2">
            <div class="px-6 py-4 border-b border-white/5 sm:border-r border-white/5">
                <p class="text-xs text-gray-500 mb-1">Name</p>
                <p class="text-sm font-medium text-gray-200">{{ Auth::user()->name }}</p>
            </div>
            <div class="px-6 py-4 border-b border-white/5">
                <p class="text-xs text-gray-500 mb-1">Email</p>
                <p class="text-sm font-medium text-gray-200">{{ Auth::user()->email }}</p>
            </div>
            <div class="px-6 py-4 border-b border-white/5 sm:border-r border-white/5">
                <p class="text-xs text-gray-500 mb-1">Gender</p>
                <p class="text-sm font-medium text-gray-200">{{ ucfirst(Auth::user()->gender ?? 'N/A') }}</p>
            </div>
            <div class="px-6 py-4 border-b border-white/5">
                <p class="text-xs text-gray-500 mb-1">Date of Birth</p>
                <p class="text-sm font-medium text-gray-200">{{ Auth::user()->dob ? \Carbon\Carbon::parse(Auth::user()->dob)->format('M j, Y') : 'N/A' }}</p>
            </div>
            <div class="px-6 py-4 sm:border-r border-white/5">
                <p class="text-xs text-gray-500 mb-1">State</p>
                <p class="text-sm font-medium text-gray-200">{{ Auth::user()->state ?? 'N/A' }}</p>
            </div>
            <div class="px-6 py-4">
                <p class="text-xs text-gray-500 mb-1">District</p>
                <p class="text-sm font-medium text-gray-200">{{ Auth::user()->district ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="glass rounded-2xl p-6 mb-8">
        <h2 class="font-semibold text-gray-200 mb-4">Profile Image</h2>
        <div class="flex flex-col sm:flex-row items-start gap-6">
            @if(Auth::user()->profile_image)
                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" class="w-20 h-20 rounded-xl object-cover ring-2 ring-indigo-500/30">
            @else
                <div class="w-20 h-20 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-2xl font-bold text-white">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            <div class="flex-1 space-y-3">
                <form action="{{ route('profile.image.update') }}" method="POST" enctype="multipart/form-data" class="flex gap-2 flex-wrap items-center">
                    @csrf
                    @method('PUT')
                    <input type="file" name="profile_image" accept="image/*" required
                           class="text-sm text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-indigo-500/10 file:text-indigo-400 hover:file:bg-indigo-500/20 file:transition-all cursor-pointer">
                    <button type="submit" class="btn-primary px-4 py-2 rounded-lg text-white text-xs font-medium">Upload</button>
                </form>
                @if(Auth::user()->profile_image)
                    <form action="{{ route('profile.image.delete') }}" method="POST" onsubmit="return confirm('Remove profile image?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-400 hover:text-red-300 transition-colors">Remove image</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="glass rounded-2xl p-6 border border-red-500/10">
        <h2 class="font-semibold text-red-400 mb-2">Danger Zone</h2>
        <p class="text-sm text-gray-500 mb-4">Permanently delete your account and all associated data. This cannot be undone.</p>
        <form action="{{ route('dashboard.delete') }}" method="POST" onsubmit="return confirm('Are you absolutely sure? This will permanently delete your account.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-400 hover:text-red-300 border border-red-500/20 text-sm font-medium transition-all">
                Delete Account
            </button>
        </form>
    </div>
</div>

@else
<div class="min-h-screen flex items-center justify-center px-4 py-16 relative">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-950/30 via-gray-950 to-purple-950/20 pointer-events-none"></div>
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative w-full max-w-md" x-data="{ tab: 'login' }">
        <div class="flex glass rounded-2xl p-1 mb-6">
            <button @click="tab = 'login'" :class="tab === 'login' ? 'bg-indigo-600 text-white shadow-lg' : 'text-gray-400 hover:text-white'"
                    class="flex-1 py-2.5 text-sm font-medium rounded-xl transition-all">Sign In</button>
            <button @click="tab = 'register'" :class="tab === 'register' ? 'bg-indigo-600 text-white shadow-lg' : 'text-gray-400 hover:text-white'"
                    class="flex-1 py-2.5 text-sm font-medium rounded-xl transition-all">Create Account</button>
        </div>

        <div x-show="tab === 'login'" x-transition>
            <div class="glass rounded-2xl p-8">
                <div class="text-center mb-6">
                    <h2 class="text-xl font-bold text-white">Welcome back</h2>
                    <p class="text-sm text-gray-500 mt-1">Sign in to your account</p>
                </div>
                @if($errors->has('loginname'))
                    <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">{{ $errors->first('loginname') }}</div>
                @endif
                <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5">Username</label>
                        <input name="loginname" type="text" placeholder="Enter your username" value="{{ old('loginname') }}"
                               class="w-full bg-gray-900/80 border border-white/10 text-gray-100 placeholder-gray-600 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5">Password</label>
                        <input name="loginpassword" type="password" placeholder="Enter your password"
                               class="w-full bg-gray-900/80 border border-white/10 text-gray-100 placeholder-gray-600 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                    </div>
                    <button type="submit" class="w-full btn-primary py-3 rounded-xl text-white font-semibold text-sm">Sign In</button>
                </form>
                <p class="text-center text-sm text-gray-500 mt-4">
                    No account? <button @click="tab = 'register'" class="text-indigo-400 hover:text-indigo-300 font-medium">Create one</button>
                </p>
            </div>
        </div>

        <div x-show="tab === 'register'" x-transition id="register">
            <div class="glass rounded-2xl p-8">
                <div class="text-center mb-6">
                    <h2 class="text-xl font-bold text-white">Create account</h2>
                    <p class="text-sm text-gray-500 mt-1">Join Quillly today</p>
                </div>
                <form action="/register" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1.5">Username</label>
                            <input name="name" type="text" placeholder="Username" value="{{ old('name') }}"
                                   class="w-full bg-gray-900/80 border border-white/10 text-gray-100 placeholder-gray-600 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1.5">Email</label>
                            <input name="email" type="email" placeholder="Email" value="{{ old('email') }}"
                                   class="w-full bg-gray-900/80 border border-white/10 text-gray-100 placeholder-gray-600 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5">Password</label>
                        <input name="password" type="password" placeholder="Create a password"
                               class="w-full bg-gray-900/80 border border-white/10 text-gray-100 placeholder-gray-600 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-2">Gender</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="gender" value="male" class="accent-indigo-500"><span class="text-sm text-gray-400">Male</span></label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="gender" value="female" class="accent-indigo-500"><span class="text-sm text-gray-400">Female</span></label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="gender" value="other" class="accent-indigo-500"><span class="text-sm text-gray-400">Other</span></label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5">Date of Birth</label>
                        <input type="date" name="dob" value="{{ old('dob') }}"
                               class="w-full bg-gray-900/80 border border-white/10 text-gray-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1.5">State</label>
                            <select id="state" name="state" class="w-full bg-gray-900/80 border border-white/10 text-gray-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                                <option value="">Select State</option>
                                @foreach (json_decode(file_get_contents(public_path('states_districts.json')), true) as $state => $districts)
                                    <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1.5">District</label>
                            <select id="district" name="district" class="w-full bg-gray-900/80 border border-white/10 text-gray-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                                <option value="">Select District</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5">Profile Image <span class="text-gray-600">(optional)</span></label>
                        <input type="file" name="profile_image" accept="image/*"
                               class="w-full text-sm text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-indigo-500/10 file:text-indigo-400 hover:file:bg-indigo-500/20 file:transition-all cursor-pointer">
                    </div>
                    <button type="submit" class="w-full btn-primary py-3 rounded-xl text-white font-semibold text-sm">Create Account</button>
                </form>
                <p class="text-center text-sm text-gray-500 mt-4">
                    Have an account? <button @click="tab = 'login'" class="text-indigo-400 hover:text-indigo-300 font-medium">Sign in</button>
                </p>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="{{ url('/explore-posts') }}" class="text-sm text-gray-500 hover:text-gray-300 transition-colors">Browse posts without an account</a>
        </div>
    </div>
</div>

<script>
document.getElementById('state').addEventListener('change', function () {
    const state = this.value;
    const districtSelect = document.getElementById('district');
    districtSelect.innerHTML = '<option value="">Loading...</option>';
    fetch(`/districts/${encodeURIComponent(state)}`)
        .then(res => res.json())
        .then(data => {
            districtSelect.innerHTML = '<option value="">Select District</option>';
            data.forEach(d => {
                const opt = document.createElement('option');
                opt.value = d; opt.textContent = d;
                districtSelect.appendChild(opt);
            });
        });
});
</script>
@endauth

@endsection
