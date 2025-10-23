@extends('layouts.app')

@section('title', 'Kelola Tugas - MyPH')

@section('content')
    @include('components.navbar')
    @include('components.sidebar')

    <main
        class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-slate-50 dark:bg-slate-900 transition-all duration-300">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-slate-100">Kelola Tugas</h2>
                        <p class="text-slate-600 dark:text-slate-400 font-body">Buat dan kelola tugas untuk member</p>
                    </div>
                    <a href="{{ route('assignments.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg hover:from-blue-600 hover:to-purple-700 transition">
                        <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                        Buat Tugas Baru
                    </a>
                </div>

                <!-- Success Message -->
                @if (session('success'))
                    <div
                        class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg mb-6 transition-colors duration-300">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Assignments List -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @forelse($assignments as $assignment)
                        <div
                            class="bg-white dark:bg-slate-800 rounded-lg shadow border border-slate-200 dark:border-slate-700 p-6 transition-colors duration-300">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                                            {{ $assignment->title }}</h3>
                                        @if ($assignment->is_active)
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 rounded-full border border-green-200 dark:border-green-600 transition-colors duration-300">Aktif</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-300 rounded-full border border-slate-200 dark:border-slate-600 transition-colors duration-300">Nonaktif</span>
                                        @endif
                                    </div>

                                    @if ($assignment->description)
                                        <p class="text-slate-600 dark:text-slate-400 mb-2">{{ $assignment->description }}
                                        </p>
                                    @endif

                                    <div class="flex items-center gap-4 text-sm text-slate-500 dark:text-slate-400">
                                        @if ($assignment->deadline)
                                            <span class="flex items-center gap-1">
                                                <i data-feather="calendar"
                                                    class="w-4 h-4 text-slate-500 dark:text-slate-400"></i>
                                                Deadline:
                                                {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y') }}
                                            </span>
                                        @endif
                                        <span class="flex items-center gap-1">
                                            <i data-feather="check-circle"
                                                class="w-4 h-4 text-slate-500 dark:text-slate-400"></i>
                                            {{ $assignment->submissions()->count() }} pengumpulan
                                        </span>
                                    </div>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('assignments.edit', $assignment) }}"
                                        class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors duration-300">
                                        <i data-feather="edit" class="w-5 h-5"></i>
                                    </a>
                                    <form action="{{ route('assignments.destroy', $assignment) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors duration-300">
                                            <i data-feather="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="bg-white dark:bg-slate-800 rounded-lg shadow border border-slate-200 dark:border-slate-700 p-8 text-center transition-colors duration-300">
                            <i data-feather="inbox" class="w-16 h-16 mx-auto text-slate-400 dark:text-slate-500 mb-4"></i>
                            <p class="text-slate-600 dark:text-slate-400">Belum ada tugas. Buat tugas baru untuk memulai!
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
@endsection
