@extends('layouts.app')

@section('title', 'Pilih Tugas - MyHIMATIKA')

@section('content')
    @include('components.navbar')
    @include('components.sidebar')

    <main
        class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-slate-50 dark:bg-slate-900 transition-all duration-300">
        <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0">
                <!-- Header -->
                <div class="mb-6">
                    <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-slate-100">Pilih Tugas untuk
                        Dikumpulkan</h2>
                    <p class="text-slate-600 dark:text-slate-400 font-body">
                        Pilih tugas yang ingin Anda kumpulkan dari daftar di bawah ini.
                    </p>
                </div>

                <!-- Assignments Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($assignments as $assignment)
                        @php
                            $deadline = \Carbon\Carbon::parse($assignment->deadline);
                            $now = \Carbon\Carbon::now();
                            $daysLeft = (int) $now->diffInDays($deadline, false);

                            // Check if user has already submitted
                            $hasSubmitted = auth()
                                ->user()
                                ->submissions()
                                ->where('assignment_id', $assignment->id)
                                ->exists();

                            // Determine status and colors
                            if ($hasSubmitted) {
                                $status = 'Sudah Dikumpulkan';
                                $statusColor = 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300';
                                $cardBorder = 'border-green-200 dark:border-green-700';
                                $buttonText = 'Lihat/Edit Submission';
                                $buttonColor = 'bg-green-600 hover:bg-green-700';
                            } elseif ($daysLeft < 0) {
                                $status = 'Terlambat';
                                $statusColor = 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300';
                                $cardBorder = 'border-red-200 dark:border-red-700';
                                $buttonText = 'Kumpulkan (Terlambat)';
                                $buttonColor = 'bg-red-600 hover:bg-red-700';
                            } elseif ($daysLeft <= 3) {
                                $status = 'Deadline Dekat';
                                $statusColor =
                                    'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300';
                                $cardBorder = 'border-orange-200 dark:border-orange-700';
                                $buttonText = 'Kumpulkan Sekarang';
                                $buttonColor = 'bg-orange-600 hover:bg-orange-700';
                            } else {
                                $status = 'Belum Dikumpulkan';
                                $statusColor = 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300';
                                $cardBorder = 'border-blue-200 dark:border-blue-700';
                                $buttonText = 'Kumpulkan';
                                $buttonColor = 'bg-blue-600 hover:bg-blue-700';
                            }
                        @endphp

                        <div
                            class="bg-white dark:bg-slate-800 rounded-lg shadow-md border-l-4 {{ $cardBorder }} overflow-hidden hover:shadow-lg transition-shadow duration-200">
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 flex-1">
                                        {{ $assignment->title }}
                                    </h3>
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColor }} ml-2 flex-shrink-0">
                                        {{ $status }}
                                    </span>
                                </div>

                                @if ($assignment->description)
                                    <p class="text-slate-600 dark:text-slate-400 text-sm mb-4 line-clamp-3">
                                        {{ Str::limit($assignment->description, 100) }}
                                    </p>
                                @endif

                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                                        <i data-feather="calendar" class="w-4 h-4 mr-2"></i>
                                        Deadline: {{ $deadline->format('d M Y') }}
                                    </div>
                                    <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                                        <i data-feather="clock" class="w-4 h-4 mr-2"></i>
                                        @if ($daysLeft < 0)
                                            Terlambat {{ abs($daysLeft) }} hari
                                        @elseif ($daysLeft == 0)
                                            Hari ini
                                        @else
                                            {{ $daysLeft }} hari lagi
                                        @endif
                                    </div>
                                    <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                                        <i data-feather="file-text" class="w-4 h-4 mr-2"></i>
                                        Tipe:
                                        {{ $assignment->submission_type === 'pdf' ? 'PDF' : ($assignment->submission_type === 'image' ? 'Gambar' : 'Link') }}
                                    </div>
                                </div>

                                <a href="{{ route('assignments.upload', $assignment) }}"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white rounded-lg transition-colors duration-200 {{ $buttonColor }}">
                                    <i data-feather="upload" class="w-4 h-4 mr-2"></i>
                                    {{ $buttonText }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($assignments->isEmpty())
                    <div class="text-center py-12">
                        <i data-feather="file-x" class="w-16 h-16 text-slate-300 dark:text-slate-600 mx-auto mb-4"></i>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">Belum Ada Tugas</h3>
                        <p class="text-slate-600 dark:text-slate-400">Belum ada tugas yang tersedia untuk dikumpulkan.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        // Initialize Feather icons
        feather.replace();
    </script>
@endpush
