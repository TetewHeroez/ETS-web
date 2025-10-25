<!-- Navbar Top -->
<nav
    class="fixed top-0 left-0 right-0 h-16 bg-gradient-to-r from-blue-700 via-blue-800 to-blue-900 dark:from-slate-800 dark:via-slate-900 dark:to-black text-white shadow-lg z-50 flex items-center justify-between px-4 md:px-6 overflow-hidden">
    <!-- Geometric Background Elements (Sinkron dengan Sidebar) -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-10">
        <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 1200 64">
            <!-- Geometric lines (horizontal wave pattern) -->
            <path d="M0,32 Q200,16 400,32 T800,32 T1200,32" stroke="currentColor" stroke-width="1" fill="none" />
            <path d="M0,48 Q150,32 300,48 T600,48 T900,48 T1200,48" stroke="currentColor" stroke-width="1"
                fill="none" />

            <!-- Left side geometric shapes -->
            <circle cx="80" cy="32" r="8" fill="none" stroke="currentColor" stroke-width="1" />
            <polygon points="150,16 170,32 150,48" fill="none" stroke="currentColor" stroke-width="1" />

            <!-- Right side geometric shapes -->
            <circle cx="1120" cy="32" r="12" fill="currentColor" opacity="0.3" />
            <polygon points="1050,20 1080,32 1050,44" fill="currentColor" opacity="0.2" />

            <!-- Center decorative elements -->
            <circle cx="600" cy="20" r="4" fill="currentColor" opacity="0.4" />
            <circle cx="620" cy="44" r="6" fill="none" stroke="currentColor" stroke-width="1" />
        </svg>
    </div>

    <!-- Logo -->
    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 relative z-10">
        <div class="relative">
            <div class="absolute inset-0 bg-cyan-400 rounded-lg blur-sm opacity-30"></div>
            <img src="{{ asset('images/logohimatika.png') }}" alt="Logo Himatika"
                class="relative h-10 w-10 object-contain">
        </div>
        <span
            class="text-xl font-heading font-bold bg-gradient-to-r from-white to-cyan-200 bg-clip-text text-transparent">MyHIMATIKA</span>
    </a>

    <!-- Actions & User Profile -->
    <div class="flex items-center space-x-3 relative z-10">
        <!-- Mobile menu toggle -->
        <button id="mobileSidebarToggle"
            class="md:hidden p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200">
            <i data-feather="menu" class="w-5 h-5"></i>
        </button>

        <!-- User Profile -->
        <a href="{{ route('profile.show') }}" class="flex items-center space-x-3 hover:opacity-90 transition-opacity">
            <div class="relative group">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-full blur-sm opacity-50 group-hover:opacity-70 transition-opacity">
                </div>
                @if (Auth::user()->profile_photo &&
                        (str_starts_with(Auth::user()->profile_photo, 'http://') ||
                            str_starts_with(Auth::user()->profile_photo, 'https://')))
                    {{-- Cloudinary URL --}}
                    <img src="{{ Auth::user()->profile_photo }}" alt="{{ Auth::user()->name }}"
                        class="relative w-10 h-10 rounded-full object-cover border-2 border-white/50"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div
                        class="relative w-10 h-10 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-full hidden items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @else
                    {{-- Fallback avatar --}}
                    <div
                        class="relative w-10 h-10 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="hidden sm:block">
                <!-- Baris 1: Nama -->
                <p class="text-sm font-heading font-semibold leading-tight">{{ Auth::user()->name }}</p>
                <!-- Baris 2: NRP | Jabatan -->
                <div class="flex items-center gap-2 mt-0.5">
                    @if (Auth::user()->nrp)
                        <p class="text-xs text-cyan-200 font-mono">{{ Auth::user()->nrp }}</p>
                    @endif
                    <span
                        class="text-xs font-medium bg-gradient-to-r from-cyan-400/30 to-blue-400/30 px-2 py-0.5 rounded text-cyan-100 border border-cyan-400/20 backdrop-blur-sm">
                        {{ Auth::user()->jabatan_label }}
                    </span>
                </div>
            </div>
        </a>

        <!-- Dark Mode Toggle -->
        <button onclick="toggleTheme()"
            class="p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 group"
            title="Toggle Dark Mode">
            <i data-feather="sun" class="w-5 h-5 dark:hidden group-hover:rotate-12 transition-transform"></i>
            <i data-feather="moon" class="w-5 h-5 hidden dark:block group-hover:-rotate-12 transition-transform"></i>
        </button>
    </div>
</nav>
