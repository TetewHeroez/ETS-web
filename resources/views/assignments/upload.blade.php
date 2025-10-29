@extends('layouts.app')

@section('title', 'Kumpulkan Tugas - MyHIMATIKA')

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
                    <p class="text-slate-600 dark:text-slate-400 font-body">
                        @if ($assignment->submission_type === 'pdf')
                            Upload file PDF tugas Anda
                        @elseif ($assignment->submission_type === 'image')
                            Upload foto/gambar tugas Anda
                        @else
                            Kirim link tugas Anda (Google Drive, GitHub, dll)
                        @endif
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

                <!-- Assignment Info -->
                <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">{{ $assignment->title }}</h3>
                    @if ($assignment->description)
                        <p class="text-blue-800 dark:text-blue-200 mb-3">{{ $assignment->description }}</p>
                    @endif
                    <div class="flex flex-wrap gap-4 text-sm text-blue-700 dark:text-blue-300">
                        @if ($assignment->deadline)
                            <span class="flex items-center gap-2">
                                <i data-feather="calendar" class="w-4 h-4"></i>
                                Deadline: {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y, H:i') }}
                            </span>
                        @endif
                        <span class="flex items-center gap-2">
                            <i data-feather="file" class="w-4 h-4"></i>
                            Tipe:
                            @if ($assignment->submission_type === 'pdf')
                                <span class="font-semibold">PDF</span>
                            @elseif ($assignment->submission_type === 'image')
                                <span class="font-semibold">Foto/Gambar</span>
                            @else
                                <span class="font-semibold">Link URL</span>
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Notification Container -->
                <div id="notificationContainer" class="mb-6"></div>

                <!-- Form -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-lg shadow border border-slate-200 dark:border-slate-700 p-6 transition-colors duration-300">
                    <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data"
                        id="submissionForm">
                        @csrf
                        <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">

                        <!-- File/Link Upload -->
                        @if ($assignment->submission_type !== 'link')
                            <div class="mb-6">
                                <label for="file"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Upload File <span class="text-red-500">*</span>
                                </label>

                                <div class="border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-lg p-8 text-center cursor-pointer hover:border-blue-400 dark:hover:border-blue-500 transition"
                                    id="uploadArea">
                                    <i data-feather="upload" class="w-12 h-12 mx-auto text-gray-400 mb-3"></i>
                                    <p class="text-gray-600 dark:text-gray-400 mb-1">
                                        Drag & drop file di sini atau klik untuk memilih
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500">
                                        Max 5MB -
                                        @if ($assignment->submission_type === 'pdf')
                                            Format: PDF
                                        @else
                                            Format: JPG, PNG, GIF, SVG
                                        @endif
                                    </p>
                                </div>

                                <input type="file" name="file" id="file" class="hidden"
                                    @if ($assignment->submission_type === 'pdf') accept=".pdf" @else accept="image/*" @endif required>

                                <!-- File Preview -->
                                <div id="filePreview" class="mt-3 hidden">
                                    <div
                                        class="bg-gray-50 dark:bg-slate-700 rounded-lg p-4 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <i data-feather="file-check" class="w-6 h-6 text-green-500"></i>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100"
                                                    id="fileName"></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400" id="fileSize"></p>
                                            </div>
                                        </div>
                                        <button type="button" class="text-red-500 hover:text-red-700 p-2"
                                            onclick="clearFile()">
                                            <i data-feather="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </div>
                                </div>

                                @error('file')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        @else
                            <!-- Link Input -->
                            <div class="mb-6">
                                <label for="link"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    URL Link <span class="text-red-500">*</span>
                                </label>
                                <input type="url" name="link" id="link"
                                    placeholder="https://drive.google.com/..." value="{{ old('link') }}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                                    required>
                                @error('link')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Notes Input -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Catatan (Opsional)
                            </label>
                            <textarea name="notes" id="notes" rows="3"
                                placeholder="Tambahkan catatan atau penjelasan tambahan untuk tugas ini..."
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 resize-vertical"
                                maxlength="1000">{{ old('notes') }}</textarea>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Maksimal 1000 karakter</p>
                            @error('notes')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-700 dark:to-cyan-600 text-white py-3 rounded-lg hover:from-blue-700 hover:to-cyan-600 dark:hover:from-blue-800 dark:hover:to-cyan-700 transition font-medium shadow-lg">
                            <i data-feather="send" class="w-4 h-4 inline mr-2"></i>
                            Kumpulkan Tugas
                        </button>
                    </form>
                </div>

                <!-- Previous Submission -->
                @if ($previousSubmission = auth()->user()->submissions()->where('assignment_id', $assignment->id)->first())
                    <div
                        class="bg-white dark:bg-slate-800 rounded-lg shadow border border-slate-200 dark:border-slate-700 p-6 mt-6 transition-colors duration-300">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">
                            <i data-feather="check-circle" class="w-5 h-5 inline mr-2 text-green-500"></i>
                            Tugas Sudah Dikumpulkan
                        </h3>
                        <div class="space-y-2 text-sm">
                            <p class="text-gray-600 dark:text-gray-400">
                                <span class="font-medium">Tanggal Pengumpulan:</span>
                                {{ $previousSubmission->created_at->format('d M Y, H:i') }}
                            </p>
                            @if ($previousSubmission->type !== 'link')
                                <div class="mt-2">
                                    @if ($previousSubmission->type === 'image')
                                        <img src="{{ $previousSubmission->content }}" alt="Submitted image"
                                            class="max-w-full h-auto rounded-lg border border-gray-300 dark:border-slate-600">
                                    @elseif ($previousSubmission->type === 'pdf')
                                        <iframe src="{{ $previousSubmission->content }}"
                                            class="w-full h-96 border border-gray-300 dark:border-slate-600 rounded-lg"></iframe>
                                    @endif
                                </div>
                            @else
                                <p class="text-gray-600 dark:text-gray-400">
                                    <span class="font-medium">Link:</span>
                                    <a href="{{ $previousSubmission->content }}" target="_blank"
                                        class="text-blue-600 dark:text-blue-400 hover:underline">
                                        {{ $previousSubmission->content }}
                                        <i data-feather="external-link" class="w-3 h-3 inline ml-1"></i>
                                    </a>
                                </p>
                            @endif
                            @if ($previousSubmission->notes)
                                <p class="text-gray-600 dark:text-gray-400 mt-2">
                                    <span class="font-medium">Catatan:</span>
                                    <span class="italic">{{ $previousSubmission->notes }}</span>
                                </p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <script>
        // Notification system
        function showNotification(message, type = 'info') {
            const container = document.getElementById('notificationContainer');
            const notificationId = 'notif-' + Date.now();

            const typeConfig = {
                success: {
                    icon: 'check-circle',
                    bg: 'bg-green-50 dark:bg-green-900/30',
                    border: 'border-green-300 dark:border-green-600',
                    text: 'text-green-700 dark:text-green-300'
                },
                error: {
                    icon: 'alert-circle',
                    bg: 'bg-red-50 dark:bg-red-900/30',
                    border: 'border-red-300 dark:border-red-600',
                    text: 'text-red-700 dark:text-red-300'
                },
                info: {
                    icon: 'info',
                    bg: 'bg-blue-50 dark:bg-blue-900/30',
                    border: 'border-blue-300 dark:border-blue-600',
                    text: 'text-blue-700 dark:text-blue-300'
                }
            };

            const config = typeConfig[type] || typeConfig.info;

            const notification = document.createElement('div');
            notification.id = notificationId;
            notification.className =
                `${config.bg} border ${config.border} ${config.text} px-4 py-3 rounded-lg flex items-center gap-3 animate-slide-in mb-3`;
            notification.innerHTML = `
                <i data-feather="${config.icon}" class="w-5 h-5 flex-shrink-0"></i>
                <span class="flex-1">${message}</span>
                <button type="button" onclick="document.getElementById('${notificationId}').remove()" class="text-lg hover:opacity-70">
                    ×
                </button>
            `;

            container.appendChild(notification);
            feather.replace();

            setTimeout(() => {
                notification.classList.remove('animate-slide-in');
                notification.classList.add('animate-slide-out');
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // File upload handling
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('file');
        const filePreview = document.getElementById('filePreview');

        if (uploadArea) {
            uploadArea.addEventListener('click', () => fileInput.click());

            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('border-blue-400', 'dark:border-blue-500', 'bg-blue-50',
                    'dark:bg-blue-900/10');
            });

            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('border-blue-400', 'dark:border-blue-500', 'bg-blue-50',
                    'dark:bg-blue-900/10');
            });

            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('border-blue-400', 'dark:border-blue-500', 'bg-blue-50',
                    'dark:bg-blue-900/10');
                fileInput.files = e.dataTransfer.files;
                handleFileSelect();
            });
        }

        fileInput?.addEventListener('change', handleFileSelect);

        function handleFileSelect() {
            const file = fileInput.files[0];
            if (!file) return;

            // Validation: Max 5MB
            const maxSize = 5 * 1024 * 1024;
            if (file.size > maxSize) {
                showNotification('Ukuran file terlalu besar. Maksimal 5MB.', 'error');
                fileInput.value = '';
                filePreview.classList.add('hidden');
                return;
            }

            // Show preview
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('fileSize').textContent = (file.size / 1024).toFixed(2) + ' KB';
            filePreview.classList.remove('hidden');

            // Hide upload area
            uploadArea.classList.add('hidden');
        }

        function clearFile() {
            fileInput.value = '';
            filePreview.classList.add('hidden');
            // Show upload area again
            uploadArea.classList.remove('hidden');
        }

        // Form submission
        document.getElementById('submissionForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML =
                '<i data-feather="loader" class="w-4 h-4 inline mr-2 animate-spin"></i>Mengupload...';

            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Error uploading submission');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    showNotification('Tugas berhasil dikumpulkan!', 'success');
                    setTimeout(() => location.reload(), 1500);
                })
                .catch(error => {
                    showNotification('Error: ' + error.message, 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                    feather.replace();
                });
        });
    </script>

    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }

        .animate-slide-out {
            animation: slideOut 0.3s ease-out;
        }
    </style>
@endsection
