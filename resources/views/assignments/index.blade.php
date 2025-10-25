@extends('layouts.app')

@section('title', 'Kelola Tugas - MyHIMATIKA')

@section('content')
    @include('components.navbar')
    @include('components.sidebar')

    <main
        class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-slate-50 dark:bg-slate-900 transition-all duration-300">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-slate-100">Kelola Tugas</h2>
                        <p class="text-slate-600 dark:text-slate-400 font-body text-sm">Buat dan kelola tugas untuk member
                        </p>
                    </div>
                    <a href="{{ route('assignments.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition shadow-md hover:shadow-lg whitespace-nowrap">
                        <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                        <span>Buat Tugas</span>
                    </a>
                </div>

                <!-- Success Message -->
                @if (session('success'))
                    <div
                        class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg mb-6 transition-colors duration-300">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Assignments Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($assignments as $assignment)
                        <div
                            class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-4 hover:shadow-md transition-all duration-300">
                            <!-- Title & Status -->
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <h3 class="text-base font-semibold text-slate-900 dark:text-slate-100 flex-1 line-clamp-2">
                                    {{ $assignment->title }}
                                </h3>
                            </div>

                            <!-- Meta Info - Compact Layout -->
                            <div class="space-y-2 mb-4 text-xs text-slate-600 dark:text-slate-400">
                                <!-- Deadline & Type -->
                                <div class="flex items-center justify-between gap-2">
                                    <span class="flex items-center gap-1">
                                        <i data-feather="calendar" class="w-3.5 h-3.5"></i>
                                        {{ $assignment->deadline ? \Carbon\Carbon::parse($assignment->deadline)->format('d M') : 'Tanpa deadline' }}
                                    </span>
                                    <span class="flex items-center gap-1 px-2 py-1 bg-slate-100 dark:bg-slate-700 rounded">
                                        @if ($assignment->submission_type === 'pdf')
                                            <i data-feather="file-text" class="w-3.5 h-3.5 text-red-600"></i>
                                            <span>PDF</span>
                                        @elseif ($assignment->submission_type === 'image')
                                            <i data-feather="image" class="w-3.5 h-3.5 text-green-600"></i>
                                            <span>Foto</span>
                                        @else
                                            <i data-feather="link" class="w-3.5 h-3.5 text-gray-600"></i>
                                            <span>Link</span>
                                        @endif
                                    </span>
                                </div>

                                <!-- Submissions Count -->
                                <div class="flex items-center gap-1">
                                    <i data-feather="check-circle" class="w-3.5 h-3.5"></i>
                                    <span>{{ $assignment->submissions()->count() }} submission</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div
                                class="flex items-center justify-end gap-2 pt-3 border-t border-slate-200 dark:border-slate-700">
                                <a href="{{ route('assignments.edit', $assignment) }}"
                                    class="inline-flex items-center justify-center p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded transition-colors"
                                    title="Edit">
                                    <i data-feather="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('assignments.destroy', $assignment) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded transition-colors"
                                        title="Hapus">
                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-1 sm:col-span-2 lg:col-span-3 bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-12 text-center">
                            <i data-feather="inbox" class="w-12 h-12 mx-auto text-slate-400 dark:text-slate-500 mb-3"></i>
                            <p class="text-slate-600 dark:text-slate-400 text-sm">Belum ada tugas. Buat tugas baru untuk
                                memulai!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
@endsection
