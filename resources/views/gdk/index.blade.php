@extends('layouts.app')

@section('title', 'GDK - Grand Design Kaderisasi')

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
                        <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-slate-100">Grand Design
                            Kaderisasi (GDK)</h2>
                        <p class="text-slate-600 dark:text-slate-400 font-body">Kelola nilai, materi, dan metode program
                            kaderisasi</p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="openModalNilai()"
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-700 dark:to-cyan-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-cyan-600 dark:hover:from-blue-800 dark:hover:to-cyan-700 transition shadow-lg">
                            <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                            Tambah Nilai
                        </button>
                    </div>
                </div>
            </div>

            <!-- Notification Container -->
            <div id="notificationContainer" class="mb-6"></div>

            <!-- Success Message -->
            @if (session('success'))
                <div
                    class="bg-cyan-100 dark:bg-cyan-900/30 border border-cyan-400 dark:border-cyan-600 text-cyan-700 dark:text-cyan-300 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- GDK Hierarchy Table -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow border border-slate-200 dark:border-slate-700 mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100 mb-4">Hierarki Nilai → Materi →
                        Metode</h3>

                    @forelse($nilais as $nilai)
                        <!-- Nilai Container - Mencakup semua isi seperti diagram Venn -->
                        <div
                            class="mb-6 border-l-4 border-blue-500 dark:border-blue-600 rounded-lg bg-slate-50 dark:bg-slate-900/40 shadow p-4">
                            <!-- Nilai Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span
                                            class="px-3 py-1 bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 text-xs font-semibold rounded-full">
                                            NILAI
                                        </span>
                                        <h4 class="text-lg font-bold text-slate-900 dark:text-slate-100">
                                            {{ $nilai->nama_nilai }}</h4>
                                        <span
                                            class="px-2 py-1 bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300 text-xs font-semibold rounded">
                                            ×{{ number_format($nilai->multiplier, 2) }}
                                        </span>
                                    </div>
                                    @if ($nilai->deskripsi)
                                        <p class="ml-0.5 text-sm text-slate-600 dark:text-slate-400">{{ $nilai->deskripsi }}
                                        </p>
                                    @endif
                                </div>
                                <div class="flex gap-2">
                                    <button onclick="openModalMateri({{ $nilai->id }})"
                                        class="p-2 text-cyan-600 dark:text-cyan-400 hover:bg-cyan-100 dark:hover:bg-cyan-900/50 rounded-lg transition"
                                        title="Tambah Materi">
                                        <i data-feather="plus-circle" class="w-4 h-4"></i>
                                    </button>
                                    <button onclick="openModalEditNilai({{ json_encode($nilai) }})"
                                        class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded-lg transition"
                                        title="Edit Nilai">
                                        <i data-feather="edit-2" class="w-4 h-4"></i>
                                    </button>
                                    <form action="{{ route('gdk.nilai.destroy', $nilai) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin hapus nilai ini? Semua materi dan metode terkait akan ikut terhapus!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50 rounded-lg transition"
                                            title="Hapus Nilai">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Materi List -->
                            @if ($nilai->materis->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($nilai->materis as $materi)
                                        <div
                                            class="border-l-4 border-cyan-400 dark:border-cyan-600 pl-3 bg-white dark:bg-slate-900/40 p-3 rounded shadow-sm">
                                            <!-- Materi Header -->
                                            <div class="flex items-start justify-between mb-3">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-3 mb-1">
                                                        <span
                                                            class="px-2 py-1 bg-cyan-100 dark:bg-cyan-900/50 text-cyan-800 dark:text-cyan-300 text-xs font-semibold rounded">
                                                            MATERI
                                                        </span>
                                                        <h5
                                                            class="text-base font-semibold text-slate-900 dark:text-slate-100">
                                                            {{ $materi->nama_materi }}</h5>
                                                        <span
                                                            class="px-2 py-1 bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300 text-xs font-semibold rounded">
                                                            ×{{ number_format($materi->multiplier, 2) }}
                                                        </span>
                                                    </div>
                                                    @if ($materi->deskripsi)
                                                        <p class="text-sm text-slate-600 dark:text-slate-400">
                                                            {{ $materi->deskripsi }}</p>
                                                    @endif
                                                </div>
                                                <div class="flex gap-2">
                                                    <button onclick="openModalMetode({{ $materi->id }})"
                                                        class="p-2 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/50 rounded-lg transition"
                                                        title="Tambah Metode">
                                                        <i data-feather="plus-circle" class="w-4 h-4"></i>
                                                    </button>
                                                    <button onclick="openModalEditMateri({{ json_encode($materi) }})"
                                                        class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded-lg transition"
                                                        title="Edit Materi">
                                                        <i data-feather="edit-2" class="w-4 h-4"></i>
                                                    </button>
                                                    <form action="{{ route('gdk.materi.destroy', $materi) }}"
                                                        method="POST" class="inline"
                                                        onsubmit="return confirm('Yakin hapus materi ini? Semua metode terkait akan ikut terhapus!')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="p-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50 rounded-lg transition"
                                                            title="Hapus Materi">
                                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Metode List -->
                                            @if ($materi->metodes->count() > 0)
                                                <div class="space-y-2 mt-3">
                                                    @foreach ($materi->metodes as $metode)
                                                        <div
                                                            class="border-l-4 border-green-500 dark:border-green-600 pl-3 bg-slate-50 dark:bg-slate-900/50 p-3 rounded">
                                                            <div class="flex items-start justify-between">
                                                                <div class="flex-1">
                                                                    <div class="flex items-center gap-2 mb-1">
                                                                        <span
                                                                            class="px-2 py-1 bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300 text-xs font-semibold rounded">
                                                                            METODE
                                                                        </span>
                                                                        <span
                                                                            class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $metode->nama_metode }}</span>
                                                                        <span
                                                                            class="px-2 py-1 bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300 text-xs font-semibold rounded">
                                                                            ×{{ number_format($metode->multiplier, 2) }}
                                                                        </span>
                                                                        <span
                                                                            class="text-xs text-slate-500 dark:text-slate-400 font-mono">
                                                                            Total:
                                                                            ×{{ number_format($metode->total_multiplier, 2) }}
                                                                        </span>
                                                                    </div>
                                                                    <div
                                                                        class="flex gap-4 text-xs text-slate-600 dark:text-slate-400">
                                                                        @if ($metode->pa)
                                                                            <span><strong>PA:</strong>
                                                                                {{ $metode->pa }}</span>
                                                                        @endif
                                                                        @if ($metode->pi)
                                                                            <span><strong>PI:</strong>
                                                                                {{ $metode->pi }}</span>
                                                                        @endif
                                                                    </div>
                                                                    @if ($metode->deskripsi)
                                                                        <p
                                                                            class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                                                            {{ $metode->deskripsi }}</p>
                                                                    @endif
                                                                </div>
                                                                <div class="flex gap-2 ml-2">
                                                                    <button
                                                                        onclick="openModalEditMetode({{ json_encode($metode) }})"
                                                                        class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded-lg transition"
                                                                        title="Edit Metode">
                                                                        <i data-feather="edit-2" class="w-4 h-4"></i>
                                                                    </button>
                                                                    <form
                                                                        action="{{ route('gdk.metode.destroy', $metode) }}"
                                                                        method="POST" class="inline"
                                                                        onsubmit="return confirm('Yakin hapus metode ini?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="p-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50 rounded-lg transition"
                                                                            title="Hapus Metode">
                                                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-sm text-slate-500 dark:text-slate-400 italic mt-3">Belum ada
                                                    metode</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-slate-500 dark:text-slate-400 italic">Belum ada materi</p>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <i data-feather="database"
                                class="w-16 h-16 mx-auto text-slate-400 dark:text-slate-600 mb-4"></i>
                            <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Belum Ada Nilai</h3>
                            <p class="text-slate-600 dark:text-slate-400 mb-4">Buat nilai pertama untuk memulai</p>
                            <button onclick="openModalNilai()"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-cyan-600 transition">
                                <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                                Tambah Nilai
                            </button>
                        </div>
                    @endforelse
                </div>
                <!-- Flowchart Section -->
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow border border-slate-200 dark:border-slate-700">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100 mb-4">Flowchart Agenda Kegiatan
                        </h3>

                        @if ($flowcharts->isNotEmpty())
                            @php $flowchart = $flowcharts->first(); @endphp
                            <div class="mb-6">
                                <img src="{{ $flowchart->image_path }}" alt="Flowchart"
                                    class="w-full rounded-lg border border-slate-200 dark:border-slate-600 mb-4">

                                <div class="flex gap-3">
                                    <label for="flowchartFileInput"
                                        class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white font-medium rounded-lg hover:bg-blue-700 dark:hover:bg-blue-800 transition cursor-pointer">
                                        <i data-feather="edit-2" class="w-4 h-4 mr-2"></i>
                                        Edit
                                    </label>
                                    <button type="button" onclick="openFlowchartDeleteModal()"
                                        class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-red-600 dark:bg-red-700 text-white font-medium rounded-lg hover:bg-red-700 dark:hover:bg-red-800 transition">
                                        <i data-feather="trash-2" class="w-4 h-4 mr-2"></i>
                                        Hapus
                                    </button>
                                </div>

                                <!-- Hidden file input for update -->
                                <input type="file" id="flowchartFileInput" accept="image/*" style="display: none;">
                            </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i data-feather="image" class="w-16 h-16 mx-auto text-slate-400 dark:text-slate-600 mb-4"></i>
                        <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Belum Ada Flowchart
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 mb-4">Tambahkan flowchart untuk menampilkan agenda
                            kegiatan</p>
                        <label for="flowchartFileInputNew"
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-500 text-white font-semibold rounded-lg hover:from-green-700 hover:to-emerald-600 transition cursor-pointer">
                            <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                            Tambah Flowchart
                        </label>
                        <!-- Hidden file input for create -->
                        <input type="file" id="flowchartFileInputNew" accept="image/*" style="display: none;">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Delete Flowchart Confirmation -->
    <div id="flowchartDeleteModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-sm w-full">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex-shrink-0">
                        <i data-feather="alert-triangle" class="w-6 h-6 text-red-600 dark:text-red-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100">Hapus Flowchart?</h3>
                </div>
                <p class="text-slate-600 dark:text-slate-400 mb-6">Yakin ingin menghapus flowchart ini? Aksi ini tidak
                    dapat dibatalkan.</p>
                <div class="flex gap-3">
                    <button type="button" onclick="closeFlowchartDeleteModal()"
                        class="flex-1 px-4 py-2 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition font-medium">
                        Batal
                    </button>
                    <button type="button" onclick="submitFlowchartDelete()"
                        class="flex-1 px-4 py-2 bg-red-600 dark:bg-red-700 text-white rounded-lg hover:bg-red-700 dark:hover:bg-red-800 transition font-medium">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModalNilai() {
            document.getElementById('modalNilai').classList.remove('hidden');
        }

        function closeModalNilai() {
            document.getElementById('modalNilai').classList.add('hidden');
        }

        function openModalMateri(nilaiId) {
            document.getElementById('materi_nilai_id').value = nilaiId;
            document.getElementById('modalMateri').classList.remove('hidden');
        }

        function closeModalMateri() {
            document.getElementById('modalMateri').classList.add('hidden');
        }

        function openModalMetode(materiId) {
            document.getElementById('metode_materi_id').value = materiId;
            document.getElementById('modalMetode').classList.remove('hidden');
        }

        function closeModalMetode() {
            document.getElementById('modalMetode').classList.add('hidden');
        }

        // Flowchart Delete Modal
        function openFlowchartDeleteModal() {
            document.getElementById('flowchartDeleteModal').classList.remove('hidden');
        }

        function closeFlowchartDeleteModal() {
            document.getElementById('flowchartDeleteModal').classList.add('hidden');
        }

        function submitFlowchartDelete() {
            const flowchartId = '{{ $flowcharts->isNotEmpty() ? $flowcharts->first()->id : '' }}';

            if (!flowchartId) {
                showNotification('Error: Flowchart ID tidak ditemukan', 'error');
                return;
            }

            // Close modal dulu
            closeFlowchartDeleteModal();

            fetch(`/gdk/flowchart/${flowchartId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        return response.json().then(data => {
                            console.error('Error response:', data);
                            throw new Error(data.message ||
                                `HTTP ${response.status}: Error deleting flowchart`);
                        }).catch(e => {
                            throw new Error(`HTTP ${response.status}: ${e.message}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Delete successful:', data);
                    showNotification('Flowchart berhasil dihapus!', 'success');
                    // Reload langsung
                    setTimeout(() => location.reload(), 500);
                })
                .catch(error => {
                    console.error('Delete error:', error);
                    showNotification('Error: ' + error.message, 'error');
                });
        }

        // Notification Helper Function
        function showNotification(message, type = 'success') {
            const container = document.getElementById('notificationContainer');

            // Color schemes for different types
            const types = {
                success: {
                    bg: 'bg-green-100 dark:bg-green-900/30',
                    border: 'border-l-green-500 dark:border-l-green-400',
                    text: 'text-green-700 dark:text-green-300',
                    icon: 'check-circle',
                    color: 'text-green-600 dark:text-green-400'
                },
                error: {
                    bg: 'bg-red-100 dark:bg-red-900/30',
                    border: 'border-l-red-500 dark:border-l-red-400',
                    text: 'text-red-700 dark:text-red-300',
                    icon: 'alert-circle',
                    color: 'text-red-600 dark:text-red-400'
                },
                info: {
                    bg: 'bg-blue-100 dark:bg-blue-900/30',
                    border: 'border-l-blue-500 dark:border-l-blue-400',
                    text: 'text-blue-700 dark:text-blue-300',
                    icon: 'info',
                    color: 'text-blue-600 dark:text-blue-400'
                }
            };

            const config = types[type] || types.success;

            const notification = document.createElement('div');
            notification.className =
                `${config.bg} border-l-4 ${config.border} ${config.text} px-4 py-3 rounded-lg flex items-center justify-between animate-slide-in`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i data-feather="${config.icon}" class="w-5 h-5 mr-3 ${config.color} flex-shrink-0"></i>
                    <p class="font-medium">${message}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="${config.text} hover:opacity-70 transition">
                    <i data-feather="x" class="w-5 h-5"></i>
                </button>
            `;

            container.appendChild(notification);

            // Reload feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }

        // Flowchart file input handling
        document.getElementById('flowchartFileInputNew')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validasi ukuran file (max 5MB)
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (file.size > maxSize) {
                    showNotification(
                        `File terlalu besar! Maksimal 5MB, ukuran file: ${(file.size / 1024 / 1024).toFixed(2)}MB`,
                        'error');
                    return;
                }

                const formData = new FormData();
                formData.append('image', file);
                formData.append('judul', 'Flowchart Agenda Kegiatan');
                formData.append('deskripsi', '');
                formData.append('urutan', '0');
                formData.append('_token', '{{ csrf_token() }}');

                console.log('Starting flowchart upload:', file.name);

                fetch('{{ route('gdk.flowchart.store') }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        console.log('Response status:', response.status, 'Content-Type:', response.headers.get(
                            'content-type'));
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(`HTTP ${response.status}: ${text}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            showNotification('Flowchart berhasil diunggah!', 'success');
                            // Reset file input
                            document.getElementById('flowchartFileInputNew').value = '';
                            // Refresh langsung (notif tetap terlihat sampai halaman ganti)
                            location.reload();
                        } else {
                            showNotification('Error: ' + (data.message || 'Failed to upload'), 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Full fetch error:', error);
                        console.error('Error message:', error.message);
                        showNotification('Error uploading file: ' + error.message, 'error');
                    });
            }
        });

        document.getElementById('flowchartFileInput')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validasi ukuran file (max 5MB)
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (file.size > maxSize) {
                    showNotification(
                        `File terlalu besar! Maksimal 5MB, ukuran file: ${(file.size / 1024 / 1024).toFixed(2)}MB`,
                        'error');
                    return;
                }

                const flowchartId = '{{ $flowcharts->isNotEmpty() ? $flowcharts->first()->id : '' }}';
                const formData = new FormData();
                formData.append('image', file);
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('_method', 'PUT');

                console.log('Starting flowchart update:', file.name, 'ID:', flowchartId);

                fetch(`/gdk/flowchart/${flowchartId}`, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        console.log('Response status:', response.status, 'Content-Type:', response.headers.get(
                            'content-type'));
                        if (!response.ok) {
                            return response.json().then(data => {
                                console.error('Validation errors:', data);
                                throw new Error(JSON.stringify(data.errors || data.message ||
                                    'Unknown error'));
                            }).catch(e => {
                                return response.text().then(text => {
                                    throw new Error(`HTTP ${response.status}: ${text}`);
                                });
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            showNotification('Flowchart berhasil diperbarui!', 'success');
                            // Reset file input
                            document.getElementById('flowchartFileInput').value = '';
                            // Refresh langsung (notif tetap terlihat sampai halaman ganti)
                            location.reload();
                        } else {
                            showNotification('Error: ' + (data.message || 'Failed to update'), 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Full fetch error:', error);
                        console.error('Error message:', error.message);
                        showNotification('Error updating file: ' + error.message, 'error');
                    });
            }
        });

        // Close modals when clicking outside
        document.querySelectorAll('[id^="modal"]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
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

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }
    </style>

    <!-- Include Edit Modals -->
    @include('gdk.modals.edit-nilai')
    @include('gdk.modals.edit-materi')
    @include('gdk.modals.edit-metode')
@endsection
