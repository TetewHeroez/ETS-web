@extends('layouts.app')

@section('title', 'Kelola Member - ETS Web')

@section('content')
    @include('components.navbar')
    @include('components.sidebar')

    <main class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-gray-50 transition-all duration-300">
        <div class="w-full py-4 px-3 md:py-6 md:px-6">
            <!-- Header -->
            <div class="mb-4 md:mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">Kelola Member</h2>
                    <p class="text-sm md:text-base text-gray-600">Manajemen user dan member sistem ETS</p>
                </div>
                @if (auth()->user()->isSuperadmin())
                    <a href="{{ route('users.create') }}"
                        class="px-4 py-2 md:px-6 md:py-3 bg-blue-700 text-white text-sm md:text-base font-semibold rounded-lg hover:bg-blue-800 transition flex items-center justify-center shadow-md">
                        <i data-feather="plus" class="w-4 h-4 md:w-5 md:h-5 mr-2"></i>
                        Tambah User
                    </a>
                @endif
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-4 md:mb-6 bg-cyan-100 border-l-4 border-cyan-500 text-cyan-800 p-3 md:p-4 rounded-lg shadow-md"
                    role="alert">
                    <div class="flex items-center">
                        <i data-feather="check-circle" class="w-4 h-4 md:w-5 md:h-5 mr-2 flex-shrink-0"></i>
                        <p class="text-sm md:text-base font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 md:mb-6 bg-red-100 border-l-4 border-red-500 text-red-800 p-3 md:p-4 rounded-lg shadow-md"
                    role="alert">
                    <div class="flex items-center">
                        <i data-feather="alert-circle" class="w-4 h-4 md:w-5 md:h-5 mr-2 flex-shrink-0"></i>
                        <p class="text-sm md:text-base font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Import Excel Section (Only for Koor SC, Koor IC, and SC) -->
            @if (in_array(auth()->user()->jabatan, ['Koor SC', 'Koor IC', 'SC']))
                <div class="bg-white rounded-lg shadow mb-4 md:mb-6 p-4 md:p-6">
                    <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-3 md:mb-4 flex items-center">
                        <i data-feather="upload" class="w-4 h-4 md:w-5 md:h-5 mr-2 text-green-600 flex-shrink-0"></i>
                        Import Data dari Excel
                    </h3>
                    <form method="POST" action="{{ route('users.import') }}" enctype="multipart/form-data"
                        class="flex flex-col md:flex-row gap-3 md:gap-4 md:items-end">
                        @csrf
                        <div class="flex-1">
                            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-2">File Excel</label>
                            <input type="file" name="file" accept=".xlsx,.xls,.csv"
                                class="w-full px-3 py-2 text-sm md:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            <p class="text-xs text-gray-500 mt-1">Format: Excel (.xlsx, .xls) atau CSV. Maksimal 2MB</p>
                        </div>
                        <div class="flex gap-2 md:gap-3">
                            <button type="submit"
                                class="flex-1 md:flex-none md:mb-5 px-4 py-2 md:px-6 md:py-3 bg-green-600 text-white text-sm md:text-base rounded-lg hover:bg-green-700 transition flex items-center justify-center">
                                <i data-feather="upload" class="w-3 h-3 md:w-4 md:h-4 mr-2"></i>
                                Import
                            </button>
                            <button type="button" onclick="showTemplate()"
                                class="flex-1 md:flex-none md:mb-5 px-4 py-2 md:px-6 md:py-3 bg-blue-600 text-white text-sm md:text-base rounded-lg hover:bg-blue-700 transition flex items-center justify-center">
                                <i data-feather="download" class="w-3 h-3 md:w-4 md:h-4 mr-2"></i>
                                Template
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Search & Filter Section -->
            <div class="bg-white rounded-lg shadow mb-4 md:mb-6 p-4 md:p-6">
                <form method="GET" action="{{ route('users.index') }}" class="flex flex-col md:flex-row gap-3 md:gap-4">
                    <div class="flex-1">
                        <label class="block text-xs md:text-sm font-medium text-gray-700 mb-2">Cari User</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau NRP..."
                            class="w-full px-3 py-2 text-sm md:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div class="w-full md:w-48">
                        <label class="block text-xs md:text-sm font-medium text-gray-700 mb-2">Filter Role</label>
                        <select name="role"
                            class="w-full px-3 py-2 text-sm md:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Role</option>
                            <option value="member" {{ request('role') == 'member' ? 'selected' : '' }}>Member</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="superadmin" {{ request('role') == 'superadmin' ? 'selected' : '' }}>Superadmin
                            </option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full md:w-auto px-4 py-2 md:px-6 md:py-3 bg-blue-600 text-white text-sm md:text-base rounded-lg hover:bg-blue-700 transition flex items-center justify-center">
                            <i data-feather="search" class="w-3 h-3 md:w-4 md:h-4 mr-2"></i>
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs md:text-sm">
                        <thead class="bg-gradient-to-r from-blue-700 to-cyan-600 text-white">
                            <tr>
                                <th
                                    class="px-3 py-2 md:px-6 md:py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    #</th>
                                <th
                                    class="px-3 py-2 md:px-6 md:py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_order' => request('sort_by') === 'name' && request('sort_order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-cyan-200 transition">
                                        Nama
                                        @if (request('sort_by') === 'name')
                                            <i data-feather="{{ request('sort_order') === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="w-3 h-3 md:w-4 md:h-4 ml-1"></i>
                                        @else
                                            <i data-feather="chevrons-up-down"
                                                class="w-3 h-3 md:w-4 md:h-4 ml-1 opacity-50"></i>
                                        @endif
                                    </a>
                                </th>
                                <th
                                    class="px-3 py-2 md:px-6 md:py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nrp', 'sort_order' => request('sort_by') === 'nrp' && request('sort_order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-cyan-200 transition">
                                        NRP
                                        @if (request('sort_by') === 'nrp')
                                            <i data-feather="{{ request('sort_order') === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="w-3 h-3 md:w-4 md:h-4 ml-1"></i>
                                        @else
                                            <i data-feather="chevrons-up-down"
                                                class="w-3 h-3 md:w-4 md:h-4 ml-1 opacity-50"></i>
                                        @endif
                                    </a>
                                </th>
                                <th
                                    class="px-3 py-2 md:px-6 md:py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'email', 'sort_order' => request('sort_by') === 'email' && request('sort_order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-cyan-200 transition">
                                        Email
                                        @if (request('sort_by') === 'email')
                                            <i data-feather="{{ request('sort_order') === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="w-3 h-3 md:w-4 md:h-4 ml-1"></i>
                                        @else
                                            <i data-feather="chevrons-up-down"
                                                class="w-3 h-3 md:w-4 md:h-4 ml-1 opacity-50"></i>
                                        @endif
                                    </a>
                                </th>
                                <th
                                    class="px-3 py-2 md:px-6 md:py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'jabatan', 'sort_order' => request('sort_by') === 'jabatan' && request('sort_order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-cyan-200 transition">
                                        Jabatan
                                        @if (request('sort_by') === 'jabatan')
                                            <i data-feather="{{ request('sort_order') === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="w-3 h-3 md:w-4 md:h-4 ml-1"></i>
                                        @else
                                            <i data-feather="chevrons-up-down"
                                                class="w-3 h-3 md:w-4 md:h-4 ml-1 opacity-50"></i>
                                        @endif
                                    </a>
                                </th>
                                @if (auth()->user()->isAdmin() || auth()->user()->isSuperadmin())
                                    <th
                                        class="px-3 py-2 md:px-6 md:py-3 text-left text-xs font-medium uppercase tracking-wider">
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'status', 'sort_order' => request('sort_by') === 'status' && request('sort_order') === 'asc' ? 'desc' : 'asc']) }}"
                                            class="flex items-center hover:text-cyan-200 transition">
                                            Status
                                            @if (request('sort_by') === 'status')
                                                <i data-feather="{{ request('sort_order') === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                    class="w-3 h-3 md:w-4 md:h-4 ml-1"></i>
                                            @else
                                                <i data-feather="chevrons-up-down"
                                                    class="w-3 h-3 md:w-4 md:h-4 ml-1 opacity-50"></i>
                                            @endif
                                        </a>
                                    </th>
                                @endif
                                <th
                                    class="px-3 py-2 md:px-6 md:py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'kelompok', 'sort_order' => request('sort_by') === 'kelompok' && request('sort_order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-cyan-200 transition">
                                        Kelompok
                                        @if (request('sort_by') === 'kelompok')
                                            <i data-feather="{{ request('sort_order') === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="w-3 h-3 md:w-4 md:h-4 ml-1"></i>
                                        @else
                                            <i data-feather="chevrons-up-down"
                                                class="w-3 h-3 md:w-4 md:h-4 ml-1 opacity-50"></i>
                                        @endif
                                    </a>
                                </th>
                                <th
                                    class="px-3 py-2 md:px-6 md:py-3 text-center text-xs font-medium uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr
                                    class="hover:bg-gray-50 {{ $user->status === 'nonaktif' ? 'bg-gray-50 opacity-60' : '' }}">
                                    <td class="px-3 py-3 md:px-6 md:py-4 whitespace-nowrap text-gray-900">
                                        {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                    </td>
                                    <td class="px-3 py-3 md:px-6 md:py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-8 w-8 md:h-10 md:w-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <i data-feather="user" class="w-4 h-4 md:w-5 md:h-5 text-blue-600"></i>
                                            </div>
                                            <div class="ml-2 md:ml-4">
                                                <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 md:px-6 md:py-4 whitespace-nowrap text-gray-900 font-mono">
                                        {{ $user->nrp ?? '-' }}
                                    </td>
                                    <td class="px-3 py-3 md:px-6 md:py-4 whitespace-nowrap text-gray-600">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-3 py-3 md:px-6 md:py-4 whitespace-nowrap">
                                        @if ($user->jabatan)
                                            @php
                                                $jabatan = $user->jabatan;
                                                $warna = match (true) {
                                                    in_array($jabatan, ['Koor SC', 'Koor IC'])
                                                        => 'bg-purple-100 text-purple-800',
                                                    in_array($jabatan, ['SC', 'IC', 'OC'])
                                                        => 'bg-blue-100 text-blue-800',
                                                    default => 'bg-cyan-100 text-cyan-800',
                                                };
                                            @endphp

                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $warna }}">
                                                {{ $jabatan }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 italic text-xs">Belum diatur</span>
                                        @endif
                                    </td>

                                    @if (auth()->user()->isAdmin() || auth()->user()->isSuperadmin())
                                        <td class="px-3 py-3 md:px-6 md:py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if ($user->status === 'aktif') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>
                                    @endif
                                    <td class="px-3 py-3 md:px-6 md:py-4 whitespace-nowrap text-gray-900">
                                        @if ($user->role === 'member' && $user->kelompok)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                <i data-feather="users" class="w-3 h-3 mr-1"></i>
                                                {{ $user->kelompok }}
                                            </span>
                                        @elseif($user->role === 'member')
                                            <span class="text-gray-400 italic text-xs">Belum ada kelompok</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 md:px-6 md:py-4 whitespace-nowrap text-center font-medium">
                                        <div class="flex items-center justify-center space-x-1 md:space-x-2">
                                            @if (auth()->user()->role === 'superadmin')
                                                <!-- Superadmin dapat edit/toggle/delete member dan admin -->
                                                <a href="{{ route('users.edit', $user) }}"
                                                    class="inline-flex items-center justify-center w-7 h-7 md:w-8 md:h-8 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200"
                                                    title="Edit User">
                                                    <i data-feather="edit-2" class="w-3 h-3 md:w-4 md:h-4"></i>
                                                </a>
                                                @if ($user->id !== auth()->id())
                                                    <button type="button"
                                                        onclick="confirmToggleStatus({{ $user->id }}, '{{ $user->name }}', '{{ $user->status }}')"
                                                        class="inline-flex items-center justify-center w-7 h-7 md:w-8 md:h-8 {{ $user->status === 'aktif' ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition-colors duration-200"
                                                        title="{{ $user->status === 'aktif' ? 'Nonaktifkan User' : 'Aktifkan User' }}">
                                                        <i data-feather="{{ $user->status === 'aktif' ? 'user-x' : 'user-check' }}"
                                                            class="w-3 h-3 md:w-4 md:h-4"></i>
                                                    </button>
                                                    <button type="button"
                                                        onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                                        class="inline-flex items-center justify-center w-7 h-7 md:w-8 md:h-8 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200"
                                                        title="Hapus User">
                                                        <i data-feather="trash-2" class="w-3 h-3 md:w-4 md:h-4"></i>
                                                    </button>
                                                @else
                                                    <span
                                                        class="inline-flex items-center justify-center w-7 h-7 md:w-8 md:h-8 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed"
                                                        title="Tidak dapat mengelola akun sendiri">
                                                        <i data-feather="shield" class="w-3 h-3 md:w-4 md:h-4"></i>
                                                    </span>
                                                @endif
                                            @elseif (auth()->user()->role === 'admin')
                                                @if ($user->role === 'member')
                                                    <!-- Admin dapat edit, toggle status dan delete member -->
                                                    <a href="{{ route('users.edit', $user) }}"
                                                        class="inline-flex items-center justify-center w-7 h-7 md:w-8 md:h-8 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200"
                                                        title="Edit Member">
                                                        <i data-feather="edit-2" class="w-3 h-3 md:w-4 md:h-4"></i>
                                                    </a>
                                                    <button type="button"
                                                        onclick="confirmToggleStatus({{ $user->id }}, '{{ $user->name }}', '{{ $user->status }}')"
                                                        class="inline-flex items-center justify-center w-7 h-7 md:w-8 md:h-8 {{ $user->status === 'aktif' ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition-colors duration-200"
                                                        title="{{ $user->status === 'aktif' ? 'Nonaktifkan Member' : 'Aktifkan Member' }}">
                                                        <i data-feather="{{ $user->status === 'aktif' ? 'user-x' : 'user-check' }}"
                                                            class="w-3 h-3 md:w-4 md:h-4"></i>
                                                    </button>
                                                    <button type="button"
                                                        onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                                        class="inline-flex items-center justify-center w-7 h-7 md:w-8 md:h-8 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200"
                                                        title="Hapus Member">
                                                        <i data-feather="trash-2" class="w-3 h-3 md:w-4 md:h-4"></i>
                                                    </button>
                                                @else
                                                    <!-- Admin tidak dapat mengelola admin/superadmin lain -->
                                                    <span
                                                        class="inline-flex items-center justify-center w-7 h-7 md:w-8 md:h-8 bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed"
                                                        title="Tidak memiliki akses untuk mengelola {{ $user->role }}">
                                                        <i data-feather="lock" class="w-3 h-3 md:w-4 md:h-4"></i>
                                                    </span>
                                                @endif
                                            @else
                                                <!-- Member tidak memiliki akses untuk mengelola user lain -->
                                                <span
                                                    class="inline-flex items-center justify-center w-7 h-7 md:w-8 md:h-8 bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed"
                                                    title="Tidak memiliki permission">
                                                    <i data-feather="eye-off" class="w-3 h-3 md:w-4 md:h-4"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->isAdmin() || auth()->user()->isSuperadmin() ? '8' : '7' }}"
                                        class="px-3 py-8 md:px-6 md:py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <i data-feather="users"
                                                class="w-12 h-12 md:w-16 md:h-16 text-gray-400 mb-3 md:mb-4"></i>
                                            <p class="text-gray-600 text-sm md:text-base">Belum ada data user</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4 md:mt-6 bg-white rounded-lg shadow p-3 md:p-4">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3">
                    <div class="pagination-wrapper flex justify-center md:justify-end">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

            <!-- Template Info Modal (Hidden by default) -->
            <div id="templateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50"
                style="display: none; align-items: center; justify-content: center;">
                <div class="bg-white p-6 rounded-lg max-w-2xl w-full mx-4">
                    <h3 class="text-lg font-semibold mb-4">Template Excel untuk Import Member</h3>
                    <div class="bg-gray-100 p-4 rounded mb-4">
                        <p class="font-semibold mb-2">Format file Excel harus memiliki header di baris pertama:</p>
                        <table class="w-full text-sm border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="border px-2 py-1">nama</th>
                                    <th class="border px-2 py-1">email</th>
                                    <th class="border px-2 py-1">nrp</th>
                                    <th class="border px-2 py-1">role</th>
                                    <th class="border px-2 py-1">kelompok</th>
                                    <th class="border px-2 py-1">tanggal_lahir</th>
                                    <th class="border px-2 py-1">password</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border px-2 py-1">Budi Santoso</td>
                                    <td class="border px-2 py-1">budi@example.com</td>
                                    <td class="border px-2 py-1">2024001</td>
                                    <td class="border px-2 py-1">member</td>
                                    <td class="border px-2 py-1">Kelompok A</td>
                                    <td class="border px-2 py-1">06/09/2006</td>
                                    <td class="border px-2 py-1">password123</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-sm text-gray-600 mb-4">
                        <p><strong>Catatan:</strong></p>
                        <ul class="list-disc list-inside">
                            <li>Kolom <code>nama</code> dan <code>email</code> wajib diisi</li>
                            <li>Kolom <code>kelompok</code> wajib diisi untuk role member</li>
                            <li>Kolom <code>role</code> default: member (bisa: member, admin, superadmin)</li>
                            <li>Kolom <code>password</code> default: password123 jika kosong</li>
                            <li>Kolom <code>nrp</code> dan <code>no_hp</code> bisa berupa angka atau teks</li>
                            <li>Format <code>tanggal_lahir</code>: DD/MM/YYYY, DD-MM-YYYY, atau DD Bulan YYYY (contoh:
                                06/09/2006, 06-09-2006, 06 September 2006)</li>
                            <li>Kolom opsional: hobi, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat_asal,
                                alamat_surabaya, nama_ortu, alamat_ortu, no_hp_ortu, no_hp
                            </li>
                        </ul>
                    </div>
                    <button onclick="hideTemplate()" class="px-4 py-2 bg-gray-600 text-white rounded">Tutup</button>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div id="deleteModal"
                class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-auto overflow-hidden">
                    <div class="p-4 md:p-6">
                        <!-- Header -->
                        <div
                            class="flex items-center justify-center w-12 h-12 md:w-16 md:h-16 bg-red-100 rounded-full mx-auto mb-3 md:mb-4">
                            <i data-feather="trash-2" class="w-6 h-6 md:w-8 md:h-8 text-red-600"></i>
                        </div>

                        <!-- Title -->
                        <h3 class="text-lg md:text-xl font-bold text-gray-900 text-center mb-2">Konfirmasi Hapus User</h3>

                        <!-- Message -->
                        <p class="text-sm md:text-base text-gray-600 text-center mb-4 md:mb-6">
                            Apakah Anda yakin ingin menghapus user <strong id="deleteUserName"
                                class="text-gray-900"></strong>?
                            <br><span class="text-xs md:text-sm text-red-600 mt-2 block">Tindakan ini tidak dapat
                                dibatalkan.</span>
                        </p>

                        <!-- Actions -->
                        <div class="flex gap-2 md:gap-3">
                            <button onclick="hideDeleteModal()"
                                class="flex-1 px-3 py-2 md:px-4 md:py-3 bg-gray-100 text-gray-700 text-sm md:text-base rounded-lg hover:bg-gray-200 transition-colors duration-200 font-medium">
                                <i data-feather="x" class="w-3 h-3 md:w-4 md:h-4 inline mr-2"></i>
                                Batal
                            </button>
                            <button onclick="executeDelete()"
                                class="flex-1 px-3 py-2 md:px-4 md:py-3 bg-red-600 text-white text-sm md:text-base rounded-lg hover:bg-red-700 transition-colors duration-200 font-medium">
                                <i data-feather="trash-2" class="w-3 h-3 md:w-4 md:h-4 inline mr-2"></i>
                                Hapus User
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Toggle Status Confirmation Modal -->
            <div id="toggleStatusModal"
                class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-auto overflow-hidden">
                    <div class="p-4 md:p-6">
                        <!-- Header -->
                        <div id="toggleStatusIconWrapper"
                            class="flex items-center justify-center w-12 h-12 md:w-16 md:h-16 rounded-full mx-auto mb-3 md:mb-4">
                            <i id="toggleStatusIcon" class="w-6 h-6 md:w-8 md:h-8"></i>
                        </div>

                        <!-- Title -->
                        <h3 id="toggleStatusTitle" class="text-lg md:text-xl font-bold text-gray-900 text-center mb-2">
                        </h3>

                        <!-- Message -->
                        <p class="text-sm md:text-base text-gray-600 text-center mb-4 md:mb-6">
                            Apakah Anda yakin ingin <strong id="toggleStatusAction"></strong> user <strong
                                id="toggleStatusUserName" class="text-gray-900"></strong>?
                        </p>

                        <!-- Actions -->
                        <div class="flex gap-2 md:gap-3">
                            <button onclick="hideToggleStatusModal()"
                                class="flex-1 px-3 py-2 md:px-4 md:py-3 bg-gray-100 text-gray-700 text-sm md:text-base rounded-lg hover:bg-gray-200 transition-colors duration-200 font-medium">
                                <i data-feather="x" class="w-3 h-3 md:w-4 md:h-4 inline mr-2"></i>
                                Batal
                            </button>
                            <button id="executeToggleButton" onclick="executeToggleStatus()"
                                class="flex-1 px-3 py-2 md:px-4 md:py-3 text-white text-sm md:text-base rounded-lg transition-colors duration-200 font-medium">
                                <i id="toggleButtonIcon" class="w-3 h-3 md:w-4 md:h-4 inline mr-2"></i>
                                <span id="toggleButtonText"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hidden Delete Form -->
            <form id="deleteForm" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>

            <!-- Hidden Toggle Status Form -->
            <form id="toggleStatusForm" method="POST" style="display: none;">
                @csrf
                @method('PATCH')
            </form>
        </div>
        </div>

        <script>
            let deleteUserId = null;
            let toggleStatusUserId = null;

            function showTemplate() {
                const modal = document.getElementById('templateModal');
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            }

            function hideTemplate() {
                const modal = document.getElementById('templateModal');
                modal.classList.add('hidden');
                modal.style.display = 'none';
            }

            function confirmDelete(userId, userName) {
                deleteUserId = userId;
                document.getElementById('deleteUserName').textContent = userName;
                const modal = document.getElementById('deleteModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                // Re-initialize feather icons in modal
                feather.replace();
            }

            function hideDeleteModal() {
                const modal = document.getElementById('deleteModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                deleteUserId = null;
            }

            function executeDelete() {
                if (!deleteUserId) return;

                const form = document.getElementById('deleteForm');
                form.action = `/users/${deleteUserId}`;
                form.submit();
            }

            function confirmToggleStatus(userId, userName, currentStatus) {
                toggleStatusUserId = userId;
                document.getElementById('toggleStatusUserName').textContent = userName;

                const modal = document.getElementById('toggleStatusModal');
                const iconWrapper = document.getElementById('toggleStatusIconWrapper');
                const icon = document.getElementById('toggleStatusIcon');
                const title = document.getElementById('toggleStatusTitle');
                const action = document.getElementById('toggleStatusAction');
                const button = document.getElementById('executeToggleButton');
                const buttonIcon = document.getElementById('toggleButtonIcon');
                const buttonText = document.getElementById('toggleButtonText');

                if (currentStatus === 'aktif') {
                    // Akan nonaktifkan
                    iconWrapper.className =
                        'flex items-center justify-center w-12 h-12 md:w-16 md:h-16 bg-orange-100 rounded-full mx-auto mb-3 md:mb-4';
                    icon.setAttribute('data-feather', 'user-x');
                    icon.className = 'w-6 h-6 md:w-8 md:h-8 text-orange-600';
                    title.textContent = 'Nonaktifkan User';
                    action.textContent = 'menonaktifkan';
                    button.className =
                        'flex-1 px-3 py-2 md:px-4 md:py-3 bg-orange-600 hover:bg-orange-700 text-white text-sm md:text-base rounded-lg transition-colors duration-200 font-medium';
                    buttonIcon.setAttribute('data-feather', 'user-x');
                    buttonText.textContent = 'Nonaktifkan';
                } else {
                    // Akan aktifkan
                    iconWrapper.className =
                        'flex items-center justify-center w-12 h-12 md:w-16 md:h-16 bg-green-100 rounded-full mx-auto mb-3 md:mb-4';
                    icon.setAttribute('data-feather', 'user-check');
                    icon.className = 'w-6 h-6 md:w-8 md:h-8 text-green-600';
                    title.textContent = 'Aktifkan User';
                    action.textContent = 'mengaktifkan';
                    button.className =
                        'flex-1 px-3 py-2 md:px-4 md:py-3 bg-green-600 hover:bg-green-700 text-white text-sm md:text-base rounded-lg transition-colors duration-200 font-medium';
                    buttonIcon.setAttribute('data-feather', 'user-check');
                    buttonText.textContent = 'Aktifkan';
                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');

                // Re-initialize feather icons in modal
                feather.replace();
            }

            function hideToggleStatusModal() {
                const modal = document.getElementById('toggleStatusModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                toggleStatusUserId = null;
            }

            function executeToggleStatus() {
                if (!toggleStatusUserId) return;

                const form = document.getElementById('toggleStatusForm');
                form.action = `/users/${toggleStatusUserId}/toggle-status`;
                form.submit();
            }

            // Close modals when clicking outside
            document.addEventListener('click', function(event) {
                const templateModal = document.getElementById('templateModal');
                const deleteModal = document.getElementById('deleteModal');
                const toggleStatusModal = document.getElementById('toggleStatusModal');

                if (event.target === templateModal) {
                    hideTemplate();
                }

                if (event.target === deleteModal) {
                    hideDeleteModal();
                }

                if (event.target === toggleStatusModal) {
                    hideToggleStatusModal();
                }
            });

            // Close modals with Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    hideTemplate();
                    hideDeleteModal();
                    hideToggleStatusModal();
                }
            });

            // Initialize Feather icons
            feather.replace();
        </script>

        <style>
            /* ================================
                   Elegant Pagination Styling
                   ================================ */
            .pagination-wrapper nav {
                background: transparent !important;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            /* Container */
            .pagination-wrapper .flex {
                background: white !important;
                border-radius: 0.75rem !important;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                padding: 0.25rem !important;
                gap: 0.125rem;
            }

            /* Buttons and links */
            .pagination-wrapper a,
            .pagination-wrapper span {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 0.875rem;
                font-weight: 500;
                min-width: 2rem;
                height: 2rem;
                border-radius: 0.5rem;
                border: 1px solid transparent;
                color: #374151;
                background-color: white;
                transition: all 0.2s ease;
                text-decoration: none !important;
            }

            /* Hover state */
            .pagination-wrapper a:hover {
                background-color: #f9fafb;
                color: #111827;
                border-color: #e5e7eb;
                transform: translateY(-1px);
            }

            /* Active/current page */
            .pagination-wrapper span[aria-current="page"] {
                background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
                color: white;
                font-weight: 600;
                border: none;
                box-shadow: 0 2px 5px rgba(37, 99, 235, 0.25);
                transform: scale(1.05);
            }

            /* Disabled state (for prev/next when inactive) */
            .pagination-wrapper span[aria-disabled="true"] {
                opacity: 0.4;
                cursor: not-allowed;
                background-color: #f3f4f6;
                color: #9ca3af;
                border: 1px solid #e5e7eb;
            }

            /* Previous/Next buttons */
            .pagination-wrapper a[rel="prev"],
            .pagination-wrapper a[rel="next"],
            .pagination-wrapper span[rel="prev"],
            .pagination-wrapper span[rel="next"] {
                font-weight: 500;
                padding: 0 0.75rem;
                border-radius: 0.5rem;
            }

            /* Smooth transitions for all */
            .pagination-wrapper * {
                transition: all 0.2s ease-in-out;
            }

            /* Lighten dark themes */
            .pagination-wrapper .bg-gray-800,
            .pagination-wrapper .bg-gray-900,
            .pagination-wrapper .text-gray-500 {
                background-color: white !important;
                color: #374151 !important;
            }
        </style>

    @endsection
