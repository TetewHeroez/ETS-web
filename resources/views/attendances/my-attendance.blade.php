@extends('layouts.app')

@section('title', 'Kehadiran Saya - MyPH')

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
                    <i data-feather="calendar" class="w-8 h-8 mr-3 text-blue-600 dark:text-blue-400"></i>
                    Kehadiran Saya
                </h1>
                <p class="mt-2 text-slate-600 dark:text-slate-400 font-body">Lihat riwayat kehadiran Anda</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div
                    class="bg-white dark:bg-slate-800 border-l-4 border-l-green-500 dark:border-l-green-400 rounded-lg shadow-md border border-slate-200 dark:border-slate-700 p-6 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase mb-1">Total Hadir
                            </p>
                            <p class="text-4xl font-bold text-green-600 dark:text-green-400">{{ $stats['hadir'] }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Hari</p>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900/30 rounded-full p-4">
                            <i data-feather="check-circle" class="w-10 h-10 text-green-600 dark:text-green-400"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-slate-800 border-l-4 border-l-yellow-500 dark:border-l-yellow-400 rounded-lg shadow-md border border-slate-200 dark:border-slate-700 p-6 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase mb-1">Total Izin
                            </p>
                            <p class="text-4xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['izin'] }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Hari</p>
                        </div>
                        <div class="bg-yellow-100 dark:bg-yellow-900/30 rounded-full p-4">
                            <i data-feather="file-text" class="w-10 h-10 text-yellow-600 dark:text-yellow-400"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-slate-800 border-l-4 border-l-red-500 dark:border-l-red-400 rounded-lg shadow-md border border-slate-200 dark:border-slate-700 p-6 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase mb-1">Total Alpa
                            </p>
                            <p class="text-4xl font-bold text-red-600 dark:text-red-400">{{ $stats['alpa'] }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Hari</p>
                        </div>
                        <div class="bg-red-100 dark:bg-red-900/30 rounded-full p-4">
                            <i data-feather="x-circle" class="w-10 h-10 text-red-600 dark:text-red-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance History -->
            <div
                class="bg-white dark:bg-slate-800 rounded-lg shadow-md border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 dark:from-blue-600 dark:to-purple-700 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i data-feather="list" class="w-6 h-6 mr-2"></i>
                        Riwayat Kehadiran
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    @if ($attendances->count() > 0)
                        <table class="w-full">
                            <thead class="bg-slate-50 dark:bg-slate-700 border-b border-slate-200 dark:border-slate-600">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Hari
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Keterangan
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-slate-600">
                                @foreach ($attendances as $attendance)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-semibold text-gray-900">
                                                {{ $attendance->date->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm text-gray-700">
                                                {{ $attendance->date->locale('id')->isoFormat('dddd') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($attendance->status == 'hadir')
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                                    <i data-feather="check-circle" class="w-4 h-4 mr-1"></i>
                                                    Hadir
                                                </span>
                                            @elseif($attendance->status == 'izin')
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                                    <i data-feather="file-text" class="w-4 h-4 mr-1"></i>
                                                    Izin
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                                    <i data-feather="x-circle" class="w-4 h-4 mr-1"></i>
                                                    Alpa
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm text-gray-600">
                                                {{ $attendance->keterangan ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div
                            class="px-6 py-4 bg-slate-50 dark:bg-slate-700 border-t border-slate-200 dark:border-slate-600">
                            {{ $attendances->links() }}
                        </div>
                    @else
                        <div class="px-6 py-12 text-center">
                            <i data-feather="inbox" class="w-16 h-16 text-slate-400 dark:text-slate-500 mx-auto mb-4"></i>
                            <p class="text-slate-600 dark:text-slate-400 font-semibold">Belum ada data kehadiran</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Data kehadiran akan muncul setelah
                                admin mencatat absensi
                                Anda</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
