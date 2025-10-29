@extends('layouts.app')

@section('title', 'Submissions - ' . $user->name . ' - MyHIMATIKA')

@section('content')
    @include('components.navbar')
    @include('components.sidebar')

    <main
        class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-slate-50 dark:bg-slate-900 transition-all duration-300">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            @if (isset($assignmentId) && $assignmentId)
                                @php
                                    $assignment = \App\Models\Assignment::find($assignmentId);
                                @endphp
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Submission
                                    {{ $assignment->title }}</h2>
                                <p class="text-gray-600 dark:text-gray-400">Dari: {{ $user->name }} | NRP:
                                    {{ $user->nrp }}</p>
                            @else
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Submissions dari
                                    {{ $user->name }}</h2>
                                <p class="text-gray-600 dark:text-gray-400">NRP: {{ $user->nrp }} | Kelompok:
                                    {{ $user->kelompok }}</p>
                            @endif
                        </div>
                        <a href="{{ route('submissions.table') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition font-medium">
                            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
                            Kembali ke Progress
                        </a>
                    </div>
                </div>

                <!-- Submissions List -->
                <div class="space-y-6">
                    @forelse($submissions as $submission)
                        <div
                            class="bg-white dark:bg-slate-800 rounded-lg shadow border border-slate-200 dark:border-slate-700 p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                                        {{ $submission->assignment->title }}
                                    </h3>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                        Dikumpulkan pada {{ $submission->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if ($submission->assignment->deadline && $submission->created_at->gt($submission->assignment->deadline))
                                        <span
                                            class="px-2 py-1 text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300 rounded-full">
                                            Terlambat
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 rounded-full">
                                            Tepat Waktu
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Submission Content -->
                            <div class="mb-4">
                                @if ($submission->type === 'link')
                                    <div class="flex items-center gap-2">
                                        <i data-feather="link" class="w-4 h-4 text-blue-500"></i>
                                        <a href="{{ $submission->content }}" target="_blank"
                                            class="text-blue-600 dark:text-blue-400 hover:underline break-all">
                                            {{ $submission->content }}
                                        </a>
                                    </div>
                                @elseif($submission->type === 'image')
                                    <div class="mt-4">
                                        <img src="{{ $submission->content }}" alt="Submission Image"
                                            class="max-w-full h-auto rounded-lg shadow border">
                                    </div>
                                @elseif($submission->type === 'pdf')
                                    <div class="mt-4">
                                        <iframe src="{{ $submission->content }}"
                                            class="w-full h-96 border rounded-lg"></iframe>
                                        <div class="mt-2">
                                            <a href="{{ $submission->content }}" target="_blank"
                                                class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300 rounded text-sm hover:bg-blue-200 dark:hover:bg-blue-800 transition">
                                                <i data-feather="external-link" class="w-3 h-3 mr-1"></i>
                                                Buka PDF di Tab Baru
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Notes -->
                            @if ($submission->notes)
                                <div class="bg-slate-50 dark:bg-slate-700 rounded-lg p-4">
                                    <h4 class="text-sm font-medium text-slate-900 dark:text-slate-100 mb-2">Catatan:</h4>
                                    <p class="text-sm text-slate-700 dark:text-slate-300">{{ $submission->notes }}</p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div
                            class="bg-white dark:bg-slate-800 rounded-lg shadow border border-slate-200 dark:border-slate-700 p-12 text-center">
                            <i data-feather="file-x" class="w-16 h-16 mx-auto text-slate-400 dark:text-slate-500 mb-4"></i>
                            <p class="text-slate-600 dark:text-slate-400 text-lg">Belum ada submission</p>
                            <p class="text-slate-500 dark:text-slate-500 text-sm mt-2">{{ $user->name }} belum
                                mengumpulkan tugas apapun</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
@endsection
