@extends('layouts.app')

@section('title', 'KPI & Performance Indicator - MyHIMATIKA')

@section('content')
    <!-- Navbar Top -->
    @include('components.navbar')

    <!-- Sidebar -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div
        class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-slate-50 dark:bg-slate-900 transition-all duration-300">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-heading font-bold text-slate-900 dark:text-slate-100 flex items-center">
                    <i data-feather="trending-up" class="w-8 h-8 mr-3 text-green-600 dark:text-green-400"></i>
                    Key Performance Indicator (KPI)
                </h1>
                <p class="mt-2 text-slate-600 dark:text-slate-400 font-body">Monitoring penilaian kumulatif dan
                    performa individu PPH</p>
            </div>

            <!-- KPI Section (Kumulatif SEMUA Member) -->
            <div class="mb-8">
                <div
                    class="bg-gradient-to-r from-green-600 to-cyan-600 dark:from-green-700 dark:to-cyan-700 rounded-lg p-6 text-white shadow-xl mb-6 geometric-pattern">
                    <h2 class="text-2xl font-bold mb-2 flex items-center">
                        <i data-feather="award" class="w-7 h-7 mr-2"></i>
                        KPI Organisasi (Kumulatif Seluruh PPH)
                    </h2>
                    <p class="text-green-50 text-sm">Key Performance Indicator - Indikator pencapaian keberhasilan
                        kaderisasi
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <!-- Total KPI Organisasi -->
                    <div class="md:col-span-4">
                        <div
                            class="bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 p-8 border-l-4 border-l-green-500 dark:border-l-green-400 transition-colors duration-300">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p
                                        class="text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide">
                                        Total KPI
                                        Organisasi</p>
                                    <p class="text-5xl font-bold text-green-700 dark:text-green-400 mt-2">
                                        {{ number_format($totalKPI, 2) }}</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Rata-rata dari Kehadiran,
                                        Tugas & Nilai</p>
                                </div>
                                <div
                                    class="h-24 w-24 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                    <i data-feather="trending-up" class="w-12 h-12 text-green-600 dark:text-green-400"></i>
                                </div>
                            </div>
                            <div class="bg-green-100 dark:bg-green-900/30 rounded-full h-4 overflow-hidden">
                                <div class="bg-green-600 dark:bg-green-500 h-full rounded-full transition-all duration-1000"
                                    style="width: {{ min($totalKPI, 100) }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- KPI Kehadiran -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 p-6 border-l-4 border-l-blue-500 dark:border-l-blue-400 transition-colors duration-300">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-slate-900 dark:text-slate-100">KPI Kehadiran</h3>
                            <i data-feather="calendar-check" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <p class="text-3xl font-bold text-blue-700 dark:text-blue-400">
                            {{ number_format($kpiAttendance, 1) }}%</p>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-2">Tingkat kehadiran seluruh PPH</p>
                        <div class="mt-3 bg-blue-100 dark:bg-blue-900/30 rounded-full h-2 overflow-hidden">
                            <div class="bg-blue-600 dark:bg-blue-500 h-full rounded-full transition-all duration-1000"
                                style="width: {{ min($kpiAttendance, 100) }}%"></div>
                        </div>
                    </div>

                    <!-- KPI Tugas -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 p-6 border-l-4 border-l-purple-500 dark:border-l-purple-400 transition-colors duration-300">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-slate-900 dark:text-slate-100">KPI Pengumpulan Tugas</h3>
                            <i data-feather="file-text" class="w-6 h-6 text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <p class="text-3xl font-bold text-purple-700 dark:text-purple-400">
                            {{ number_format($kpiSubmission, 1) }}%</p>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-2">Tingkat pengumpulan tugas</p>
                        <div class="mt-3 bg-purple-100 dark:bg-purple-900/30 rounded-full h-2 overflow-hidden">
                            <div class="bg-purple-600 dark:bg-purple-500 h-full rounded-full transition-all duration-1000"
                                style="width: {{ min($kpiSubmission, 100) }}%"></div>
                        </div>
                    </div>

                    <!-- KPI Nilai -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 p-6 border-l-4 border-l-cyan-500 dark:border-l-cyan-400 transition-colors duration-300">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-slate-900 dark:text-slate-100">KPI Nilai</h3>
                            <i data-feather="star" class="w-6 h-6 text-cyan-600 dark:text-cyan-400"></i>
                        </div>
                        <p class="text-3xl font-bold text-cyan-700 dark:text-cyan-400">{{ number_format($kpiScore, 1) }}</p>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-2">Rata-rata nilai seluruh PPH</p>
                        <div class="mt-3 bg-cyan-100 dark:bg-cyan-900/30 rounded-full h-2 overflow-hidden">
                            <div class="bg-cyan-600 dark:bg-cyan-500 h-full rounded-full transition-all duration-1000"
                                style="width: {{ min($kpiScore, 100) }}%"></div>
                        </div>
                    </div>

                    <!-- Info KPI -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 p-6 border-l-4 border-l-yellow-500 dark:border-l-yellow-400 transition-colors duration-300">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-slate-900 dark:text-slate-100">Total PPH Aktif</h3>
                            <i data-feather="users" class="w-6 h-6 text-yellow-600 dark:text-yellow-400"></i>
                        </div>
                        <p class="text-3xl font-bold text-yellow-700 dark:text-yellow-400">{{ $totalMembers }}</p>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-2">PPH yang aktif</p>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t-4 border-slate-300 dark:border-slate-600 my-8 transition-colors duration-300"></div>

            <!-- PI Section (Performance Indicator per Member) -->
            <div class="mb-6">
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-slate-100 flex items-center mb-4">
                    <i data-feather="bar-chart-2" class="w-7 h-7 mr-2 text-blue-600 dark:text-blue-400"></i>
                    Performance Indicator (PI) - Per PPH
                </h2>
                <p class="text-slate-600 dark:text-slate-400 font-body mb-6">Indikator kinerja individu setiap PPH</p>
            </div>

            <!-- Summary Cards PI -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Rata-rata PI -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 p-6 transition-colors duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-600 dark:text-slate-400">Rata-rata PI</p>
                            <p class="text-3xl font-bold text-green-700 dark:text-green-400 mt-2">
                                {{ number_format($averagePI, 2) }}</p>
                        </div>
                        <div
                            class="h-14 w-14 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                            <i data-feather="bar-chart-2" class="w-8 h-8 text-green-600 dark:text-green-400"></i>
                        </div>
                    </div>
                </div>

                <!-- PI Tertinggi -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 p-6 transition-colors duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-600 dark:text-slate-400">PI Tertinggi</p>
                            <p class="text-3xl font-bold text-purple-700 dark:text-purple-400 mt-2">
                                {{ number_format($highestPI, 2) }}</p>
                        </div>
                        <div
                            class="h-14 w-14 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                            <i data-feather="award" class="w-8 h-8 text-purple-600 dark:text-purple-400"></i>
                        </div>
                    </div>
                </div>

                <!-- PI Terendah -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 p-6 transition-colors duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-600 dark:text-slate-400">PI Terendah</p>
                            <p class="text-3xl font-bold text-red-700 dark:text-red-400 mt-2">
                                {{ number_format($lowestPI, 2) }}</p>
                        </div>
                        <div class="h-14 w-14 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                            <i data-feather="alert-circle" class="w-8 h-8 text-red-600 dark:text-red-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel PI Member -->
            <div
                class="bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                <div
                    class="px-6 py-4 border-b border-slate-200 dark:border-slate-600 bg-gradient-to-r from-blue-600 to-cyan-600 dark:from-blue-700 dark:to-cyan-700">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i data-feather="list" class="w-6 h-6 mr-2"></i>
                        Daftar Performance Indicator PPH
                    </h2>
                </div>

                <!-- Search & Filter -->
                <div
                    class="px-6 py-4 bg-slate-50 dark:bg-slate-700 border-b border-slate-200 dark:border-slate-600 transition-colors duration-300">
                    <form method="GET" action="{{ route('kpi.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama atau NRP..."
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400">
                        </div>
                        <div>
                            <select name="kelompok"
                                class="w-full md:w-48 px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400">
                                <option value="">Semua Kelompok</option>
                                @foreach ($kelompoks as $kelompok)
                                    <option value="{{ $kelompok }}"
                                        {{ request('kelompok') == $kelompok ? 'selected' : '' }}>
                                        {{ $kelompok }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 dark:bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 dark:hover:bg-blue-700 transition">
                                <i data-feather="search" class="w-5 h-5 inline mr-1"></i>
                                Cari
                            </button>
                            <a href="{{ route('kpi.index') }}"
                                class="px-6 py-2 bg-gray-600 dark:bg-slate-600 text-white font-semibold rounded-lg hover:bg-gray-700 dark:hover:bg-slate-700 transition">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-600">
                        <thead class="bg-slate-100 dark:bg-slate-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                    No
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300">
                                        Nama
                                        @if (request('sort') === 'name')
                                            <i data-feather="{{ request('direction') === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="w-4 h-4 ml-1"></i>
                                        @else
                                            <i data-feather="chevrons-up-down"
                                                class="w-4 h-4 ml-1 text-slate-400 dark:text-slate-500"></i>
                                        @endif
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'nrp', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300">
                                        NRP
                                        @if (request('sort') === 'nrp')
                                            <i data-feather="{{ request('direction') === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="w-4 h-4 ml-1"></i>
                                        @else
                                            <i data-feather="chevrons-up-down"
                                                class="w-4 h-4 ml-1 text-slate-400 dark:text-slate-500"></i>
                                        @endif
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'kelompok', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300">
                                        Kelompok
                                        @if (request('sort') === 'kelompok')
                                            <i data-feather="{{ request('direction') === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="w-4 h-4 ml-1"></i>
                                        @else
                                            <i data-feather="chevrons-up-down"
                                                class="w-4 h-4 ml-1 text-slate-400 dark:text-slate-500"></i>
                                        @endif
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                    Kehadiran
                                </th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                    Tugas
                                </th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                    Rata-rata Nilai
                                </th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'total_pi', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center justify-center hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300">
                                        Total PI
                                        @if (request('sort') === 'total_pi' || !request('sort'))
                                            <i data-feather="{{ request('direction') === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="w-4 h-4 ml-1"></i>
                                        @else
                                            <i data-feather="chevrons-up-down"
                                                class="w-4 h-4 ml-1 text-slate-400 dark:text-slate-500"></i>
                                        @endif
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                    Kategori
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                            @forelse ($members as $index => $member)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-slate-100">
                                        {{ $members->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-slate-100">
                                            {{ $member->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-slate-100 font-mono">
                                            {{ $member->nrp ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300">
                                            {{ $member->kelompok ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-sm font-semibold text-blue-700 dark:text-blue-400">
                                            {{ number_format($member->attendance_score, 1) }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-sm font-semibold text-purple-700 dark:text-purple-400">
                                            {{ number_format($member->submission_score, 1) }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-sm font-semibold text-cyan-700 dark:text-cyan-400">
                                            {{ number_format($member->average_score, 1) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-lg font-bold text-green-700 dark:text-green-400">
                                            {{ number_format($member->total_pi, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($member->total_pi >= 90)
                                            <span
                                                class="px-3 py-1 text-xs font-bold rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300">
                                                GOAT
                                            </span>
                                        @elseif($member->total_pi >= 75)
                                            <span
                                                class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300">
                                                Lulus
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300">
                                                Perlu Aksel
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-8 text-center text-gray-500 dark:text-slate-400">
                                        <i data-feather="inbox"
                                            class="w-12 h-12 mx-auto mb-2 text-gray-400 dark:text-slate-500"></i>
                                        <p class="text-sm">Tidak ada data PPH ditemukan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div
                    class="px-6 py-4 bg-slate-50 dark:bg-slate-700 border-t border-slate-200 dark:border-slate-600 transition-colors duration-300">
                    {{ $members->links() }}
                </div>
            </div>

        </div>
    </div>

    <script>
        // Initialize Feather Icons
        feather.replace();
    </script>
@endsection
