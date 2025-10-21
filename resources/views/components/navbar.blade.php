<!-- Navbar Top -->
<nav
    class="fixed top-0 left-0 right-0 h-16 bg-gradient-to-r from-blue-700 to-blue-900 text-white shadow-lg z-50 flex items-center justify-between px-6">
    <!-- Logo -->
    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
        <img src="{{ asset('images/logohimatika.png') }}" alt="Logo Himatika" class="h-10 w-10 object-contain">
        <span class="text-xl font-bold">ETS Web</span>
    </a>

    <!-- User Profile -->
    <div class="flex items-center space-x-3">
        <div class="w-10 h-10 bg-cyan-400 bg-opacity-30 rounded-full flex items-center justify-center">
            <i data-feather="user" class="w-5 h-5 text-cyan-300"></i>
        </div>
        <div>
            <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
            @if (Auth::user()->nrp)
                <p class="text-xs text-cyan-200">{{ Auth::user()->nrp }}</p>
            @endif
        </div>
        <span class="px-2 py-1 text-xs bg-cyan-400 bg-opacity-30 rounded-full text-cyan-100">
            {{ ucfirst(Auth::user()->role) }}
        </span>
    </div>
</nav>
