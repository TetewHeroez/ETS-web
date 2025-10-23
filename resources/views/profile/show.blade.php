@extends('layouts.app')

@section('title', 'Profil Saya - ETS Web')

@section('content')
    <!-- Navbar Top -->
    @include('components.navbar')

    <!-- Sidebar -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div
        class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-slate-50 dark:bg-slate-900 transition-all duration-300">
        <div class="max-w-5xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-heading font-bold text-slate-900 dark:text-slate-100 flex items-center">
                        <i data-feather="user" class="w-8 h-8 mr-3 text-blue-700 dark:text-blue-400"></i>
                        Profil Saya
                    </h1>
                    <p class="mt-2 text-slate-600 dark:text-slate-400 font-body">Informasi lengkap profil Anda</p>
                </div>
                <a href="{{ route('profile.edit') }}"
                    class="px-6 py-3 bg-blue-700 dark:bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-800 dark:hover:bg-blue-700 transition-colors duration-300 flex items-center shadow-md">
                    <i data-feather="edit-2" class="w-5 h-5 mr-2"></i>
                    Edit Profil
                </a>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-cyan-100 dark:bg-cyan-900/30 border-l-4 border-l-cyan-500 dark:border-l-cyan-400 text-cyan-800 dark:text-cyan-300 p-4 rounded-lg shadow-md border border-cyan-200 dark:border-cyan-700 transition-colors duration-300"
                    role="alert">
                    <div class="flex items-center">
                        <i data-feather="check-circle" class="w-5 h-5 mr-2 text-cyan-600 dark:text-cyan-400"></i>
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Profile Card -->
            <div
                class="bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                <!-- Header Section with Gradient -->
                <div class="bg-gradient-to-r from-blue-700 to-cyan-600 dark:from-blue-800 dark:to-cyan-700 px-8 py-6">
                    <div class="flex items-center">
                        <div
                            class="h-24 w-24 bg-white dark:bg-slate-100 rounded-full flex items-center justify-center shadow-lg">
                            <i data-feather="user" class="w-12 h-12 text-blue-700 dark:text-blue-600"></i>
                        </div>
                        <div class="ml-6">
                            <h2 class="text-2xl font-heading font-bold text-white">{{ $user->name }}</h2>
                            <p class="text-blue-100 dark:text-blue-200 text-sm mt-1">{{ ucfirst($user->role) }}</p>
                            <p class="text-white font-mono text-sm mt-1">NRP: {{ $user->nrp ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Profile Content -->
                <div class="p-8">

                    @if ($user->role === 'member')
                        <!-- TAMPILAN LENGKAP UNTUK MEMBER -->

                        <!-- Data Pribadi -->
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center border-b pb-2">
                                <i data-feather="user-check" class="w-6 h-6 mr-2 text-blue-700"></i>
                                Data Dasar
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                                    <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
                                    <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">NRP</label>
                                    <p class="text-gray-900 font-medium font-mono">{{ $user->nrp ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nomor HP</label>
                                    <p class="text-gray-900 font-medium">{{ $user->no_hp ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Kelompok</label>
                                    <p class="text-gray-900 font-medium">{{ $user->kelompok ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Hobi</label>
                                    <p class="text-gray-900 font-medium">{{ $user->hobi ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Data Pribadi Detail -->
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center border-b pb-2">
                                <i data-feather="user" class="w-6 h-6 mr-2 text-blue-700"></i>
                                Data Pribadi
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Jenis Kelamin</label>
                                    <p class="text-gray-900 font-medium">{{ $user->jenis_kelamin ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Golongan Darah</label>
                                    <p class="text-gray-900 font-medium">{{ $user->golongan_darah ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Tempat Lahir</label>
                                    <p class="text-gray-900 font-medium">{{ $user->tempat_lahir ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Tanggal Lahir</label>
                                    <p class="text-gray-900 font-medium">
                                        {{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d F Y') : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Data Alamat -->
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center border-b pb-2">
                                <i data-feather="map-pin" class="w-6 h-6 mr-2 text-cyan-600"></i>
                                Data Alamat
                            </h3>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Alamat Asal</label>
                                    <p class="text-gray-900 font-medium">{{ $user->alamat_asal ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Alamat di Surabaya</label>
                                    <p class="text-gray-900 font-medium">{{ $user->alamat_surabaya ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Data Orang Tua/Wali -->
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center border-b pb-2">
                                <i data-feather="users" class="w-6 h-6 mr-2 text-slate-600"></i>
                                Data Orang Tua/Wali
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Orang
                                        Tua/Wali</label>
                                    <p class="text-gray-900 font-medium">{{ $user->nama_ortu ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nomor HP Orang Tua</label>
                                    <p class="text-gray-900 font-medium">{{ $user->no_hp_ortu ?? '-' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Alamat Orang Tua</label>
                                    <p class="text-gray-900 font-medium">{{ $user->alamat_ortu ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Data Kesehatan -->
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center border-b pb-2">
                                <i data-feather="heart" class="w-6 h-6 mr-2 text-cyan-500"></i>
                                Data Kesehatan
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Alergi</label>
                                    <p class="text-gray-900 font-medium">{{ $user->alergi ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Riwayat Penyakit</label>
                                    <p class="text-gray-900 font-medium">{{ $user->riwayat_penyakit ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- TAMPILAN TERBATAS UNTUK ADMIN & SUPERADMIN -->

                        <!-- Data Profil -->
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center border-b pb-2">
                                <i data-feather="user-check" class="w-6 h-6 mr-2 text-blue-700"></i>
                                Data Profil
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                                    <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
                                    <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">NRP</label>
                                    <p class="text-gray-900 font-medium font-mono">{{ $user->nrp ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nomor HP</label>
                                    <p class="text-gray-900 font-medium">{{ $user->no_hp ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="bg-blue-50 rounded-lg p-6">
                            <h4 class="text-lg font-bold text-blue-900 mb-4 flex items-center">
                                <i data-feather="info" class="w-5 h-5 mr-2"></i>
                                Informasi Jabatan
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-blue-700 mb-1">Role</label>
                                    <div
                                        class="inline-flex px-3 py-1 rounded-full text-sm font-semibold
                                        {{ $user->role === 'superadmin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-blue-700 mb-1">Jabatan</label>
                                    <div
                                        class="inline-flex px-3 py-1 rounded-full text-sm font-semibold
                                        {{ in_array($user->jabatan, ['Koor SC', 'Koor IC']) ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $user->jabatan ?? '-' }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-blue-700 mb-1">Status</label>
                                    <div
                                        class="inline-flex px-3 py-1 rounded-full text-sm font-semibold
                                        {{ $user->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($user->status) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
@endsection
