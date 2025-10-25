<!-- Modal Edit Nilai -->
<div id="modalEditNilai" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full">
        <form id="formEditNilai" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100 mb-4">Edit Nilai</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama
                            Nilai</label>
                        <input type="text" name="nama_nilai" id="edit_nama_nilai" required
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 dark:bg-slate-700 dark:text-slate-100 transition">
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi_nilai" rows="3"
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 dark:bg-slate-700 dark:text-slate-100 transition"></textarea>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Multiplier</label>
                        <input type="number" name="multiplier" id="edit_multiplier_nilai" step="0.01" min="0"
                            required
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 dark:bg-slate-700 dark:text-slate-100 transition">
                    </div>
                </div>
            </div>
            <div
                class="p-4 bg-slate-50 dark:bg-slate-700 border-t border-slate-200 dark:border-slate-600 flex justify-end gap-2">
                <button type="button" onclick="closeModalEditNilai()"
                    class="px-4 py-2 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-800 transition">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalEditNilai(nilai) {
        document.getElementById('edit_nama_nilai').value = nilai.nama_nilai;
        document.getElementById('edit_deskripsi_nilai').value = nilai.deskripsi || '';
        document.getElementById('edit_multiplier_nilai').value = nilai.multiplier;
        document.getElementById('formEditNilai').action = `/gdk/nilai/${nilai.id}`;
        document.getElementById('modalEditNilai').classList.remove('hidden');
    }

    function closeModalEditNilai() {
        document.getElementById('modalEditNilai').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('modalEditNilai')?.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
</script>
