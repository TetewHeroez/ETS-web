@extends('layouts.app')

@section('title', 'Kumpulkan Tugas - MyHIMATIKA')

@section('content')
    @include('components.navbar')
    @include('components.sidebar')

    <main
        class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-slate-50 dark:bg-slate-900 transition-all duration-300">
        <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0">
                <!-- Header -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Kumpulkan Tugas</h2>
                    <p class="text-gray-600 dark:text-gray-400">Pilih tugas untuk dikumpulkan</p>
                </div>

                <!-- Assignments List -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($assignments as $assignment)
                        @php
                            $submitted = auth()
                                ->user()
                                ->submissions()
                                ->where('assignment_id', $assignment->id)
                                ->exists();
                        @endphp
                        <div
                            class="bg-white dark:bg-slate-800 rounded-lg shadow border border-slate-200 dark:border-slate-700 p-6 hover:shadow-lg transition-all duration-300">
                            <div class="mb-4">
                                <!-- Title with status badge -->
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 flex-1">
                                        {{ $assignment->title }}
                                    </h3>
                                    @if ($submitted)
                                        <span
                                            class="ml-2 px-2 py-1 text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 rounded-full border border-green-200 dark:border-green-600">
                                            ✓ Dikumpulkan
                                        </span>
                                    @endif
                                </div>

                                @if ($assignment->description)
                                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-4 line-clamp-2">
                                        {{ $assignment->description }}
                                    </p>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="space-y-2 mb-4 text-sm text-slate-600 dark:text-slate-400">
                                @if ($assignment->deadline)
                                    <div class="flex items-center gap-2">
                                        <i data-feather="calendar" class="w-4 h-4"></i>
                                        <span>
                                            {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y, H:i') }}
                                            @if (\Carbon\Carbon::parse($assignment->deadline)->isPast())
                                                <span class="ml-1 text-red-500 font-medium">(Sudah Terlewat)</span>
                                            @else
                                                <span class="ml-1 text-green-500 font-medium">
                                                    ({{ \Carbon\Carbon::parse($assignment->deadline)->diffForHumans() }})
                                                </span>
                                            @endif
                                        </span>
                                    </div>
                                @endif

                                <div class="flex items-center gap-2">
                                    <i data-feather="file" class="w-4 h-4"></i>
                                    <span>
                                        Tipe:
                                        @if ($assignment->submission_type === 'pdf')
                                            <span class="font-medium text-blue-600 dark:text-blue-400">PDF</span>
                                        @elseif ($assignment->submission_type === 'image')
                                            <span class="font-medium text-blue-600 dark:text-blue-400">Foto/Gambar</span>
                                        @else
                                            <span class="font-medium text-blue-600 dark:text-blue-400">Link URL</span>
                                        @endif
                                    </span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <i data-feather="users" class="w-4 h-4"></i>
                                    <span>{{ $assignment->submissions()->count() }} pengumpulan</span>
                                </div>
                            </div>

                            <!-- Button -->
                            <a href="{{ route('assignments.upload', $assignment) }}"
                                class="w-full inline-flex justify-center items-center px-4 py-2 {{ $submitted ? 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600' : 'bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-700 dark:to-cyan-600 text-white hover:from-blue-700 hover:to-cyan-600' }} rounded-lg transition font-medium">
                                <i data-feather="send" class="w-4 h-4 mr-2"></i>
                                {{ $submitted ? 'Lihat Pengumpulan' : 'Kumpulkan Tugas' }}
                            </a>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div
                                class="bg-white dark:bg-slate-800 rounded-lg shadow border border-slate-200 dark:border-slate-700 p-12 text-center">
                                <i data-feather="inbox"
                                    class="w-16 h-16 mx-auto text-slate-400 dark:text-slate-500 mb-4"></i>
                                <p class="text-slate-600 dark:text-slate-400 text-lg">Belum ada tugas yang aktif</p>
                                <p class="text-slate-500 dark:text-slate-500 text-sm mt-2">Tunggu admin membuat tugas baru
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
@endsection
