@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    @include('components.navbar')
    @include('components.sidebar')

    <main class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-gray-50 transition-all duration-300">
        <div class="w-full py-6 px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Edit User</h2>
                    <p class="text-gray-600">Edit informasi user: {{ $user->name }}</p>
                </div>
                <a href="{{ route('users.index') }}"
                    class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition flex items-center shadow-md">
                    <i data-feather="arrow-left" class="w-5 h-5 mr-2"></i>
                    Kembali
                </a>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-6 bg-cyan-100 border-l-4 border-cyan-500 text-cyan-800 p-4 rounded-lg shadow-md"
                    role="alert">
                    <div class="flex items-center">
                        <i data-feather="check-circle" class="w-5 h-5 mr-2"></i>
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded-lg shadow-md" role="alert">
                    <div class="flex items-center">
                        <i data-feather="alert-circle" class="w-5 h-5 mr-2"></i>
                        <p class="font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Edit User Form -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-700 to-cyan-600 text-white px-6 py-4">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i data-feather="edit" class="w-5 h-5 mr-2"></i>
                        Form Edit User
                    </h3>
                </div>

                <form method="POST" action="{{ route('users.update', $user) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-medium text-gray-800 border-b pb-2">Informasi Dasar</h4>

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i data-feather="user" class="w-4 h-4 inline mr-1"></i>
                                    Nama Lengkap
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i data-feather="mail" class="w-4 h-4 inline mr-1"></i>
                                    Email
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-500 @enderror"
                                    placeholder="user@example.com">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NRP -->
                            <div>
                                <label for="nrp" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i data-feather="credit-card" class="w-4 h-4 inline mr-1"></i>
                                    NRP <span class="text-gray-500">(opsional)</span>
                                </label>
                                <input type="text" name="nrp" id="nrp" value="{{ old('nrp', $user->nrp) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('nrp') border-red-500 @enderror"
                                    placeholder="Nomor Registrasi Pokok">
                                @error('nrp')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i data-feather="shield" class="w-4 h-4 inline mr-1"></i>
                                    Role
                                </label>
                                <select name="role" id="role" required
                                    onchange="toggleJabatanOptions(); toggleKelompokField();"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('role') border-red-500 @enderror">
                                    <option value="">Pilih Role</option>
                                    <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>
                                        Member</option>
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                        Admin</option>
                                    <option value="superadmin"
                                        {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>Super Admin
                                    </option>
                                </select>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jabatan -->
                            <div>
                                <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i data-feather="briefcase" class="w-4 h-4 inline mr-1"></i>
                                    Jabatan <span class="text-red-500">*</span>
                                </label>
                                <select name="jabatan" id="jabatan" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('jabatan') border-red-500 @enderror">
                                    <option value="">Pilih Jabatan</option>
                                    <option value="PPH" data-role="member"
                                        {{ old('jabatan', $user->jabatan) === 'PPH' ? 'selected' : '' }}>PPH</option>
                                    <option value="SC" data-role="admin"
                                        {{ old('jabatan', $user->jabatan) === 'SC' ? 'selected' : '' }}>SC</option>
                                    <option value="IC" data-role="admin"
                                        {{ old('jabatan', $user->jabatan) === 'IC' ? 'selected' : '' }}>IC</option>
                                    <option value="OC" data-role="admin"
                                        {{ old('jabatan', $user->jabatan) === 'OC' ? 'selected' : '' }}>OC</option>
                                    <option value="Koor SC" data-role="superadmin"
                                        {{ old('jabatan', $user->jabatan) === 'Koor SC' ? 'selected' : '' }}>Koor SC
                                    </option>
                                    <option value="Koor IC" data-role="superadmin"
                                        {{ old('jabatan', $user->jabatan) === 'Koor IC' ? 'selected' : '' }}>Koor IC
                                    </option>
                                </select>
                                @error('jabatan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Pilih role terlebih dahulu untuk melihat jabatan yang
                                    sesuai</p>
                            </div>

                            <!-- Kelompok (conditional for member) -->
                            <div id="kelompok-field"
                                style="display: {{ old('role', $user->role) === 'member' ? 'block' : 'none' }};">
                                <label for="kelompok" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i data-feather="users" class="w-4 h-4 inline mr-1"></i>
                                    Kelompok <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="kelompok" id="kelompok"
                                    value="{{ old('kelompok', $user->kelompok) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('kelompok') border-red-500 @enderror"
                                    placeholder="Contoh: Kelompok A, Kelompok 1, dll">
                                @error('kelompok')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Wajib diisi untuk role member</p>
                            </div>
                        </div>

                        <!-- Security & Profile -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-medium text-gray-800 border-b pb-2">Keamanan & Profil</h4>

                            <!-- Password Notice -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <i data-feather="info" class="w-5 h-5 text-blue-600 mr-2"></i>
                                    <p class="text-sm text-blue-800">
                                        <strong>Info Password:</strong> Kosongkan jika tidak ingin mengubah password
                                    </p>
                                </div>
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i data-feather="lock" class="w-4 h-4 inline mr-1"></i>
                                    Password Baru <span class="text-gray-500">(opsional)</span>
                                </label>
                                <input type="password" name="password" id="password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password') border-red-500 @enderror"
                                    placeholder="Minimal 8 karakter atau kosongkan">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i data-feather="lock" class="w-4 h-4 inline mr-1"></i>
                                    Konfirmasi Password Baru
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Ulangi password baru">
                            </div>

                            <!-- Phone (optional) -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i data-feather="phone" class="w-4 h-4 inline mr-1"></i>
                                    Nomor Telepon <span class="text-gray-500">(opsional)</span>
                                </label>
                                <input type="text" name="phone" id="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('phone') border-red-500 @enderror"
                                    placeholder="08xxxxxxxxxx">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address (optional) -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i data-feather="map-pin" class="w-4 h-4 inline mr-1"></i>
                                    Alamat <span class="text-gray-500">(opsional)</span>
                                </label>
                                <textarea name="address" id="address" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('address') border-red-500 @enderror"
                                    placeholder="Alamat lengkap">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date of Birth (optional) -->
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i data-feather="calendar" class="w-4 h-4 inline mr-1"></i>
                                    Tanggal Lahir <span class="text-gray-500">(opsional)</span>
                                </label>
                                <input type="date" name="date_of_birth" id="date_of_birth"
                                    value="{{ old('date_of_birth', $user->date_of_birth) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('date_of_birth') border-red-500 @enderror">
                                @error('date_of_birth')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Hobi (optional) -->
                            <div>
                                <label for="hobi" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i data-feather="heart" class="w-4 h-4 inline mr-1"></i>
                                    Hobi <span class="text-gray-500">(opsional)</span>
                                </label>
                                <textarea name="hobi" id="hobi" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('hobi') border-red-500 @enderror"
                                    placeholder="Contoh: Membaca, Olahraga, Menyanyi, dll">{{ old('hobi', $user->hobi) }}</textarea>
                                @error('hobi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No HP Ortu (optional) -->
                            <div>
                                <label for="no_hp_ortu" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i data-feather="phone" class="w-4 h-4 inline mr-1"></i>
                                    No HP Orang Tua <span class="text-gray-500">(opsional)</span>
                                </label>
                                <input type="text" name="no_hp_ortu" id="no_hp_ortu"
                                    value="{{ old('no_hp_ortu', $user->no_hp_ortu) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('no_hp_ortu') border-red-500 @enderror"
                                    placeholder="08xxxxxxxxxx">
                                @error('no_hp_ortu')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-8 flex justify-end space-x-4 pt-6 border-t">
                        <a href="{{ route('users.index') }}"
                            class="px-6 py-3 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition flex items-center">
                            <i data-feather="x" class="w-5 h-5 mr-2"></i>
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 flex items-center">
                            <i data-feather="save" class="w-5 h-5 mr-2"></i>
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Initialize Feather icons
        feather.replace();

        // Toggle jabatan options based on role selection
        function toggleJabatanOptions() {
            const roleSelect = document.getElementById('role');
            const jabatanSelect = document.getElementById('jabatan');
            const selectedRole = roleSelect.value;

            // Get all jabatan options
            const jabatanOptions = jabatanSelect.querySelectorAll('option[data-role]');

            // Show/hide jabatan options based on selected role
            jabatanOptions.forEach(option => {
                if (option.dataset.role === selectedRole || selectedRole === '') {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        }

        // Toggle kelompok field based on role selection
        function toggleKelompokField() {
            const roleSelect = document.getElementById('role');
            const kelompokField = document.getElementById('kelompok-field');
            const kelompokInput = document.getElementById('kelompok');

            if (roleSelect.value === 'member') {
                kelompokField.style.display = 'block';
                kelompokInput.setAttribute('required', 'required');
            } else {
                kelompokField.style.display = 'none';
                kelompokInput.removeAttribute('required');
                kelompokInput.value = '';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleJabatanOptions();
            toggleKelompokField();
        });
    </script>
@endsection
