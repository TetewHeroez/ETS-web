@extends('layouts.app')

@section('title', 'Kelola Absensi - MyHIMATIKA')

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
                    <i data-feather="user-check" class="w-8 h-8 mr-3 text-blue-600 dark:text-blue-400"></i>
                    Kelola Absensi Kehadiran
                </h1>
                <p class="mt-2 text-slate-600 dark:text-slate-400 font-body">Catat kehadiran, izin, dan ketidakhadiran member
                </p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 dark:bg-green-900 border-l-4 border-green-500 dark:border-green-400 text-green-700 dark:text-green-300 p-4 rounded-lg transition-colors duration-300"
                    role="alert">
                    <div class="flex items-center">
                        <i data-feather="check-circle" class="w-5 h-5 mr-2"></i>
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Date Filter -->
            <div
                class="bg-white dark:bg-slate-800 rounded-lg shadow-md border border-slate-200 dark:border-slate-700 p-6 mb-6 transition-colors duration-300">
                <form action="{{ route('attendances.index') }}" method="GET" class="flex items-center gap-4">
                    <div class="flex-1">
                        <label for="date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i data-feather="calendar" class="w-4 h-4 inline mr-1"></i>
                            Pilih Tanggal
                        </label>
                        <input type="date" name="date" id="date" value="{{ $date }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500"
                            required>
                    </div>
                    <div class="pt-7">
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 dark:bg-blue-700 text-white font-semibold rounded-lg hover:bg-blue-700 dark:hover:bg-blue-800 transition flex items-center shadow-md">
                            <i data-feather="search" class="w-4 h-4 mr-2"></i>
                            Lihat Absensi
                        </button>
                    </div>
                </form>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 mb-6">
                <div
                    class="bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 dark:border-green-400 rounded-lg p-6 transition-colors duration-300 shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-green-800 dark:text-green-300 uppercase">Hadir</p>
                            <p class="text-3xl font-bold text-green-900 dark:text-green-200 mt-2">
                                {{ $attendances->where('status', 'hadir')->count() }}
                            </p>
                        </div>
                        <i data-feather="check-circle" class="w-12 h-12 text-green-500 dark:text-green-400"></i>
                    </div>
                </div>

                <div
                    class="bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-500 dark:border-yellow-400 rounded-lg p-6 transition-colors duration-300 shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-yellow-800 dark:text-yellow-300 uppercase">Izin</p>
                            <p class="text-3xl font-bold text-yellow-900 dark:text-yellow-200 mt-2">
                                {{ $attendances->where('status', 'izin')->count() }}
                            </p>
                        </div>
                        <i data-feather="file-text" class="w-12 h-12 text-yellow-500 dark:text-yellow-400"></i>
                    </div>
                </div>

                <div
                    class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 dark:border-red-400 rounded-lg p-6 transition-colors duration-300 shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-red-800 dark:text-red-300 uppercase">Alpa</p>
                            <p class="text-3xl font-bold text-red-900 dark:text-red-200 mt-2">
                                {{ $users->count() - $attendances->whereIn('status', ['hadir', 'izin'])->count() }}
                            </p>
                        </div>
                        <i data-feather="x-circle" class="w-12 h-12 text-red-500 dark:text-red-400"></i>
                    </div>
                </div>
            </div>

            <!-- Attendance Table -->
            <div
                class="bg-white dark:bg-slate-800 rounded-lg shadow-md border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead
                            class="bg-gradient-to-r from-blue-700 to-cyan-600 dark:from-blue-800 dark:to-cyan-700 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase">No</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase">
                                    <a href="{{ route('attendances.index', ['date' => $date, 'sort_by' => 'name', 'sort_order' => $sortBy === 'name' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-cyan-200 dark:hover:text-cyan-300 transition">
                                        Nama Member
                                        @if ($sortBy === 'name')
                                            <i data-feather="{{ $sortOrder === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="w-4 h-4 ml-1"></i>
                                        @else
                                            <i data-feather="chevrons-up-down" class="w-4 h-4 ml-1 opacity-50"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase">
                                    <a href="{{ route('attendances.index', ['date' => $date, 'sort_by' => 'nrp', 'sort_order' => $sortBy === 'nrp' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-cyan-200 dark:hover:text-cyan-300 transition">
                                        NRP
                                        @if ($sortBy === 'nrp')
                                            <i data-feather="{{ $sortOrder === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="w-4 h-4 ml-1"></i>
                                        @else
                                            <i data-feather="chevrons-up-down" class="w-4 h-4 ml-1 opacity-50"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-4 text-center text-sm font-semibold uppercase">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Keterangan</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            @foreach ($users as $index => $user)
                                @php
                                    $attendance = $attendances->get($user->id);
                                    $status = $attendance ? $attendance->status : 'alpa';
                                    $keterangan = $attendance ? $attendance->keterangan : '';
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 font-mono">
                                        {{ $user->nrp }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('attendances.update') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <input type="hidden" name="date" value="{{ $date }}">
                                            <input type="hidden" name="keterangan" value="{{ $keterangan }}"
                                                class="keterangan-input-{{ $user->id }}">

                                            <select name="status" onchange="this.form.submit()"
                                                class="custom-select-chevron px-4 py-2 rounded-full text-sm font-semibold focus:ring-2 focus:ring-offset-2 transition border-0 appearance-none cursor-pointer inline-flex items-center justify-center
    {{ $status == 'hadir'
        ? 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300 focus:ring-green-500'
        : ($status == 'izin'
            ? 'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300 focus:ring-yellow-500'
            : 'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300 focus:ring-red-500') }}">
                                                <option value="hadir" {{ $status == 'hadir' ? 'selected' : '' }}
                                                    class="bg-green-100 dark:bg-green-900">✅ Hadir
                                                </option>
                                                <option value="izin" {{ $status == 'izin' ? 'selected' : '' }}
                                                    class="bg-yellow-100 dark:bg-yellow-900">📋 Izin
                                                </option>
                                                <option value="alpa" {{ $status == 'alpa' ? 'selected' : '' }}
                                                    class="bg-red-100 dark:bg-red-900">❌ Alpa
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text"
                                            class="w-full px-3 py-1 text-sm border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500"
                                            placeholder="Tambah keterangan..." value="{{ $keterangan }}"
                                            onchange="updateKeterangan({{ $user->id }}, this.value)">
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button onclick="submitAttendance({{ $user->id }}, '{{ $date }}')"
                                            class="px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 dark:hover:bg-blue-800 transition shadow-md">
                                            <i data-feather="save" class="w-4 h-4 inline mr-1"></i>
                                            Simpan
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        function updateKeterangan(userId, value) {
            const input = document.querySelector('.keterangan-input-' + userId);
            if (input) {
                input.value = value;
            }
        }

        function submitAttendance(userId, date) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('attendances.update') }}';

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';

            const userIdInput = document.createElement('input');
            userIdInput.type = 'hidden';
            userIdInput.name = 'user_id';
            userIdInput.value = userId;

            const dateInput = document.createElement('input');
            dateInput.type = 'hidden';
            dateInput.name = 'date';
            dateInput.value = date;

            const statusSelect = document.querySelector('.keterangan-input-' + userId).closest('tr').querySelector(
                'select[name="status"]');
            const statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'status';
            statusInput.value = statusSelect.value;

            const keteranganInput = document.createElement('input');
            keteranganInput.type = 'hidden';
            keteranganInput.name = 'keterangan';
            keteranganInput.value = document.querySelector('.keterangan-input-' + userId).value;

            form.appendChild(csrf);
            form.appendChild(userIdInput);
            form.appendChild(dateInput);
            form.appendChild(statusInput);
            form.appendChild(keteranganInput);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
@endsection
