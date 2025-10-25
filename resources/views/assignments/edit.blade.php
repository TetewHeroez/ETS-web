@extends('layouts.app')

@section('title', 'Edit Tugas - MyHIMATIKA')

@section('content')
    @include('components.navbar')
    @include('components.sidebar')

    <main
        class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-gray-50 dark:bg-slate-900 transition-all duration-300">
        <div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0">
                <!-- Header -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Tugas</h2>
                    <p class="text-gray-600 dark:text-gray-400">Ubah detail tugas</p>
                </div>

                <!-- Form -->
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg dark:shadow-slate-900/50 p-6">
                    <form action="{{ route('assignments.update', $assignment) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Judul Tugas <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" required
                                value="{{ old('title', $assignment->title) }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                                placeholder="Contoh: Tugas 1 - Pengenalan Laravel">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                                placeholder="Jelaskan detail tugas...">{{ old('description', $assignment->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deadline -->
                        <div class="mb-4">
                            <label for="deadline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Deadline
                            </label>
                            <input type="date" name="deadline" id="deadline"
                                value="{{ old('deadline', $assignment->deadline?->format('Y-m-d')) }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                            @error('deadline')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- GDK Flowchart -->
                        <div class="mb-4">
                            <label for="gdk_flowchart_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Metode GDK (untuk perhitungan PI) <span class="text-red-500">*</span>
                            </label>
                            <select name="gdk_flowchart_id" id="gdk_flowchart_id" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                                <option value="">-- Pilih Metode GDK --</option>
                                @foreach ($flowcharts as $flowchart)
                                    @if ($flowchart->metode)
                                        @php
                                            $metode = $flowchart->metode;
                                            $materi = $metode->materi;
                                            $nilai = $materi->nilai;
                                            $totalMultiplier = $flowchart->total_multiplier;
                                        @endphp
                                        <option value="{{ $flowchart->id }}"
                                            {{ old('gdk_flowchart_id', $assignment->gdk_flowchart_id) == $flowchart->id ? 'selected' : '' }}
                                            data-multiplier="{{ $totalMultiplier }}">
                                            {{ $nilai->nama_nilai }} → {{ $materi->nama_materi }} →
                                            {{ $metode->nama_metode }}
                                            (Multiplier: {{ $totalMultiplier }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <i data-feather="info" class="w-3 h-3 inline"></i>
                                Pilih metode GDK untuk menentukan multiplier perhitungan PI.
                                <span class="font-semibold">PI = (Submit ? 1 : 0) × Multiplier</span>
                            </p>
                            @error('gdk_flowchart_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submission Type -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tipe File yang Diterima <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="submission_type" value="pdf"
                                        {{ old('submission_type', $assignment->submission_type) == 'pdf' ? 'checked' : '' }}
                                        class="peer hidden" required>
                                    <div
                                        class="border-2 border-gray-300 dark:border-slate-600 rounded-lg p-3 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 hover:border-blue-300 dark:hover:border-blue-600 transition">
                                        <i data-feather="file-text"
                                            class="w-6 h-6 mx-auto mb-1 text-red-600 dark:text-red-400"></i>
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">PDF</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="submission_type" value="image"
                                        {{ old('submission_type', $assignment->submission_type) == 'image' ? 'checked' : '' }}
                                        class="peer hidden" required>
                                    <div
                                        class="border-2 border-gray-300 dark:border-slate-600 rounded-lg p-3 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 hover:border-blue-300 dark:hover:border-blue-600 transition">
                                        <i data-feather="image"
                                            class="w-6 h-6 mx-auto mb-1 text-green-600 dark:text-green-400"></i>
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Foto</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="submission_type" value="link"
                                        {{ old('submission_type', $assignment->submission_type) == 'link' ? 'checked' : '' }}
                                        class="peer hidden" required>
                                    <div
                                        class="border-2 border-gray-300 dark:border-slate-600 rounded-lg p-3 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 hover:border-blue-300 dark:hover:border-blue-600 transition">
                                        <i data-feather="link"
                                            class="w-6 h-6 mx-auto mb-1 text-gray-600 dark:text-gray-400"></i>
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Link</span>
                                    </div>
                                </label>
                            </div>
                            @error('submission_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="submit"
                                class="w-full sm:flex-1 bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 text-white py-2 rounded-lg hover:from-blue-600 hover:to-blue-700 dark:hover:from-blue-700 dark:hover:to-blue-800 transition shadow-md hover:shadow-lg">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('assignments.index') }}"
                                class="w-full sm:flex-1 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition text-center shadow-md">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
