@extends('layouts.app')

@section('title', 'Dashboard - MyPH')

@section('content')
    <!-- Navbar Top -->
    @include('components.navbar')

    <!-- Sidebar -->
    @include('components.sidebar')

    <!-- Pop-up Notification (Muncul dari Atas) -->
    <div id="notification-popup"
        class="fixed top-0 right-6 z-50 bg-white dark:bg-slate-800 rounded-b-lg shadow-2xl border-l-4 border-cyan-400 max-w-md transform -translate-y-full transition-all duration-500 ease-out">
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 bg-cyan-100 dark:bg-cyan-900 rounded-full flex items-center justify-center">
                        <i data-feather="info" class="h-6 w-6 text-cyan-600 dark:text-cyan-400"></i>
                    </div>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Selamat Datang!</h3>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Anda berhasil login ke sistem MyPH.</p>
                </div>
                <button onclick="closeNotification()"
                    class="ml-3 flex-shrink-0 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition">
                    <i data-feather="x" class="h-5 w-5"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div
        class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-slate-50 dark:bg-slate-900 transition-all duration-300">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

            <!-- Announcement Section (Paling Atas) -->
            <div class="px-4 sm:px-0 mb-6">
                <div
                    class="bg-gradient-to-r from-blue-700 via-blue-600 to-cyan-500 dark:from-slate-700 dark:via-slate-800 dark:to-slate-600 rounded-lg shadow-lg overflow-hidden geometric-bg">
                    <div class="p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div
                                    class="h-12 w-12 bg-cyan-400 bg-opacity-30 rounded-full flex items-center justify-center">
                                    <i data-feather="volume-2" class="h-7 w-7 text-cyan-200"></i>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h2 class="text-xl font-bold text-white mb-2">Pengumuman Penting</h2>
                                <p class="text-white text-opacity-95 leading-relaxed">
                                    Selamat datang di sistem MyPH! Pastikan untuk selalu mengumpulkan tugas sebelum
                                    deadline.
                                    Periksa reminder di bawah untuk melihat tugas yang akan datang.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards (untuk Member: Tampilkan Statistik Kehadiran) -->
            @if (Auth::user()->isMember())
                @php
                    $userId = Auth::id();
                    $hadirCount = \App\Models\Attendance::where('user_id', $userId)->where('status', 'hadir')->count();
                    $izinCount = \App\Models\Attendance::where('user_id', $userId)->where('status', 'izin')->count();
                    $alpaCount = \App\Models\Attendance::where('user_id', $userId)->where('status', 'alpa')->count();
                @endphp

                <div class="px-4 sm:px-0 mb-8">
                    <div
                        class="bg-gradient-to-r from-indigo-500 to-purple-600 dark:from-indigo-600 dark:to-purple-700 rounded-lg shadow-lg p-6 mb-6">
                        <h3 class="text-xl font-heading font-bold text-white mb-4 flex items-center">
                            <i data-feather="user-check" class="w-6 h-6 mr-2"></i>
                            Statistik Kehadiran Anda
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <!-- Hadir -->
                            <div
                                class="bg-white/20 dark:bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/30 dark:border-white/20">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-white uppercase opacity-90">Hadir</p>
                                        <p class="text-3xl font-bold text-white mt-1">{{ $hadirCount }}</p>
                                        <p class="text-xs text-white opacity-75 mt-1">Hari</p>
                                    </div>
                                    <div class="bg-green-500 dark:bg-green-600 rounded-full p-3">
                                        <i data-feather="check-circle" class="w-6 h-6 text-white"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Izin -->
                            <div
                                class="bg-white/20 dark:bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/30 dark:border-white/20">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-white uppercase opacity-90">Izin</p>
                                        <p class="text-3xl font-bold text-white mt-1">{{ $izinCount }}</p>
                                        <p class="text-xs text-white opacity-75 mt-1">Hari</p>
                                    </div>
                                    <div class="bg-yellow-500 rounded-full p-3">
                                        <i data-feather="file-text" class="w-6 h-6 text-white"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Alpa -->
                            <div
                                class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-4 border border-white border-opacity-30">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-white uppercase opacity-90">Alpa</p>
                                        <p class="text-3xl font-bold text-white mt-1">{{ $alpaCount }}</p>
                                        <p class="text-xs text-white opacity-75 mt-1">Hari</p>
                                    </div>
                                    <div class="bg-red-500 rounded-full p-3">
                                        <i data-feather="x-circle" class="w-6 h-6 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('my-attendance') }}"
                                class="inline-flex items-center px-4 py-2 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-opacity-90 transition">
                                <i data-feather="calendar" class="w-4 h-4 mr-2"></i>
                                Lihat Detail Kehadiran
                            </a>
                        </div>
                    </div>

                    <!-- Deadline Reminder (Ringkas dengan Slider) -->
                    @php
                        $now = \Carbon\Carbon::now();
                        $upcomingAssignments = \App\Models\Assignment::where('is_active', true)
                            ->where('deadline', '>=', $now->toDateString())
                            ->orderBy('deadline', 'asc')
                            ->take(5)
                            ->get();
                    @endphp

                    @if ($upcomingAssignments->count() > 0)
                        <div
                            class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-hidden border border-slate-200 dark:border-slate-700">
                            <div
                                class="px-4 py-3 bg-gradient-to-r from-blue-700 to-cyan-600 dark:from-blue-800 dark:to-cyan-700 flex items-center justify-between">
                                <div class="flex items-center">
                                    <i data-feather="bell" class="h-5 w-5 text-white mr-2"></i>
                                    <h4 class="text-sm font-bold text-white">Deadline Tugas</h4>
                                </div>
                                @if ($upcomingAssignments->count() > 2)
                                    <div class="flex items-center space-x-2">
                                        <button onclick="slideAssignments('prev')"
                                            class="p-1 bg-white/20 hover:bg-white/30 dark:bg-white/10 dark:hover:bg-white/20 rounded transition">
                                            <i data-feather="chevron-left" class="h-4 w-4 text-white"></i>
                                        </button>
                                        <span class="text-xs text-white font-semibold">
                                            <span id="currentSlide">1</span>-<span id="maxSlide">2</span> /
                                            {{ $upcomingAssignments->count() }}
                                        </span>
                                        <button onclick="slideAssignments('next')"
                                            class="p-1 bg-white/20 hover:bg-white/30 dark:bg-white/10 dark:hover:bg-white/20 rounded transition">
                                            <i data-feather="chevron-right" class="h-4 w-4 text-white"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4 overflow-hidden">
                                <div id="assignmentSlider" class="flex transition-transform duration-300 ease-in-out">
                                    @foreach ($upcomingAssignments as $index => $assignment)
                                        @php
                                            $deadline = \Carbon\Carbon::parse($assignment->deadline);
                                            $daysLeft = (int) $now->diffInDays($deadline, false);

                                            // Tentukan warna berdasarkan sisa waktu
                                            if ($daysLeft < 1) {
                                                $bgColor = 'bg-red-50';
                                                $textColor = 'text-red-800';
                                                $badgeColor = 'bg-red-100';
                                                $iconColor = 'text-red-600';
                                            } elseif ($daysLeft <= 3) {
                                                $bgColor = 'bg-orange-50';
                                                $textColor = 'text-orange-800';
                                                $badgeColor = 'bg-orange-100';
                                                $iconColor = 'text-orange-600';
                                            } elseif ($daysLeft <= 7) {
                                                $bgColor = 'bg-yellow-50';
                                                $textColor = 'text-yellow-800';
                                                $badgeColor = 'bg-yellow-100';
                                                $iconColor = 'text-yellow-600';
                                            } else {
                                                $bgColor = 'bg-cyan-50';
                                                $textColor = 'text-cyan-800';
                                                $badgeColor = 'bg-cyan-100';
                                                $iconColor = 'text-cyan-600';
                                            }

                                            $timeLeft = $daysLeft < 1 ? 'Hari ini!' : $daysLeft . ' hari lagi';
                                        @endphp

                                        <div class="flex-shrink-0 w-full sm:w-1/2 md:w-1/3 px-2 assignment-card">
                                            <div
                                                class="{{ $bgColor }} rounded-lg p-4 h-full border-l-4 border-{{ substr($iconColor, 5) }}">
                                                <div class="flex items-start justify-between mb-2">
                                                    <div class="flex-1">
                                                        <h5 class="font-bold {{ $textColor }} text-sm mb-1">
                                                            {{ $assignment->title }}</h5>
                                                        <p class="text-xs {{ $textColor }} opacity-75">
                                                            {{ Str::limit($assignment->description, 50) }}
                                                        </p>
                                                    </div>
                                                    <i data-feather="clock"
                                                        class="h-5 w-5 {{ $iconColor }} ml-2 flex-shrink-0"></i>
                                                </div>
                                                <div class="flex items-center justify-between mt-3">
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="px-2 py-1 {{ $badgeColor }} {{ $textColor }} rounded text-xs font-semibold">
                                                            {{ $timeLeft }}
                                                        </span>
                                                        <span class="text-xs {{ $textColor }} opacity-70">
                                                            {{ $deadline->format('d M Y') }}
                                                        </span>
                                                    </div>
                                                    @if (Auth::user()->isMember())
                                                        <a href="{{ route('submissions.create') }}"
                                                            class="px-3 py-1 bg-blue-700 text-white rounded hover:bg-blue-800 transition text-xs font-semibold">
                                                            Kumpulkan
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="px-4 sm:px-0">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Users Card -->
                    <div
                        class="bg-white dark:bg-slate-800 overflow-hidden shadow rounded-lg border border-slate-200 dark:border-slate-700">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-10 w-10 bg-cyan-100 dark:bg-cyan-900 rounded-lg flex items-center justify-center">
                                        <i data-feather="users" class="h-6 w-6 text-cyan-600 dark:text-cyan-400"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 truncate">Total
                                            Members</dt>
                                        <dd class="text-lg font-medium text-slate-900 dark:text-slate-100">
                                            {{ \App\Models\User::where('role', 'member')->count() }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Assignments Card -->
                    <div
                        class="bg-white dark:bg-slate-800 overflow-hidden shadow rounded-lg border border-slate-200 dark:border-slate-700">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-10 w-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                        <i data-feather="file-text" class="h-6 w-6 text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 truncate">Total
                                            Assignments</dt>
                                        <dd class="text-lg font-medium text-slate-900 dark:text-slate-100">
                                            {{ \App\Models\Assignment::count() }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Card -->
                    <div
                        class="bg-white dark:bg-slate-800 overflow-hidden shadow rounded-lg border border-slate-200 dark:border-slate-700">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-10 w-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                        <i data-feather="check-circle"
                                            class="h-6 w-6 text-green-600 dark:text-green-400"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 truncate">Status
                                        </dt>
                                        <dd class="text-lg font-medium text-slate-900 dark:text-slate-100">Online</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Last Login Card -->
                    <div
                        class="bg-white dark:bg-slate-800 overflow-hidden shadow rounded-lg border border-slate-200 dark:border-slate-700">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-10 w-10 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                                        <i data-feather="clock" class="h-6 w-6 text-yellow-600 dark:text-yellow-400"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 truncate">Last
                                            Login</dt>
                                        <dd class="text-lg font-medium text-slate-900 dark:text-slate-100">
                                            {{ date('H:i') }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Version Card -->
                    <div
                        class="bg-white dark:bg-slate-800 overflow-hidden shadow rounded-lg border border-slate-200 dark:border-slate-700 lg:col-span-2">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-10 w-10 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                                        <i data-feather="zap" class="h-6 w-6 text-purple-600 dark:text-purple-400"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400 truncate">Version
                                        </dt>
                                        <dd class="text-lg font-medium text-slate-900 dark:text-slate-100">1.0.0</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 mt-8">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <p class="text-center text-sm text-slate-500 dark:text-slate-400">
                        © {{ date('Y') }} MyPH. Powered by Laravel & Tailwind CSS.
                    </p>
                </div>
            </footer>
        </div>
    </div>

    <!-- Pop-up JavaScript -->
    <script>
        // Tampilkan popup dengan animasi slide down dari atas
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();

            // Slide down popup setelah 100ms
            setTimeout(() => {
                const popup = document.getElementById('notification-popup');
                popup.style.transform = 'translateY(1.5rem)'; // Muncul dengan jarak dari atas
            }, 100);
        });

        // Auto-close popup setelah 10 detik
        setTimeout(() => {
            closeNotification();
        }, 10000);

        function closeNotification() {
            const popup = document.getElementById('notification-popup');
            popup.style.transform = 'translateY(-100%)'; // Slide up ke atas
            popup.style.opacity = '0';

            // Hapus dari DOM setelah animasi selesai
            setTimeout(() => {
                popup.remove();
            }, 500);
        }

        // Assignment Slider
        let currentIndex = 0;
        const assignmentSlider = document.getElementById('assignmentSlider');
        const assignmentCards = document.querySelectorAll('.assignment-card');
        const totalCards = assignmentCards.length;
        const cardsPerView = window.innerWidth >= 768 ? 2 : 1; // 2 cards on desktop, 1 on mobile
        const maxIndex = Math.max(0, totalCards - cardsPerView);

        function updateSlider() {
            if (assignmentSlider) {
                const cardWidth = assignmentCards[0]?.offsetWidth || 0;
                const offset = -(currentIndex * cardWidth);
                assignmentSlider.style.transform = `translateX(${offset}px)`;

                // Update counter
                const currentSlideSpan = document.getElementById('currentSlide');
                const maxSlideSpan = document.getElementById('maxSlide');
                if (currentSlideSpan && maxSlideSpan) {
                    currentSlideSpan.textContent = currentIndex + 1;
                    maxSlideSpan.textContent = Math.min(currentIndex + cardsPerView, totalCards);
                }

                // Re-initialize feather icons
                feather.replace();
            }
        }

        function slideAssignments(direction) {
            if (direction === 'next' && currentIndex < maxIndex) {
                currentIndex++;
            } else if (direction === 'prev' && currentIndex > 0) {
                currentIndex--;
            }
            updateSlider();
        }

        // Update slider on window resize
        window.addEventListener('resize', () => {
            updateSlider();
        });

        // Initialize slider on page load
        document.addEventListener('DOMContentLoaded', () => {
            updateSlider();
        });
    </script>
@endsection
