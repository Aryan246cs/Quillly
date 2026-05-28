<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quillly')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255,255,255,0.04); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.08); }
        .gradient-text { background: linear-gradient(135deg, #6366f1, #8b5cf6, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .btn-primary { background: linear-gradient(135deg, #6366f1, #8b5cf6); transition: all 0.2s; }
        .btn-primary:hover { background: linear-gradient(135deg, #4f46e5, #7c3aed); transform: translateY(-1px); box-shadow: 0 8px 25px rgba(99,102,241,0.35); }
        .card-hover { transition: all 0.25s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 0; height: 2px; background: linear-gradient(90deg, #6366f1, #8b5cf6); transition: width 0.2s; }
        .nav-link:hover::after { width: 100%; }
        nav[role="navigation"] { display: flex; justify-content: center; margin-top: 1.5rem; }
        .hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between { justify-content: center; gap: 1rem; flex-wrap: wrap; }
        .text-sm.text-gray-700.leading-5 { display: none; }
        span[aria-current="page"] > span { background: linear-gradient(135deg, #6366f1, #8b5cf6) !important; color: white !important; border-color: transparent !important; }
        nav[role="navigation"] a { color: #a78bfa !important; border-color: rgba(99,102,241,0.3) !important; }
        nav[role="navigation"] a:hover { background: rgba(99,102,241,0.15) !important; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in { animation: fadeInUp 0.5s ease forwards; }
        @keyframes pulse-glow { 0%, 100% { box-shadow: 0 0 0 0 rgba(99,102,241,0.4); } 50% { box-shadow: 0 0 0 8px rgba(99,102,241,0); } }
        .pulse-glow { animation: pulse-glow 2s infinite; }
    </style>
    @yield('head')
</head>
<body class="bg-gray-950 text-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 glass border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 rounded-lg btn-primary flex items-center justify-center text-white font-bold text-sm">Q</div>
                    <span class="text-xl font-bold gradient-text">Quillly</span>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ url('/') }}" class="nav-link px-3 py-2 text-sm text-gray-300 hover:text-white rounded-lg hover:bg-white/5 transition-all">Explore</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="nav-link px-3 py-2 text-sm text-gray-300 hover:text-white rounded-lg hover:bg-white/5 transition-all">Dashboard</a>
                        <a href="{{ route('create-post') }}" class="nav-link px-3 py-2 text-sm text-gray-300 hover:text-white rounded-lg hover:bg-white/5 transition-all">Write</a>
                        <a href="{{ route('your-posts') }}" class="nav-link px-3 py-2 text-sm text-gray-300 hover:text-white rounded-lg hover:bg-white/5 transition-all">My Posts</a>
                        <a href="{{ route('report') }}" class="nav-link px-3 py-2 text-sm text-gray-300 hover:text-white rounded-lg hover:bg-white/5 transition-all">Report</a>
                    @endauth
                    <a href="{{ route('web-analytics') }}" class="nav-link px-3 py-2 text-sm text-gray-300 hover:text-white rounded-lg hover:bg-white/5 transition-all">Analytics</a>
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-3">
                    @auth
                        <div class="flex items-center gap-3">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                                @if(Auth::user()->profile_image)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-indigo-500/50 group-hover:ring-indigo-400 transition-all">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-xs font-bold text-white ring-2 ring-indigo-500/50">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="hidden sm:block text-sm text-gray-300 group-hover:text-white transition-colors">{{ Auth::user()->name }}</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 text-xs text-gray-400 hover:text-red-400 border border-white/10 hover:border-red-500/30 rounded-lg transition-all">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm text-gray-300 hover:text-white border border-white/10 hover:border-indigo-500/50 rounded-lg transition-all">Login</a>
                        <a href="{{ route('login') }}#register" class="px-4 py-2 text-sm text-white btn-primary rounded-lg font-medium">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             class="fixed top-20 right-4 z-50 flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-xl shadow-xl backdrop-blur-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="text-sm">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-20 right-4 z-50 bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl shadow-xl backdrop-blur-sm max-w-sm">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <ul class="text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @yield('content')

    <!-- Footer -->
    <footer class="border-t border-white/5 mt-20">
        <div class="max-w-7xl mx-auto px-4 py-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg btn-primary flex items-center justify-center text-white font-bold text-xs">Q</div>
                    <span class="font-bold gradient-text">Quillly</span>
                </div>
                <p class="text-sm text-gray-500 text-center">
                    © {{ date('Y') }} Quillly — Built with Laravel, PHP & Tailwind CSS
                    <span class="mx-2 text-gray-700">·</span>
                    by Aryan Srivastava
                </p>
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <a href="{{ url('/') }}" class="hover:text-gray-300 transition-colors">Explore</a>
                    <a href="{{ route('web-analytics') }}" class="hover:text-gray-300 transition-colors">Analytics</a>
                    @guest
                        <a href="{{ route('login') }}" class="hover:text-gray-300 transition-colors">Login</a>
                    @endguest
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
