@extends('layouts.app')

@section('title', 'Kumpulkan Tugas - MyPH')

@section('content')
    @include('components.navbar')
    @include('components.sidebar')

    <main
        class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-slate-50 dark:bg-slate-900 transition-all duration-300">
        <div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0">
                <!-- Header -->
                <div class="mb-6">
                    <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-slate-100">Kumpulkan Tugas</h2>
                    <p class="text-slate-600 dark:text-slate-400 font-body">Upload tugas dalam bentuk PDF, foto, atau link
                    </p>
                </div>

                <!-- Success/Error Message -->
                @if (session('success'))
                    <div
                        class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg mb-6 transition-colors duration-300">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg mb-6 transition-colors duration-300">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Form -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-lg shadow border border-slate-200 dark:border-slate-700 p-6 transition-colors duration-300">
                    <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data"
                        id="submissionForm">
                        @csrf

                        <!-- Assignment Selection -->
                        <div class="mb-4">
                            <label for="assignment_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Tugas <span class="text-red-500">*</span>
                            </label>
                            <select name="assignment_id" id="assignment_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                onchange="showAssignmentInfo()">
                                <option value="">-- Pilih Tugas --</option>
                                @foreach ($assignments as $assignment)
                                    <option value="{{ $assignment->id }}" data-description="{{ $assignment->description }}"
                                        data-deadline="{{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y') }}"
                                        {{ old('assignment_id') == $assignment->id ? 'selected' : '' }}>
                                        {{ $assignment->title }}
                                        @if ($assignment->hasSubmissionFrom($user->id))
                                            (✅ Sudah dikumpulkan)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('assignment_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <!-- Assignment Info Box -->
                            <div id="assignmentInfo" class="mt-3 p-4 bg-blue-50 border border-blue-200 rounded-lg hidden">
                                <div class="flex items-start">
                                    <i data-feather="info" class="w-5 h-5 text-blue-600 mr-2 mt-0.5"></i>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 mb-1">Deskripsi Tugas:</p>
                                        <p id="assignmentDescription" class="text-sm text-gray-700 mb-2"></p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Deadline:</span>
                                            <span id="assignmentDeadline" class="text-red-600"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Type Selection -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tipe Pengumpulan <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-3 gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="type" value="pdf" required class="peer hidden"
                                        onclick="showInput('pdf')">
                                    <div
                                        class="border-2 border-gray-300 rounded-lg p-4 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-300 transition">
                                        <i data-feather="file-text" class="w-8 h-8 mx-auto mb-2 text-gray-600"></i>
                                        <span class="text-sm font-medium">PDF</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="type" value="image" required class="peer hidden"
                                        onclick="showInput('image')">
                                    <div
                                        class="border-2 border-gray-300 rounded-lg p-4 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-300 transition">
                                        <i data-feather="image" class="w-8 h-8 mx-auto mb-2 text-gray-600"></i>
                                        <span class="text-sm font-medium">Foto</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="type" value="link" required class="peer hidden"
                                        onclick="showInput('link')">
                                    <div
                                        class="border-2 border-gray-300 rounded-lg p-4 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-300 transition">
                                        <i data-feather="link" class="w-8 h-8 mx-auto mb-2 text-gray-600"></i>
                                        <span class="text-sm font-medium">Link</span>
                                    </div>
                                </label>
                            </div>
                            @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File Upload (PDF/Image) -->
                        <div id="fileInput" class="mb-4 hidden">
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                                Upload File <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="file" id="file" accept=".pdf,image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-sm text-gray-500 mt-1">Max 10MB</p>
                            @error('file')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Link Input -->
                        <div id="linkInput" class="mb-6 hidden">
                            <label for="link" class="block text-sm font-medium text-gray-700 mb-2">
                                Link URL <span class="text-red-500">*</span>
                            </label>
                            <input type="url" name="link" id="link" placeholder="https://example.com/tugas"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('link')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-lg hover:from-blue-600 hover:to-purple-700 transition font-medium">
                            <i data-feather="send" class="w-4 h-4 inline mr-2"></i>
                            Kumpulkan Tugas
                        </button>
                    </form>
                </div>

                <!-- My Submissions -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-lg shadow border border-slate-200 dark:border-slate-700 p-6 mt-6 transition-colors duration-300">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">Tugas yang Sudah Dikumpulkan
                    </h3>
                    @if ($user->submissions->count() > 0)
                        <div class="space-y-3">
                            @foreach ($user->submissions as $submission)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $submission->assignment->title }}</p>
                                        <p class="text-sm text-gray-600">
                                            @if ($submission->type === 'link')
                                                <i data-feather="link" class="w-3 h-3 inline"></i> Link
                                            @elseif($submission->type === 'pdf')
                                                <i data-feather="file-text" class="w-3 h-3 inline"></i> PDF
                                            @else
                                                <i data-feather="image" class="w-3 h-3 inline"></i> Foto
                                            @endif
                                            · {{ $submission->created_at->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                        ✓ Sudah
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-600 dark:text-slate-400 text-center py-4">Belum ada tugas yang dikumpulkan</p>
                    @endif
                </div>
            </div>
    </main>

    <script>
        function showAssignmentInfo() {
            const select = document.getElementById('assignment_id');
            const selectedOption = select.options[select.selectedIndex];
            const infoBox = document.getElementById('assignmentInfo');
            const descriptionEl = document.getElementById('assignmentDescription');
            const deadlineEl = document.getElementById('assignmentDeadline');

            if (selectedOption.value) {
                const description = selectedOption.getAttribute('data-description');
                const deadline = selectedOption.getAttribute('data-deadline');

                descriptionEl.textContent = description;
                deadlineEl.textContent = deadline;
                infoBox.classList.remove('hidden');

                // Re-render feather icons
                feather.replace();
            } else {
                infoBox.classList.add('hidden');
            }
        }

        function showInput(type) {
            const fileInput = document.getElementById('fileInput');
            const linkInput = document.getElementById('linkInput');

            if (type === 'link') {
                fileInput.classList.add('hidden');
                linkInput.classList.remove('hidden');
                document.getElementById('file').removeAttribute('required');
                document.getElementById('link').setAttribute('required', 'required');
            } else {
                linkInput.classList.add('hidden');
                fileInput.classList.remove('hidden');
                document.getElementById('link').removeAttribute('required');
                document.getElementById('file').setAttribute('required', 'required');
            }
        }
    </script>
    </main>
@endsection
