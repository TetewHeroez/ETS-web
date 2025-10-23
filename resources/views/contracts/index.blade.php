@extends('layouts.app')

@section('title', 'Kelola Kontrak - MyPH')

@section('content')
    @include('components.navbar')
    @include('components.sidebar')

    <main
        class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-slate-50 dark:bg-slate-900 transition-all duration-300">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-slate-100">Kelola Kontrak</h2>
                        <p class="text-slate-600 dark:text-slate-400 font-body">Atur kontrak yang akan ditampilkan di
                            dashboard</p>
                    </div>
                    <a href="{{ route('contracts.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-700 dark:to-cyan-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-cyan-600 dark:hover:from-blue-800 dark:hover:to-cyan-700 transition shadow-lg">
                        <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                        Buat Kontrak Baru
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div
                    class="bg-cyan-100 dark:bg-cyan-900/30 border border-cyan-400 dark:border-cyan-600 text-cyan-700 dark:text-cyan-300 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Contracts List -->
            <div class="grid grid-cols-1 gap-6">
                @forelse($contracts as $contract)
                    <div
                        class="bg-white dark:bg-slate-800 rounded-lg shadow border border-slate-200 dark:border-slate-700 overflow-hidden transition-all hover:shadow-lg">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">
                                            {{ $contract->title }}</h3>
                                        @if ($contract->is_active)
                                            <span
                                                class="px-3 py-1 bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300 text-xs font-semibold rounded-full">
                                                ✓ Aktif
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 bg-gray-100 dark:bg-gray-900/50 text-gray-600 dark:text-gray-400 text-xs font-semibold rounded-full">
                                                Tidak Aktif
                                            </span>
                                        @endif
                                    </div>
                                    @if ($contract->description)
                                        <p class="text-sm text-slate-600 dark:text-slate-400 mb-3">
                                            {{ $contract->description }}</p>
                                    @endif
                                    <p class="text-xs text-slate-500 dark:text-slate-500">
                                        Dibuat: {{ $contract->created_at->format('d M Y H:i') }} •
                                        Diupdate: {{ $contract->updated_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Rules Preview -->
                            <div class="mb-4">
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Aturan Kontrak:
                                </p>
                                <ol class="space-y-1 text-sm text-slate-600 dark:text-slate-400">
                                    @foreach ($contract->rules as $index => $rule)
                                        <li class="flex items-start">
                                            <span class="font-semibold mr-2">{{ $index + 1 }}.</span>
                                            <span>{{ Str::limit($rule, 100) }}</span>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2 pt-4 border-t border-slate-200 dark:border-slate-700">
                                @if (!$contract->is_active)
                                    <form action="{{ route('contracts.toggleActive', $contract) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-2 bg-green-600 dark:bg-green-700 text-white text-sm font-semibold rounded-lg hover:bg-green-700 dark:hover:bg-green-800 transition">
                                            <i data-feather="check-circle" class="w-4 h-4 mr-1"></i>
                                            Aktifkan
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('contracts.edit', $contract) }}"
                                    class="inline-flex items-center px-3 py-2 bg-blue-600 dark:bg-blue-700 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 dark:hover:bg-blue-800 transition">
                                    <i data-feather="edit-2" class="w-4 h-4 mr-1"></i>
                                    Edit
                                </a>

                                <form action="{{ route('contracts.destroy', $contract) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus kontrak ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-2 bg-red-600 dark:bg-red-700 text-white text-sm font-semibold rounded-lg hover:bg-red-700 dark:hover:bg-red-800 transition">
                                        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="bg-white dark:bg-slate-800 rounded-lg shadow border border-slate-200 dark:border-slate-700 p-12 text-center">
                        <i data-feather="file-text" class="w-16 h-16 mx-auto text-slate-400 dark:text-slate-600 mb-4"></i>
                        <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Belum Ada Kontrak</h3>
                        <p class="text-slate-600 dark:text-slate-400 mb-4">Buat kontrak pertama untuk ditampilkan di
                            dashboard</p>
                        <a href="{{ route('contracts.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-cyan-600 transition">
                            <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                            Buat Kontrak Baru
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
@endsection
