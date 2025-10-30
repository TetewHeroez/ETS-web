@extends('layouts.app')

@section('title', 'Dashboard - MyHIMATIKA')

@section('content')
    <!-- Navbar Top -->
    @include('components.navbar')

    <!-- Sidebar -->
    @include('components.sidebar')

    <!-- Kontrak Dialog (Centered Modal) - Only for Members -->
    @if (Auth::user()->isMember())
        @php
            $activeContract = \App\Models\Contract::latest()->first();
        @endphp

        @if ($activeContract)
            <div id="contract-dialog"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-hidden transform scale-95 transition-transform duration-300">
                    <!-- Header -->
                    <div
                        class="bg-gradient-to-r from-blue-700 via-blue-600 to-cyan-500 dark:from-blue-800 dark:to-cyan-700 px-8 py-6">
                        <h2 class="text-2xl font-bold text-white text-center">{{ $activeContract->title }}</h2>
                    </div>

                    <!-- Content -->
                    <div class="p-8 overflow-y-auto max-h-[calc(90vh-200px)] custom-scrollbar">
                        <div class="space-y-6">
                            @if ($activeContract->description)
                                <div class="bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-600 p-4 rounded-r-lg mb-4">
                                    <p class="text-sm text-blue-900 dark:text-blue-200 font-semibold">
                                        {{ $activeContract->description }}
                                    </p>
                                </div>
                            @endif

                            <ol class="space-y-4 text-slate-700 dark:text-slate-300">
                                @foreach ($activeContract->rules as $index => $rule)
                                    <li class="flex items-start">
                                        <span
                                            class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-blue-600 to-cyan-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">{{ $index + 1 }}</span>
                                        <p class="py-1"><strong
                                                class="text-slate-900 dark:text-slate-100">{{ $rule }}</strong></p>
                                    </li>
                                @endforeach
                            </ol>

                            <div
                                class="mt-8 p-6 bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20 rounded-xl border border-cyan-200 dark:border-cyan-700">
                                <p class="text-center text-slate-700 dark:text-slate-300 text-sm leading-relaxed">
                                    Dimohon untuk <strong class="text-blue-700 dark:text-blue-400">Mengingat</strong>,
                                    seluruh poin-poin kontrak yang telah disepakati.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Buttons -->
                    <div
                        class="px-8 py-6 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-700 flex justify-end gap-4">
                        <button onclick="closeContract()" id="agreeButton"
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-700 dark:to-cyan-600 text-white font-bold rounded-lg hover:from-blue-700 hover:to-cyan-600 dark:hover:from-blue-800 dark:hover:to-cyan-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i data-feather="check-circle" class="w-5 h-5 inline mr-2"></i>
                            Ya Paham
                        </button>
                    </div>
                </div>
            </div>
        @endif
    @endif

    <!-- Main Content -->
    <div
        class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-slate-50 dark:bg-slate-900 transition-all duration-300">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0 mb-6">
                <div
                    class="bg-gradient-to-r from-blue-700 via-blue-600 to-cyan-500 dark:from-slate-700 dark:via-slate-800 dark:to-slate-600 rounded-lg shadow-lg overflow-hidden geometric-bg">
                    <div class="p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div
                                    class="h-12 w-12 bg-cyan-400 bg-opacity-30 rounded-full flex items-center justify-center">
                                    <i data-feather="volume-2" class="h-7 w-7 text-cyan-100"></i>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h2 class="text-xl font-bold dark:text-white mb-2 text-slate-900">Pengumuman Penting</h2>
                                <p class="dark:text-white text-opacity-95 leading-relaxed text-slate-900">
                                    Selamat datang di sistem MyHIMATIKA! Pastikan untuk selalu mengumpulkan tugas sebelum
                                    deadline.
                                    Periksa reminder di bawah untuk melihat panggilan yang akan datang.
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
                        class="bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-slate-700 dark:to-cyan-600 rounded-lg shadow-lg p-6 mb-6">
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
                                class="bg-white/20 dark:bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/30 dark:border-white/20">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-white uppercase opacity-90">Alpa</p>
                                        <p class="text-3xl font-bold text-white mt-1">{{ $alpaCount }}</p>
                                        <p class="text-xs text-white opacity-75 mt-1">Hari</p>
                                    </div>
                                    <div class="bg-red-500 dark:bg-red-600 rounded-full p-3">
                                        <i data-feather="x-circle" class="w-6 h-6 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('my-attendance') }}"
                                class="inline-flex items-center px-4 py-2 bg-white text-blue-700 font-semibold rounded-lg hover:bg-opacity-90 transition">
                                <i data-feather="calendar" class="w-4 h-4 mr-2"></i>
                                Lihat Detail Kehadiran
                            </a>
                        </div>
                    </div>

                    <!-- Deadline Reminder (Ringkas dengan Slider) -->
                    @php
                        $now = \Carbon\Carbon::now();
                        $upcomingAssignments = \App\Models\Assignment::where('deadline', '>=', $now->toDateString())
                            ->orderBy('deadline', 'asc')
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
                                            <span id="currentSlide">1</span><span id="maxSlide">-3</span> /
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
                                                $darkbgColor = 'dark:bg-red-200/30';
                                                $textColor = 'text-red-800';
                                                $darktextColor = 'dark:text-red-200';
                                                $badgeColor = 'bg-red-100';
                                                $darkbadgeColor = 'dark:bg-red-900/30';
                                                $iconColor = 'text-red-600';
                                                $darkiconColor = 'dark:text-red-200';
                                            } elseif ($daysLeft <= 3) {
                                                $bgColor = 'bg-orange-50';
                                                $darkbgColor = 'dark:bg-orange-200/30';
                                                $textColor = 'text-orange-800';
                                                $darktextColor = 'dark:text-orange-200';
                                                $badgeColor = 'bg-orange-100';
                                                $darkbadgeColor = 'dark:bg-orange-900/30';
                                                $iconColor = 'text-orange-600';
                                                $darkiconColor = 'dark:text-orange-200';
                                            } elseif ($daysLeft <= 7) {
                                                $bgColor = 'bg-yellow-50';
                                                $darkbgColor = 'dark:bg-yellow-200/30';
                                                $textColor = 'text-yellow-800';
                                                $darktextColor = 'dark:text-yellow-200';
                                                $badgeColor = 'bg-yellow-100';
                                                $darkbadgeColor = 'dark:bg-yellow-900/30';
                                                $iconColor = 'text-yellow-600';
                                                $darkiconColor = 'dark:text-yellow-200';
                                            } else {
                                                $bgColor = 'bg-cyan-50';
                                                $darkbgColor = 'dark:bg-cyan-200/30';
                                                $textColor = 'text-cyan-800';
                                                $darktextColor = 'dark:text-cyan-200';
                                                $badgeColor = 'bg-cyan-100';
                                                $darkbadgeColor = 'dark:bg-cyan-900/30';
                                                $iconColor = 'text-cyan-600';
                                                $darkiconColor = 'dark:text-cyan-200';
                                            }
                                            $timeLeft = $daysLeft < 1 ? 'Hari ini!' : $daysLeft . ' hari lagi';
                                        @endphp

                                        <div class="flex-shrink-0 w-full sm:w-1/2 md:w-1/3 px-2 assignment-card">
                                            <div
                                                class="{{ $bgColor }} {{ $darkbgColor }} rounded-lg p-4 h-full border-l-4 border-indigo-500 dark:border-cyan-500">
                                                <div class="flex items-start justify-between mb-2">
                                                    <div class="flex-1">
                                                        <h5
                                                            class="font-bold {{ $textColor }} {{ $darktextColor }} text-sm mb-1">
                                                            {{ $assignment->title }}</h5>
                                                        <p
                                                            class="text-xs {{ $textColor }} {{ $darktextColor }} opacity-75">
                                                            {{ Str::limit($assignment->description, 50) }}
                                                        </p>
                                                    </div>
                                                    <i data-feather="clock"
                                                        class="h-5 w-5 {{ $iconColor }} {{ $darkiconColor }} ml-2 flex-shrink-0"></i>
                                                </div>
                                                <div class="flex items-center justify-between mt-3">
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="px-2 py-1 {{ $badgeColor }} {{ $textColor }} {{ $darkbadgeColor }} {{ $darktextColor }} rounded text-xs font-semibold">
                                                            {{ $timeLeft }}
                                                        </span>
                                                        <span
                                                            class="text-xs {{ $textColor }} {{ $darktextColor }} opacity-70">
                                                            {{ $deadline->format('d M Y') }}
                                                        </span>
                                                    </div>
                                                    @if (Auth::user()->isMember())
                                                        <a href="{{ route('submissions.table') }}"
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


                </div>
            </div>

            <!-- Footer -->
            <footer class="bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 mt-8">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <p class="text-center text-sm text-slate-500 dark:text-slate-400">
                        © {{ date('Y') }} MyHIMATIKA. Powered by Laravel & Tailwind CSS.
                    </p>
                </div>
            </footer>
        </div>
    </div>

    <!-- Contract Dialog JavaScript -->
    <script>
        // Tampilkan contract dialog dengan animasi
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();

            // Show contract dialog after 300ms
            setTimeout(() => {
                const dialog = document.getElementById('contract-dialog');
                dialog.classList.remove('opacity-0', 'pointer-events-none');
                dialog.querySelector('div').classList.remove('scale-95');
                dialog.querySelector('div').classList.add('scale-100');

                // Re-render feather icons inside dialog
                feather.replace();
            }, 300);
        });

        function closeContract() {
            const dialog = document.getElementById('contract-dialog');
            dialog.classList.add('opacity-0', 'pointer-events-none');
            dialog.querySelector('div').classList.remove('scale-100');
            dialog.querySelector('div').classList.add('scale-95');

            // Optional: Save to localStorage that user has agreed
            localStorage.setItem('contractAgreed', 'true');

            // Remove from DOM after animation
            setTimeout(() => {
                dialog.remove();
            }, 300);
        }

        // Optional: Check if user already agreed (you can implement this)
        // if (localStorage.getItem('contractAgreed') === 'true') {
        //     document.getElementById('contract-dialog').remove();
        // }

        // Assignment Slider (responsive: phone=1, tablet=2, pc=3)
        (function() {
            let currentIndex = 0;

            const getCardsPerView = () => {
                const w = window.innerWidth;
                // Use breakpoints: <768 => 1 (phone), 768-1023 => 2 (tablet), >=1024 => 3 (pc)
                if (w < 768) return 1;
                if (w < 1024) return 2;
                return 3;
            };

            const updateSlider = () => {
                const assignmentSlider = document.getElementById('assignmentSlider');
                const assignmentCards = Array.from(document.querySelectorAll('.assignment-card'));
                const totalCards = assignmentCards.length;
                const cardsPerView = getCardsPerView();
                const maxIndex = Math.max(0, totalCards - cardsPerView);

                // ensure currentIndex in range
                if (currentIndex > maxIndex) currentIndex = maxIndex;
                if (currentIndex < 0) currentIndex = 0;

                if (!assignmentSlider || totalCards === 0) return;

                // card width (include gap) using bounding rect of wrapper
                const cardWidth = assignmentCards[0].getBoundingClientRect().width || 0;
                const offset = -(currentIndex * cardWidth);
                assignmentSlider.style.transform = `translateX(${offset}px)`;

                // Update counter
                const currentSlideSpan = document.getElementById('currentSlide');
                const maxSlideSpan = document.getElementById('maxSlide');
                if (currentSlideSpan && maxSlideSpan) {
                    currentSlideSpan.textContent = (currentIndex + 1).toString();
                    maxSlideSpan.textContent = '-' + Math.min(currentIndex + cardsPerView, totalCards);
                    if (maxSlideSpan.textContent === "-" + Math.min(currentIndex + cardsPerView, totalCards)
                        .toString()) {
                        maxSlideSpan.textContent = "";
                    }
                }

                // Re-initialize feather icons inside slider (if any)
                if (typeof feather !== 'undefined') feather.replace();
            };

            window.slideAssignments = function(direction) {
                const assignmentCards = Array.from(document.querySelectorAll('.assignment-card'));
                const totalCards = assignmentCards.length;
                const cardsPerView = getCardsPerView();
                const maxIndex = Math.max(0, totalCards - cardsPerView);

                if (direction === 'next') {
                    if (currentIndex < maxIndex) {
                        currentIndex++;
                    } else {
                        // wrap to the earliest (closest deadline) as requested
                        currentIndex = 0;
                    }
                } else if (direction === 'prev') {
                    if (currentIndex > 0) {
                        currentIndex--;
                    } else {
                        // wrap to last set
                        currentIndex = maxIndex;
                    }
                }

                updateSlider();
            };

            // Update slider on window resize (recalculate sizes and cardsPerView)
            window.addEventListener('resize', () => {
                // brief debounce
                clearTimeout(window._updateSliderTimeout);
                window._updateSliderTimeout = setTimeout(() => updateSlider(), 120);
            });

            // Initialize slider on page load
            document.addEventListener('DOMContentLoaded', () => {
                updateSlider();
            });
        })();
    </script>
@endsection
