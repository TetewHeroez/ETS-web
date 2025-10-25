@extends('layouts.app')

@section('title', 'Edit Profil - MyHIMATIKA')

@push('scripts')
    <script src="{{ asset('js/profile-upload.js') }}" defer></script>
@endpush

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
            <div class="mb-6">
                <h1 class="text-3xl font-heading font-bold text-slate-900 dark:text-slate-100 flex items-center">
                    <i data-feather="edit-2" class="w-8 h-8 mr-3 text-blue-700 dark:text-blue-400"></i>
                    Edit Profil
                </h1>
                <p class="mt-2 text-slate-600 dark:text-slate-400 font-body">Perbarui informasi profil Anda</p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 dark:bg-green-900/30 border-l-4 border-l-green-500 dark:border-l-green-400 text-green-700 dark:text-green-300 p-4 rounded-lg border border-green-200 dark:border-green-700 transition-colors duration-300"
                    role="alert">
                    <div class="flex items-center">
                        <i data-feather="check-circle" class="w-5 h-5 mr-2 text-green-600 dark:text-green-400"></i>
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div
                    class="bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors duration-300">

                    @if ($user->role === 'member')
                        <!-- FORM LENGKAP UNTUK MEMBER -->

                        <!-- Data Dasar -->
                        <div class="p-8 border-b border-slate-200 dark:border-slate-700">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-6 flex items-center">
                                <i data-feather="user-check" class="w-6 h-6 mr-2 text-blue-700 dark:text-blue-400"></i>
                                Data Dasar
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Foto Profil -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Foto
                                        Profil</label>
                                    <div class="flex items-center gap-4">
                                        @if (
                                            $user->profile_photo &&
                                                (str_starts_with($user->profile_photo, 'http://') || str_starts_with($user->profile_photo, 'https://')))
                                            <img src="{{ $user->profile_photo }}" alt="Profile"
                                                class="w-20 h-20 rounded-full object-cover border-2 border-slate-300 dark:border-slate-600"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div
                                                class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-600 to-cyan-500 hidden items-center justify-center text-white font-bold text-2xl">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @else
                                            {{-- Fallback avatar --}}
                                            <div
                                                class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center text-white font-bold text-2xl">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <input type="file" name="profile_photo" id="profile_photo_member"
                                                accept="image/*"
                                                class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 dark:bg-slate-700 dark:text-slate-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-slate-600 dark:file:text-slate-200 dark:hover:file:bg-slate-500"
                                                onchange="validateAndPreviewFile(this, 'member')">
                                            <p id="file-info-member"
                                                class="text-xs text-slate-500 dark:text-slate-400 mt-1">JPG, PNG, atau GIF
                                                (max 2MB)</p>
                                        </div>
                                    </div>
                                    @error('profile_photo')
                                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                            <i data-feather="alert-circle" class="w-4 h-4"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nama
                                        Lengkap *</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100">
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Email
                                        *</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100">
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">NRP</label>
                                    <input type="text" name="nrp" value="{{ old('nrp', $user->nrp) }}"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100 font-mono">
                                    @error('nrp')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nomor
                                        HP</label>
                                    <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100"
                                        placeholder="08xxxxxxxxxx">
                                    @error('no_hp')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Kelompok</label>
                                    <input type="text" name="kelompok" value="{{ old('kelompok', $user->kelompok) }}"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100">
                                    @error('kelompok')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Hobi</label>
                                    <input type="text" name="hobi" value="{{ old('hobi', $user->hobi) }}"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100">
                                    @error('hobi')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Data Pribadi -->
                        <div class="p-8 border-b border-slate-200 dark:border-slate-700">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-6 flex items-center">
                                <i data-feather="user" class="w-6 h-6 mr-2 text-blue-700 dark:text-blue-400"></i>
                                Data Pribadi
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Jenis
                                        Kelamin</label>
                                    <select name="jenis_kelamin"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki"
                                            {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="Perempuan"
                                            {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Golongan
                                        Darah</label>
                                    <select name="golongan_darah"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100">
                                        <option value="">Pilih Golongan Darah</option>
                                        <option value="A"
                                            {{ old('golongan_darah', $user->golongan_darah) == 'A' ? 'selected' : '' }}>A
                                        </option>
                                        <option value="B"
                                            {{ old('golongan_darah', $user->golongan_darah) == 'B' ? 'selected' : '' }}>B
                                        </option>
                                        <option value="AB"
                                            {{ old('golongan_darah', $user->golongan_darah) == 'AB' ? 'selected' : '' }}>AB
                                        </option>
                                        <option value="O"
                                            {{ old('golongan_darah', $user->golongan_darah) == 'O' ? 'selected' : '' }}>O
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Tempat
                                        Lahir</label>
                                    <input type="text" name="tempat_lahir"
                                        value="{{ old('tempat_lahir', $user->tempat_lahir) }}"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100">
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Tanggal
                                        Lahir</label>
                                    <input type="date" name="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100">
                                </div>
                            </div>
                        </div>

                        <!-- Data Alamat -->
                        <div class="p-8 border-b border-slate-200 dark:border-slate-700">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-6 flex items-center">
                                <i data-feather="map-pin" class="w-6 h-6 mr-2 text-cyan-600 dark:text-cyan-400"></i>
                                Data Alamat
                            </h3>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Alamat
                                        Asal</label>
                                    <textarea name="alamat_asal" rows="3"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100">{{ old('alamat_asal', $user->alamat_asal) }}</textarea>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Alamat
                                        di
                                        Surabaya</label>
                                    <textarea name="alamat_surabaya" rows="3"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100">{{ old('alamat_surabaya', $user->alamat_surabaya) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Data Orang Tua/Wali -->
                        <div class="p-8 border-b border-slate-200 dark:border-slate-700">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-6 flex items-center">
                                <i data-feather="users" class="w-6 h-6 mr-2 text-slate-600 dark:text-slate-400"></i>
                                Data Orang Tua/Wali
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nama
                                        Orang
                                        Tua/Wali</label>
                                    <input type="text" name="nama_ortu"
                                        value="{{ old('nama_ortu', $user->nama_ortu) }}"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100">
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nomor
                                        HP Orang
                                        Tua</label>
                                    <input type="text" name="no_hp_ortu"
                                        value="{{ old('no_hp_ortu', $user->no_hp_ortu) }}"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100">
                                </div>

                                <div class="md:col-span-2">
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Alamat
                                        Orang Tua</label>
                                    <textarea name="alamat_ortu" rows="3"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100">{{ old('alamat_ortu', $user->alamat_ortu) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Data Kesehatan -->
                        <div class="p-8 border-b border-slate-200 dark:border-slate-700">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-6 flex items-center">
                                <i data-feather="heart" class="w-6 h-6 mr-2 text-cyan-500 dark:text-cyan-400"></i>
                                Data Kesehatan
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Alergi</label>
                                    <textarea name="alergi" rows="3"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100"
                                        placeholder="Contoh: Alergi seafood, debu, dll">{{ old('alergi', $user->alergi) }}</textarea>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Riwayat
                                        Penyakit</label>
                                    <textarea name="riwayat_penyakit" rows="3"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100"
                                        placeholder="Contoh: Asma, diabetes, dll">{{ old('riwayat_penyakit', $user->riwayat_penyakit) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Ubah Password -->
                        <div class="p-8 border-b bg-gray-50">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i data-feather="lock" class="w-6 h-6 mr-2 text-red-600"></i>
                                Ubah Password (Opsional)
                            </h3>
                            <p class="text-sm text-gray-600 mb-4">Kosongkan jika tidak ingin mengubah password</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                                    <input type="password" name="password"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Minimal 8 karakter">
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi
                                        Password</label>
                                    <input type="password" name="password_confirmation"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- FORM TERBATAS UNTUK ADMIN & SUPERADMIN -->

                        <div class="p-8 border-b border-slate-200 dark:border-slate-700">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-6 flex items-center">
                                <i data-feather="user-check" class="w-6 h-6 mr-2 text-blue-700 dark:text-blue-400"></i>
                                Data Profil
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">Sebagai {{ ucfirst($user->role) }},
                                Anda hanya dapat
                                mengedit data berikut:</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Foto Profil -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Foto
                                        Profil</label>
                                    <div class="flex items-center gap-4">
                                        @if (
                                            $user->profile_photo &&
                                                (str_starts_with($user->profile_photo, 'http://') || str_starts_with($user->profile_photo, 'https://')))
                                            <img src="{{ $user->profile_photo }}" alt="Profile"
                                                class="w-20 h-20 rounded-full object-cover border-2 border-slate-300 dark:border-slate-600"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div
                                                class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-600 to-cyan-500 hidden items-center justify-center text-white font-bold text-2xl">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @else
                                            {{-- Fallback avatar --}}
                                            <div
                                                class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center text-white font-bold text-2xl">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <input type="file" name="profile_photo" id="profile_photo_admin"
                                                accept="image/*"
                                                class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 dark:bg-slate-700 dark:text-slate-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-slate-600 dark:file:text-slate-200 dark:hover:file:bg-slate-500"
                                                onchange="validateAndPreviewFile(this, 'admin')">
                                            <p id="file-info-admin"
                                                class="text-xs text-slate-500 dark:text-slate-400 mt-1">JPG, PNG, atau GIF
                                                (max 2MB)</p>
                                        </div>
                                    </div>
                                    @error('profile_photo')
                                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                            <i data-feather="alert-circle" class="w-4 h-4"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nama
                                        Lengkap *</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100">
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Email
                                        *</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        required
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100">
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">NRP</label>
                                    <input type="text" name="nrp" value="{{ old('nrp', $user->nrp) }}"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100 font-mono">
                                    @error('nrp')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nomor
                                        HP</label>
                                    <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100"
                                        placeholder="08xxxxxxxxxx">
                                    @error('no_hp')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Ubah Password -->
                        <div class="p-8 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-6 flex items-center">
                                <i data-feather="lock" class="w-6 h-6 mr-2 text-red-600 dark:text-red-400"></i>
                                Ubah Password (Opsional)
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">Kosongkan jika tidak ingin mengubah
                                password</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Password
                                        Baru</label>
                                    <input type="password" name="password"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100"
                                        placeholder="Minimal 8 karakter">
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Konfirmasi
                                        Password</label>
                                    <input type="password" name="password_confirmation"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:bg-slate-700 dark:text-slate-100"
                                        placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>

                        <!-- Info Read-Only -->
                        <div class="p-8 bg-blue-50 dark:bg-blue-900/20">
                            <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-300 mb-4 flex items-center">
                                <i data-feather="info" class="w-5 h-5 mr-2"></i>
                                Informasi Tambahan (Read-only)
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="text-slate-600 dark:text-slate-400">Role:</span>
                                    <span
                                        class="font-semibold text-slate-900 dark:text-slate-100 ml-2">{{ ucfirst($user->role) }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-600 dark:text-slate-400">Jabatan:</span>
                                    <span
                                        class="font-semibold text-slate-900 dark:text-slate-100 ml-2">{{ $user->jabatan ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-600 dark:text-slate-400">Status:</span>
                                    <span
                                        class="font-semibold text-slate-900 dark:text-slate-100 ml-2">{{ ucfirst($user->status) }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div
                        class="px-8 py-6 bg-slate-50 dark:bg-slate-700 flex flex-col sm:flex-row items-center sm:justify-end space-y-3 sm:space-y-0 sm:space-x-4 border-t border-slate-200 dark:border-slate-600 transition-colors duration-300">
                        <a href="{{ route('profile.show') }}"
                            class="w-full sm:w-auto px-6 py-3 bg-slate-500 dark:bg-slate-600 text-white font-semibold rounded-lg hover:bg-slate-600 dark:hover:bg-slate-700 transition-colors duration-300 text-center">
                            Batal
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 bg-blue-700 dark:bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-800 dark:hover:bg-blue-700 transition-colors duration-300 flex items-center justify-center">
                            <i data-feather="save" class="w-5 h-5 mr-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <script>
        // Initialize Feather icons
        feather.replace();

        // Preview image function
        function previewImage(input, section) {
            const file = input.files[0];
            const previewImg = document.getElementById(`preview-image-${section}`);
            const previewAvatar = document.getElementById(`preview-avatar-${section}`);
            const fileInfo = document.getElementById(`file-info-${section}`);

            if (file) {
                // Validate file size (max 2MB)
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                if (file.size > maxSize) {
                    fileInfo.textContent =
                        `❌ File terlalu besar (${(file.size / 1024 / 1024).toFixed(2)}MB). Maksimal 2MB.`;
                    fileInfo.classList.remove('hidden', 'text-slate-600', 'dark:text-slate-400', 'text-green-600',
                        'dark:text-green-400');
                    fileInfo.classList.add('text-red-600', 'dark:text-red-400');
                    input.value = ''; // Clear the input
                    return;
                }

                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    fileInfo.textContent = `❌ Format file tidak valid. Hanya JPG, PNG, atau GIF.`;
                    fileInfo.classList.remove('hidden', 'text-slate-600', 'dark:text-slate-400', 'text-green-600',
                        'dark:text-green-400');
                    fileInfo.classList.add('text-red-600', 'dark:text-red-400');
                    input.value = ''; // Clear the input
                    return;
                }

                // Show file info
                fileInfo.textContent = `✓ ${file.name} (${(file.size / 1024).toFixed(2)}KB) - Siap diupload`;
                fileInfo.classList.remove('hidden', 'text-red-600', 'dark:text-red-400');
                fileInfo.classList.add('text-green-600', 'dark:text-green-400');

                // Preview the image
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                    previewAvatar.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                fileInfo.classList.add('hidden');
            }
        }

        // Show loading state on form submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const memberStatus = document.getElementById('upload-status-member');
            const adminStatus = document.getElementById('upload-status-admin');
            const memberInput = document.getElementById('profile_photo_member');
            const adminInput = document.getElementById('profile_photo_admin');

            // Check if file is selected
            if ((memberInput && memberInput.files.length > 0) || (adminInput && adminInput.files.length > 0)) {
                if (memberStatus) memberStatus.classList.remove('hidden');
                if (adminStatus) adminStatus.classList.remove('hidden');

                // Disable submit button
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<svg class="animate-spin h-5 w-5 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...';
            }
        });
    </script>
@endsection
