@extends('layouts.app')

@section('title', 'Buat Tugas Baru - ETS Web')

@section('content')
    @include('components.navbar')
    @include('components.sidebar')

    <main class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-gray-50 transition-all duration-300">
        <div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0">
                <!-- Header -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Buat Tugas Baru</h2>
                    <p class="text-gray-600">Isi form di bawah untuk membuat tugas baru</p>
                </div>

                <!-- Form -->
                <div class="bg-white rounded-lg shadow p-6">
                    <form action="{{ route('assignments.store') }}" method="POST">
                        @csrf

                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Tugas <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" required value="{{ old('title') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Contoh: Tugas 1 - Pengenalan Laravel">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Jelaskan detail tugas...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deadline -->
                        <div class="mb-4">
                            <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">
                                Deadline
                            </label>
                            <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('deadline')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Weight/Bobot -->
                        <div class="mb-4">
                            <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                                Bobot Tugas (untuk perhitungan PI)
                            </label>
                            <input type="number" name="weight" id="weight" value="{{ old('weight', 1) }}"
                                min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan bobot (default: 1)">
                            <p class="text-xs text-gray-500 mt-1">Bobot digunakan untuk menghitung Poin Individu (PI = Nilai
                                × Bobot)</p>
                            @error('weight')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Is Active -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Aktifkan tugas ini</span>
                            </label>
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="submit"
                                class="w-full sm:flex-1 bg-gradient-to-r from-blue-500 to-purple-600 text-white py-2 rounded-lg hover:from-blue-600 hover:to-purple-700 transition">
                                Buat Tugas
                            </button>
                            <a href="{{ route('assignments.index') }}"
                                class="w-full sm:flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition text-center">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
