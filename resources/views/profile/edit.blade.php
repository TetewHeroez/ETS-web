@extends('layouts.app')

@section('title', 'Edit Profil - ETS Web')

@section('content')
    <!-- Navbar Top -->
    @include('components.navbar')

    <!-- Sidebar -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="main-content-wrapper ml-64 mt-16 min-h-screen bg-gray-50 transition-all duration-300">
        <div class="max-w-5xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i data-feather="edit-2" class="w-8 h-8 mr-3 text-blue-700"></i>
                    Edit Profil
                </h1>
                <p class="mt-2 text-gray-600">Perbarui informasi profil Anda</p>
            </div>

            <!-- Form -->
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <!-- Data Pribadi -->
                    <div class="p-8 border-b">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i data-feather="user-check" class="w-6 h-6 mr-2 text-blue-700"></i>
                            Data Pribadi
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
                                <label class="block text-sm font-semibold text-gray-700 mb-2">NRP *</label>
                                <input type="text" name="nrp" value="{{ old('nrp', $user->nrp) }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 font-mono">
                                @error('nrp')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

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
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Orang Tua/Wali</label>
                                <input type="text" name="nama_ortu" value="{{ old('nama_ortu', $user->nama_ortu) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
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
                    <div class="p-8">
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

                    <!-- Action Buttons -->
                    <div class="px-8 py-6 bg-slate-50 flex items-center justify-end space-x-4">
                        <a href="{{ route('profile.show') }}"
                            class="px-6 py-2 border border-slate-300 text-gray-700 font-semibold rounded-lg hover:bg-slate-100 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-700 text-white font-semibold rounded-lg hover:bg-blue-800 transition flex items-center shadow-md">
                            <i data-feather="save" class="w-5 h-5 mr-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
