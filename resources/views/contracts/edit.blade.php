@extends('layouts.app')

@section('title', 'Edit Kontrak - MyHIMATIKA')

@section('content')
    @include('components.navbar')
    @include('components.sidebar')

    <main
        class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-slate-50 dark:bg-slate-900 transition-all duration-300">
        <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center gap-4 mb-2">
                    <a href="{{ route('contracts.index') }}"
                        class="p-2 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                        <i data-feather="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-slate-100">Edit Kontrak</h2>
                </div>
                <p class="text-slate-600 dark:text-slate-400 font-body ml-14">Ubah informasi kontrak yang akan ditampilkan
                </p>
            </div>

            <!-- Form -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow border border-slate-200 dark:border-slate-700 p-6">
                <form action="{{ route('contracts.update', $contract) }}" method="POST" id="contractForm">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Judul Kontrak <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" required
                            value="{{ old('title', $contract->title) }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500"
                            placeholder="Contoh: Kontrak Padamu HIMATIKA ITS 2025">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Deskripsi / Pengantar (Opsional)
                        </label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500"
                            placeholder="Dengan ini, setiap peserta Padamu HIMATIKA ITS 2024 menyetujui hal-hal berikut:">{{ old('description', $contract->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rules -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Aturan Kontrak <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mb-3">Tambahkan setiap aturan satu per satu.
                            Klik "Tambah Aturan" untuk menambah aturan baru.</p>

                        <div id="rulesContainer" class="space-y-3 mb-4">
                            @foreach (old('rules', $contract->rules) as $index => $rule)
                                <div class="rule-item flex gap-2">
                                    <span
                                        class="flex-shrink-0 w-8 h-10 bg-gradient-to-br from-blue-600 to-cyan-500 text-white rounded-lg flex items-center justify-center font-bold text-sm rule-number">{{ $index + 1 }}</span>
                                    <input type="text" name="rules[]" required value="{{ $rule }}"
                                        class="flex-1 px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500"
                                        placeholder="Masukkan aturan kontrak">
                                    <button type="button" onclick="removeRule(this)"
                                        class="px-3 py-2 bg-red-600 dark:bg-red-700 text-white rounded-lg hover:bg-red-700 dark:hover:bg-red-800 transition">
                                        <i data-feather="x" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" onclick="addRule()"
                            class="inline-flex items-center px-4 py-2 bg-slate-600 dark:bg-slate-700 text-white font-semibold rounded-lg hover:bg-slate-700 dark:hover:bg-slate-600 transition">
                            <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                            Tambah Aturan
                        </button>

                        @error('rules')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                        <a href="{{ route('contracts.index') }}"
                            class="px-6 py-3 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-700 dark:to-cyan-600 text-white font-bold py-3 rounded-lg hover:from-blue-700 hover:to-cyan-600 dark:hover:from-blue-800 dark:hover:to-cyan-700 transition shadow-lg">
                            <i data-feather="save" class="w-5 h-5 inline mr-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        let ruleCounter = {{ count(old('rules', $contract->rules)) }};

        function addRule() {
            ruleCounter++;
            const container = document.getElementById('rulesContainer');
            const ruleItem = document.createElement('div');
            ruleItem.className = 'rule-item flex gap-2';
            ruleItem.innerHTML = `
                <span class="flex-shrink-0 w-8 h-10 bg-gradient-to-br from-blue-600 to-cyan-500 text-white rounded-lg flex items-center justify-center font-bold text-sm rule-number">${ruleCounter}</span>
                <input type="text" name="rules[]" required 
                    class="flex-1 px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500" 
                    placeholder="Masukkan aturan kontrak">
                <button type="button" onclick="removeRule(this)" 
                    class="px-3 py-2 bg-red-600 dark:bg-red-700 text-white rounded-lg hover:bg-red-700 dark:hover:bg-red-800 transition">
                    <i data-feather="x" class="w-4 h-4"></i>
                </button>
            `;
            container.appendChild(ruleItem);
            feather.replace();
        }

        function removeRule(button) {
            const ruleItem = button.closest('.rule-item');
            ruleItem.remove();
            updateRuleNumbers();
        }

        function updateRuleNumbers() {
            const ruleNumbers = document.querySelectorAll('.rule-number');
            ruleNumbers.forEach((num, index) => {
                num.textContent = index + 1;
            });
            ruleCounter = ruleNumbers.length;
        }

        // Initialize feather icons
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace();
        });
    </script>
@endsection
