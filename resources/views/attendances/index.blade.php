@extends('layouts.app')

@section('title', 'Kelola Absensi - ETS Web')

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
                    <i data-feather="user-check" class="w-8 h-8 mr-3 text-blue-600"></i>
                    Kelola Absensi Kehadiran
                </h1>
                <p class="mt-2 text-gray-600">Catat kehadiran, izin, dan ketidakhadiran member</p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
                    <div class="flex items-center">
                        <i data-feather="check-circle" class="w-5 h-5 mr-2"></i>
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Date Filter -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <form action="{{ route('attendances.index') }}" method="GET" class="flex items-center gap-4">
                    <div class="flex-1">
                        <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i data-feather="calendar" class="w-4 h-4 inline mr-1"></i>
                            Pilih Tanggal
                        </label>
                        <input type="date" name="date" id="date" value="{{ $date }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>
                    <div class="pt-7">
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition flex items-center">
                            <i data-feather="search" class="w-4 h-4 mr-2"></i>
                            Lihat Absensi
                        </button>
                    </div>
                </form>
            </div>

            <!-- Attendance Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-blue-700 to-cyan-600 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase">No</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Nama Member</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase">NRP</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold uppercase">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Keterangan</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($users as $index => $user)
                                @php
                                    $attendance = $attendances->get($user->id);
                                    $status = $attendance ? $attendance->status : 'alpa';
                                    $keterangan = $attendance ? $attendance->keterangan : '';
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 font-mono">{{ $user->nrp }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('attendances.update') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <input type="hidden" name="date" value="{{ $date }}">
                                            <input type="hidden" name="keterangan" value="{{ $keterangan }}"
                                                class="keterangan-input-{{ $user->id }}">

                                            <select name="status" onchange="this.form.submit()"
                                                class="px-4 py-2 rounded-full text-sm font-semibold focus:ring-2 focus:ring-offset-2 transition
                                                @if ($status == 'hadir') bg-green-100 text-green-800 focus:ring-green-500
                                                @elseif($status == 'izin') bg-yellow-100 text-yellow-800 focus:ring-yellow-500
                                                @else bg-red-100 text-red-800 focus:ring-red-500 @endif">
                                                <option value="hadir" {{ $status == 'hadir' ? 'selected' : '' }}>✓ Hadir
                                                </option>
                                                <option value="izin" {{ $status == 'izin' ? 'selected' : '' }}>📋 Izin
                                                </option>
                                                <option value="alpa" {{ $status == 'alpa' ? 'selected' : '' }}>✗ Alpa
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text"
                                            class="w-full px-3 py-1 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Tambah keterangan..." value="{{ $keterangan }}"
                                            onchange="updateKeterangan({{ $user->id }}, this.value)">
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button onclick="submitAttendance({{ $user->id }}, '{{ $date }}')"
                                            class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">
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

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-green-800 uppercase">Hadir</p>
                            <p class="text-3xl font-bold text-green-900 mt-2">
                                {{ $attendances->where('status', 'hadir')->count() }}
                            </p>
                        </div>
                        <i data-feather="check-circle" class="w-12 h-12 text-green-500"></i>
                    </div>
                </div>

                <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-yellow-800 uppercase">Izin</p>
                            <p class="text-3xl font-bold text-yellow-900 mt-2">
                                {{ $attendances->where('status', 'izin')->count() }}
                            </p>
                        </div>
                        <i data-feather="file-text" class="w-12 h-12 text-yellow-500"></i>
                    </div>
                </div>

                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-red-800 uppercase">Alpa</p>
                            <p class="text-3xl font-bold text-red-900 mt-2">
                                {{ $users->count() - $attendances->whereIn('status', ['hadir', 'izin'])->count() }}
                            </p>
                        </div>
                        <i data-feather="x-circle" class="w-12 h-12 text-red-500"></i>
                    </div>
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
