@extends('layouts.app')

@section('title', 'Kehadiran Saya - ETS Web')

@section('content')
    <!-- Navbar Top -->
    @include('components.navbar')

    <!-- Sidebar -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="main-content-wrapper ml-64 mt-16 min-h-screen bg-gray-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i data-feather="calendar" class="w-8 h-8 mr-3 text-blue-600"></i>
                    Kehadiran Saya
                </h1>
                <p class="mt-2 text-gray-600">Lihat riwayat kehadiran Anda</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white border-l-4 border-green-500 rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 uppercase mb-1">Total Hadir</p>
                            <p class="text-4xl font-bold text-green-600">{{ $stats['hadir'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Hari</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-4">
                            <i data-feather="check-circle" class="w-10 h-10 text-green-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white border-l-4 border-yellow-500 rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 uppercase mb-1">Total Izin</p>
                            <p class="text-4xl font-bold text-yellow-600">{{ $stats['izin'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Hari</p>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-4">
                            <i data-feather="file-text" class="w-10 h-10 text-yellow-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white border-l-4 border-red-500 rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 uppercase mb-1">Total Alpa</p>
                            <p class="text-4xl font-bold text-red-600">{{ $stats['alpa'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Hari</p>
                        </div>
                        <div class="bg-red-100 rounded-full p-4">
                            <i data-feather="x-circle" class="w-10 h-10 text-red-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance History -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i data-feather="list" class="w-6 h-6 mr-2"></i>
                        Riwayat Kehadiran
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    @if ($attendances->count() > 0)
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
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
                            <tbody class="divide-y divide-gray-200">
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
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            {{ $attendances->links() }}
                        </div>
                    @else
                        <div class="px-6 py-12 text-center">
                            <i data-feather="inbox" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                            <p class="text-gray-600 font-semibold">Belum ada data kehadiran</p>
                            <p class="text-sm text-gray-500 mt-1">Data kehadiran akan muncul setelah admin mencatat absensi
                                Anda</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
