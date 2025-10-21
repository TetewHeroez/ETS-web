<!-- Sidebar -->
<aside id="sidebar"
    class="fixed left-0 top-16 h-[calc(100vh-4rem)] w-64 bg-gradient-to-b from-blue-700 to-blue-900 text-white shadow-2xl flex flex-col z-40 transition-all duration-300">

    <!-- Toggle Button -->
    <button onclick="toggleSidebar()"
        class="absolute -right-3 top-4 w-6 h-6 bg-cyan-400 text-blue-900 rounded-full shadow-lg flex items-center justify-center hover:bg-cyan-300 transition z-50">
        <i data-feather="chevron-left" id="toggleIcon" class="w-4 h-4"></i>
    </button>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <a href="{{ route('dashboard') }}"
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}"
            title="Dashboard">
            <i data-feather="home" class="w-5 h-5 flex-shrink-0"></i>
            <span class="font-medium sidebar-text">Dashboard</span>
        </a>

        @if (Auth::user()->isMember())
            <a href="{{ route('submissions.create') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('submissions.create') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}"
                title="Kumpulkan Tugas">
                <i data-feather="upload" class="w-5 h-5 flex-shrink-0"></i>
                <span class="font-medium sidebar-text">Kumpulkan Tugas</span>
            </a>
        @endif

        @if (Auth::user()->isAdmin() || Auth::user()->isSuperadmin())
            <a href="{{ route('assignments.index') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('assignments.*') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}"
                title="Kelola Tugas">
                <i data-feather="file-text" class="w-5 h-5 flex-shrink-0"></i>
                <span class="font-medium sidebar-text">Kelola Tugas</span>
            </a>
        @endif

        <a href="{{ route('submissions.table') }}"
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('submissions.table') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}"
            title="Progress Member">
            <i data-feather="bar-chart-2" class="w-5 h-5 flex-shrink-0"></i>
            <span class="font-medium sidebar-text">Progress</span>
        </a>

        @if (Auth::user()->isAdmin() || Auth::user()->isSuperadmin())
            <a href="{{ route('attendances.index') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('attendances.index') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}"
                title="Kelola Absensi">
                <i data-feather="user-check" class="w-5 h-5 flex-shrink-0"></i>
                <span class="font-medium sidebar-text">Kelola Absensi</span>
            </a>

            <a href="#"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition hover:bg-white hover:bg-opacity-10"
                title="Kelola Member">
                <i data-feather="users" class="w-5 h-5 flex-shrink-0"></i>
                <span class="font-medium sidebar-text">Kelola Member</span>
            </a>
        @endif

        @if (Auth::user()->isMember())
            <a href="{{ route('my-attendance') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('my-attendance') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}"
                title="Kehadiran Saya">
                <i data-feather="calendar" class="w-5 h-5 flex-shrink-0"></i>
                <span class="font-medium sidebar-text">Kehadiran Saya</span>
            </a>
        @endif
    </nav>

    <!-- Profile & Logout Section -->
    <div class="p-4 border-t border-white border-opacity-20 space-y-2">
        <!-- Profil (All users) -->
        <a href="{{ route('profile.show') }}"
            class="flex items-center  justify-center space-x-2 px-4 py-3 rounded-lg transition {{ request()->routeIs('profile.*') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}"
            title="Profil Saya">
            <i data-feather="user-check" class="w-5 h-5 flex-shrink-0"></i>
            <span class="font-medium sidebar-text">Profil</span>
        </a>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center space-x-2 px-4 py-3 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg transition"
                title="Logout">
                <i data-feather="log-out" class="w-5 h-5 flex-shrink-0"></i>
                <span class="font-medium sidebar-text">Logout</span>
            </button>
        </form>
    </div>
</aside>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const toggleIcon = document.getElementById('toggleIcon');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');

        // Get all content wrappers (look for parent's next sibling or body children)
        const contentWrappers = document.querySelectorAll('.main-content-wrapper');

        // Toggle sidebar width
        if (sidebar.classList.contains('w-64')) {
            // Collapse to icon-only mode
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-20');

            // Adjust content margin
            contentWrappers.forEach(wrapper => {
                wrapper.classList.remove('ml-64');
                wrapper.classList.add('ml-20');
            });

            // Hide all text
            sidebarTexts.forEach(text => {
                text.classList.add('hidden');
            });

            // Rotate icon
            toggleIcon.setAttribute('data-feather', 'chevron-right');
            feather.replace();
        } else {
            // Expand to full mode
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-64');

            // Adjust content margin
            contentWrappers.forEach(wrapper => {
                wrapper.classList.remove('ml-20');
                wrapper.classList.add('ml-64');
            });

            // Show all text
            sidebarTexts.forEach(text => {
                text.classList.remove('hidden');
            });

            // Rotate icon
            toggleIcon.setAttribute('data-feather', 'chevron-left');
            feather.replace();
        }

        // Save state to localStorage
        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('w-20'));
    }

    // Restore sidebar state on page load WITHOUT animation
    document.addEventListener('DOMContentLoaded', function() {
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            const sidebar = document.getElementById('sidebar');
            const toggleIcon = document.getElementById('toggleIcon');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            const contentWrappers = document.querySelectorAll('.main-content-wrapper');

            // Temporarily disable transitions
            sidebar.style.transition = 'none';
            contentWrappers.forEach(wrapper => {
                wrapper.style.transition = 'none';
            });

            // Apply collapsed state
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-20');

            contentWrappers.forEach(wrapper => {
                wrapper.classList.remove('ml-64');
                wrapper.classList.add('ml-20');
            });

            sidebarTexts.forEach(text => {
                text.classList.add('hidden');
            });

            toggleIcon.setAttribute('data-feather', 'chevron-right');
            feather.replace();

            // Re-enable transitions after a brief moment
            setTimeout(() => {
                sidebar.style.transition = '';
                contentWrappers.forEach(wrapper => {
                    wrapper.style.transition = '';
                });
            }, 50);
        }
    });
</script>
