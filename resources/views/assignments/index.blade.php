@extends('layouts.app')

@section('title', 'Kelola Tugas - ETS Web')

@section('content')
    @include('components.navbar')
    @include('components.sidebar')

    <main class="main-content-wrapper ml-64 mt-16 min-h-screen bg-gray-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Kelola Tugas</h2>
                        <p class="text-gray-600">Buat dan kelola tugas untuk member</p>
                    </div>
                    <a href="{{ route('assignments.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg hover:from-blue-600 hover:to-purple-700 transition">
                        <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                        Buat Tugas Baru
                    </a>
                </div>

                <!-- Success Message -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Assignments List -->
                <div class="grid gap-4">
                    @forelse($assignments as $assignment)
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $assignment->title }}</h3>
                                        @if ($assignment->is_active)
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Aktif</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Nonaktif</span>
                                        @endif
                                    </div>

                                    @if ($assignment->description)
                                        <p class="text-gray-600 mb-2">{{ $assignment->description }}</p>
                                    @endif

                                    <div class="flex items-center gap-4 text-sm text-gray-500">
                                        @if ($assignment->deadline)
                                            <span class="flex items-center gap-1">
                                                <i data-feather="calendar" class="w-4 h-4"></i>
                                                Deadline:
                                                {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y') }}
                                            </span>
                                        @endif
                                        <span class="flex items-center gap-1">
                                            <i data-feather="check-circle" class="w-4 h-4"></i>
                                            {{ $assignment->submissions()->count() }} pengumpulan
                                        </span>
                                    </div>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('assignments.edit', $assignment) }}"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i data-feather="edit" class="w-5 h-5"></i>
                                    </a>
                                    <form action="{{ route('assignments.destroy', $assignment) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                            <i data-feather="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow p-8 text-center">
                            <i data-feather="inbox" class="w-16 h-16 mx-auto text-gray-400 mb-4"></i>
                            <p class="text-gray-600">Belum ada tugas. Buat tugas baru untuk memulai!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
@endsection
