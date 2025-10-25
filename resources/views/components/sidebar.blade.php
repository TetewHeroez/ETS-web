<!-- Sidebar -->
<aside id="sidebar"
    class="fixed left-0 top-16 h-[calc(100vh-4rem)] w-64 bg-gradient-to-b from-blue-700 via-blue-800 to-blue-900 dark:from-slate-800 dark:via-slate-900 dark:to-black text-white shadow-2xl flex flex-col z-40 transition-all duration-300 transform md:translate-x-0 -translate-x-full">

    <!-- Geometric Background Pattern -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-10">
        <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 256 800">
            <!-- Geometric lines -->
            <path d="M0,100 L50,50 L100,100 L150,50 L200,100 L256,50" stroke="currentColor" stroke-width="1"
                fill="none" />
            <path d="M0,200 L50,150 L100,200 L150,150 L200,200 L256,150" stroke="currentColor" stroke-width="1"
                fill="none" />
            <path d="M0,300 L50,250 L100,300 L150,250 L200,300 L256,250" stroke="currentColor" stroke-width="1"
                fill="none" />

            <!-- Circles -->
            <circle cx="50" cy="400" r="15" fill="none" stroke="currentColor" stroke-width="1" />
            <circle cx="150" cy="450" r="20" fill="none" stroke="currentColor" stroke-width="1" />
            <circle cx="200" cy="500" r="10" fill="currentColor" opacity="0.3" />

            <!-- Triangles -->
            <polygon points="20,600 50,550 80,600" fill="none" stroke="currentColor" stroke-width="1" />
            <polygon points="170,650 200,600 230,650" fill="currentColor" opacity="0.2" />
        </svg>
    </div>

    <!-- Toggle Button (desktop) -->
    <button onclick="toggleSidebar()" id="desktopToggle"
        class="hidden md:flex md:absolute md:-right-3 md:top-4 md:w-6 md:h-6 bg-gradient-to-r from-cyan-400 to-blue-400 text-blue-900 rounded-full shadow-lg md:items-center md:justify-center hover:from-cyan-300 hover:to-blue-300 transition-all duration-200 z-50 group">
        <i data-feather="chevron-left" id="toggleIcon" class="w-4 h-4 group-hover:scale-110 transition-transform"></i>
    </button>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto relative z-10">
        <a href="{{ route('dashboard') }}"
            class="group flex items-center justify-center px-4 py-3 rounded-xl transition-all duration-200 relative overflow-hidden {{ request()->routeIs('dashboard') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}"
            title="Dashboard">
            <div
                class="absolute inset-0 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            </div>
            <i data-feather="home"
                class="w-5 h-5 flex-shrink-0 relative z-10 group-hover:scale-110 transition-transform sidebar-icon"></i>
            <span class="font-medium sidebar-text relative z-10 ml-3">Dashboard</span>
        </a>

        @if (Auth::user()->isMember())
            <a href="{{ route('submissions.index') }}"
                class="group flex items-center justify-center px-4 py-3 rounded-xl transition-all duration-200 relative overflow-hidden {{ request()->routeIs('submissions.index') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}"
                title="Kumpulkan Tugas">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                </div>
                <i data-feather="upload"
                    class="w-5 h-5 flex-shrink-0 relative z-10 group-hover:scale-110 transition-transform sidebar-icon"></i>
                <span class="font-medium sidebar-text relative z-10 ml-3">Kumpulkan Tugas</span>
            </a>
        @endif

        @if (Auth::user()->isAdmin() || Auth::user()->isSuperadmin())
            <a href="{{ route('assignments.index') }}"
                class="group flex items-center justify-center px-4 py-3 rounded-xl transition-all duration-200 relative overflow-hidden {{ request()->routeIs('assignments.*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}"
                title="Kelola Tugas">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                </div>
                <i data-feather="file-text"
                    class="w-5 h-5 flex-shrink-0 relative z-10 group-hover:scale-110 transition-transform sidebar-icon"></i>
                <span class="font-medium sidebar-text relative z-10 ml-3">Kelola Tugas</span>
            </a>
        @endif

        <a href="{{ route('submissions.table') }}"
            class="group flex items-center justify-center px-4 py-3 rounded-xl transition-all duration-200 relative overflow-hidden {{ request()->routeIs('submissions.table') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}"
            title="Progress PPH">
            <div
                class="absolute inset-0 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            </div>
            <i data-feather="bar-chart-2"
                class="w-5 h-5 flex-shrink-0 relative z-10 group-hover:scale-110 transition-transform sidebar-icon"></i>
            <span class="font-medium sidebar-text relative z-10 ml-3">Progress</span>
        </a>

        @if (Auth::user()->isAdmin() || Auth::user()->isSuperadmin())
            <a href="{{ route('attendances.index') }}"
                class="group flex items-center justify-center px-4 py-3 rounded-xl transition-all duration-200 relative overflow-hidden {{ request()->routeIs('attendances.index') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}"
                title="Kelola Absensi">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                </div>
                <i data-feather="user-check"
                    class="w-5 h-5 flex-shrink-0 relative z-10 group-hover:scale-110 transition-transform sidebar-icon"></i>
                <span class="font-medium sidebar-text relative z-10 ml-3">Kelola Absensi</span>
            </a>

            <a href="{{ route('users.index') }}"
                class="group flex items-center justify-center px-4 py-3 rounded-xl transition-all duration-200 relative overflow-hidden {{ request()->routeIs('users.*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}"
                title="Kelola PPH">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                </div>
                <i data-feather="users"
                    class="w-5 h-5 flex-shrink-0 relative z-10 group-hover:scale-110 transition-transform sidebar-icon"></i>
                <span class="font-medium sidebar-text relative z-10 ml-3">Kelola Member</span>
            </a>

            <a href="{{ route('kpi.index') }}"
                class="group flex items-center justify-center px-4 py-3 rounded-xl transition-all duration-200 relative overflow-hidden {{ request()->routeIs('kpi.*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}"
                title="KPI & PA">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                </div>
                <i data-feather="trending-up"
                    class="w-5 h-5 flex-shrink-0 relative z-10 group-hover:scale-110 transition-transform sidebar-icon"></i>
                <span class="font-medium sidebar-text relative z-10 ml-3">KPI & PI</span>
            </a>
        @endif

        @if (in_array(Auth::user()->jabatan, ['Koor SC', 'Koor IC', 'SC']))
            <a href="{{ route('contracts.index') }}"
                class="group flex items-center justify-center px-4 py-3 rounded-xl transition-all duration-200 relative overflow-hidden {{ request()->routeIs('contracts.*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}"
                title="Kelola Kontrak">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                </div>
                <i data-feather="edit-3"
                    class="w-5 h-5 flex-shrink-0 relative z-10 group-hover:scale-110 transition-transform sidebar-icon"></i>
                <span class="font-medium sidebar-text relative z-10 ml-3">Kontrak</span>
            </a>

            <a href="{{ route('gdk.index') }}"
                class="group flex items-center justify-center px-4 py-3 rounded-xl transition-all duration-200 relative overflow-hidden {{ request()->routeIs('gdk.*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}"
                title="GDK">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                </div>
                <i data-feather="layers"
                    class="w-5 h-5 flex-shrink-0 relative z-10 group-hover:scale-110 transition-transform sidebar-icon"></i>
                <span class="font-medium sidebar-text relative z-10 ml-3">GDK</span>
            </a>
        @endif

        @if (Auth::user()->isMember())
            <a href="{{ route('my-attendance') }}"
                class="group flex items-center justify-center px-4 py-3 rounded-xl transition-all duration-200 relative overflow-hidden {{ request()->routeIs('my-attendance') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}"
                title="Kehadiran Saya">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                </div>
                <i data-feather="calendar"
                    class="w-5 h-5 flex-shrink-0 relative z-10 group-hover:scale-110 transition-transform sidebar-icon"></i>
                <span class="font-medium sidebar-text relative z-10 ml-3">Kehadiran Saya</span>
            </a>
        @endif
    </nav>

    <!-- Profile & Logout Section -->
    <div class="p-4 border-t border-white border-opacity-20 space-y-2">
        <!-- Profil (All users) -->
        <a href="{{ route('profile.show') }}"
            class="flex items-center justify-center space-x-2 px-4 py-3 rounded-lg transition {{ request()->routeIs('profile.*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}"
            title="Profil Saya">
            <i data-feather="user-check" class="w-5 h-5 flex-shrink-0 from-cyan-400/20 to-blue-400/20"></i>
            <span class="font-medium sidebar-text">Profil</span>
        </a>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center space-x-2 px-4 py-3 bg-red-500/80 hover:bg-red-600/90 dark:bg-red-600/80 dark:hover:bg-red-700/90 text-white rounded-lg transition shadow-md hover:shadow-lg"
                title="Logout">
                <i data-feather="log-out" class="w-5 h-5 flex-shrink-0"></i>
                <span class="font-medium sidebar-text">Logout</span>
            </button>
        </form>
    </div>
</aside>

<script>
    // Sidebar behavior: mobile overlay + desktop collapse. Adds a backdrop for mobile and makes
    // margin adjustments only on md+ screens to avoid overlap issues.
    document.addEventListener('DOMContentLoaded', function() {
        const mobileToggle = document.getElementById('mobileSidebarToggle');
        const sidebar = document.getElementById('sidebar');

        // Create backdrop for mobile overlay
        let backdrop = document.getElementById('sidebarBackdrop');
        if (!backdrop) {
            backdrop = document.createElement('div');
            backdrop.id = 'sidebarBackdrop';
            backdrop.className = 'fixed inset-0 bg-black/50 z-30 md:hidden hidden';
            document.body.appendChild(backdrop);
            backdrop.addEventListener('click', closeMobileSidebar);
        }

        function isDesktop() {
            return window.matchMedia('(min-width: 768px)').matches;
        }

        function openMobileSidebar() {
            if (!isDesktop()) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                backdrop.classList.remove('hidden');
            }
        }

        function closeMobileSidebar() {
            if (!isDesktop()) {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        if (mobileToggle) {
            mobileToggle.addEventListener('click', function() {
                // On mobile, simply open/close overlay
                if (sidebar.classList.contains('-translate-x-full')) {
                    openMobileSidebar();
                } else {
                    closeMobileSidebar();
                }
            });
        }

        // Desktop collapse/expand (controls width and content margin)
        window.toggleSidebar = function() {
            const toggleIcon = document.getElementById('toggleIcon');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            const contentWrappers = document.querySelectorAll('.main-content-wrapper');

            // Only perform width/margin changes on desktop
            if (!isDesktop()) {
                // On small screens, toggle as overlay instead
                if (sidebar.classList.contains('-translate-x-full')) {
                    openMobileSidebar();
                } else {
                    closeMobileSidebar();
                }
                return;
            }

            if (sidebar.classList.contains('w-64')) {
                // Collapse to icon-only mode
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');

                // Adjust content margin on md+
                contentWrappers.forEach(wrapper => {
                    // Only adjust desktop (md+) margin classes. Avoid toggling base 'ml-*' so
                    // mobile layout remains unaffected.
                    wrapper.classList.remove('md:ml-64');
                    wrapper.classList.add('md:ml-20');
                });

                // Hide all text
                sidebarTexts.forEach(text => text.classList.add('hidden'));

                // Rotate icon
                if (toggleIcon) toggleIcon.setAttribute('data-feather', 'chevron-right');
                feather.replace();
            } else {
                // Expand to full mode
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');

                // Adjust content margin on md+
                contentWrappers.forEach(wrapper => {
                    // Only adjust desktop (md+) margin classes. Avoid toggling base 'ml-*' so
                    // mobile layout remains unaffected.
                    wrapper.classList.remove('md:ml-20');
                    wrapper.classList.add('md:ml-64');
                });

                // Show all text
                sidebarTexts.forEach(text => text.classList.remove('hidden'));

                if (toggleIcon) toggleIcon.setAttribute('data-feather', 'chevron-left');
                feather.replace();
            }

            // Save desktop collapsed state
            if (isDesktop()) {
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('w-20'));
            }
        };

        // Restore desktop collapsed state on load (only affects md+)
        const restoreCollapsed = () => {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (!isDesktop()) return; // only restore on desktop

            if (isCollapsed) {
                const toggleIcon = document.getElementById('toggleIcon');
                const sidebarTexts = document.querySelectorAll('.sidebar-text');
                const contentWrappers = document.querySelectorAll('.main-content-wrapper');

                // Apply collapsed state
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');

                contentWrappers.forEach(wrapper => {
                    // Restoring collapsed state only on desktop: toggle md: classes only.
                    wrapper.classList.remove('md:ml-64');
                    wrapper.classList.add('md:ml-20');
                });

                sidebarTexts.forEach(text => text.classList.add('hidden'));
                if (toggleIcon) toggleIcon.setAttribute('data-feather', 'chevron-right');
                feather.replace();
            }
        };

        // Initial restore and on resize: ensure state is correct
        restoreCollapsed();
        window.addEventListener('resize', () => {
            // If switching between desktop and mobile, ensure overlay/backdrop is closed on desktop
            if (isDesktop()) {
                backdrop.classList.add('hidden');
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('md:translate-x-0');
                restoreCollapsed();
            } else {
                // hide sidebar on mobile by default
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                backdrop.classList.add('hidden');
            }
        });
    });
</script>
