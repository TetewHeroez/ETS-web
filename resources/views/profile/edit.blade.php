@extends('layouts.app')

@section('title', 'Edit Profil - ETS Web')

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
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div
                    class="bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors duration-300">

                    @if ($user->role === 'member')
                        <!-- FORM LENGKAP UNTUK MEMBER -->

                        <!-- Data Dasar -->
                        <div class="p-8 border-b">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i data-feather="user-check" class="w-6 h-6 mr-2 text-blue-700"></i>
                                Data Dasar
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400">
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400">
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">NRP</label>
                                    <input type="text" name="nrp" value="{{ old('nrp', $user->nrp) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 font-mono">
                                    @error('nrp')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP</label>
                                    <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="08xxxxxxxxxx">
                                    @error('no_hp')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kelompok</label>
                                    <input type="text" name="kelompok" value="{{ old('kelompok', $user->kelompok) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('kelompok')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hobi</label>
                                    <input type="text" name="hobi" value="{{ old('hobi', $user->hobi) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('hobi')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Data Pribadi -->
                        <div class="p-8 border-b">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i data-feather="user" class="w-6 h-6 mr-2 text-blue-700"></i>
                                Data Pribadi
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin</label>
                                    <select name="jenis_kelamin"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Golongan Darah</label>
                                    <select name="golongan_darah"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir"
                                        value="{{ old('tempat_lahir', $user->tempat_lahir) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Data Alamat -->
                        <div class="p-8 border-b">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i data-feather="map-pin" class="w-6 h-6 mr-2 text-cyan-600"></i>
                                Data Alamat
                            </h3>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Asal</label>
                                    <textarea name="alamat_asal" rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('alamat_asal', $user->alamat_asal) }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat di Surabaya</label>
                                    <textarea name="alamat_surabaya" rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('alamat_surabaya', $user->alamat_surabaya) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Data Orang Tua/Wali -->
                        <div class="p-8 border-b">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i data-feather="users" class="w-6 h-6 mr-2 text-slate-600"></i>
                                Data Orang Tua/Wali
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Orang
                                        Tua/Wali</label>
                                    <input type="text" name="nama_ortu"
                                        value="{{ old('nama_ortu', $user->nama_ortu) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP Orang
                                        Tua</label>
                                    <input type="text" name="no_hp_ortu"
                                        value="{{ old('no_hp_ortu', $user->no_hp_ortu) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Orang Tua</label>
                                    <textarea name="alamat_ortu" rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('alamat_ortu', $user->alamat_ortu) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Data Kesehatan -->
                        <div class="p-8 border-b">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i data-feather="heart" class="w-6 h-6 mr-2 text-cyan-500"></i>
                                Data Kesehatan
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alergi</label>
                                    <textarea name="alergi" rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400"
                                        placeholder="Contoh: Alergi seafood, debu, dll">{{ old('alergi', $user->alergi) }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Riwayat Penyakit</label>
                                    <textarea name="riwayat_penyakit" rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400"
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

                        <div class="p-8 border-b">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i data-feather="user-check" class="w-6 h-6 mr-2 text-blue-700"></i>
                                Data Profil
                            </h3>
                            <p class="text-sm text-gray-600 mb-6">Sebagai {{ ucfirst($user->role) }}, Anda hanya dapat
                                mengedit data berikut:</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400">
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400">
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">NRP</label>
                                    <input type="text" name="nrp" value="{{ old('nrp', $user->nrp) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 font-mono">
                                    @error('nrp')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP</label>
                                    <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="08xxxxxxxxxx">
                                    @error('no_hp')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
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

                        <!-- Info Read-Only -->
                        <div class="p-8 bg-blue-50">
                            <h4 class="text-sm font-semibold text-blue-900 mb-4 flex items-center">
                                <i data-feather="info" class="w-5 h-5 mr-2"></i>
                                Informasi Tambahan (Read-only)
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Role:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ ucfirst($user->role) }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Jabatan:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ $user->jabatan ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Status:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ ucfirst($user->status) }}</span>
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
    </script>
@endsection
