<!-- Modal Edit Materi -->
<div id="modalEditMateri" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full">
        <form id="formEditMateri" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="gdk_nilai_id" id="edit_gdk_nilai_id">
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100 mb-4">Edit Materi</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama
                            Materi</label>
                        <input type="text" name="nama_materi" id="edit_nama_materi" required
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 dark:bg-slate-700 dark:text-slate-100 transition">
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi_materi" rows="3"
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 dark:bg-slate-700 dark:text-slate-100 transition"></textarea>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Multiplier</label>
                        <input type="number" name="multiplier" id="edit_multiplier_materi" step="0.01"
                            min="0" required
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 dark:bg-slate-700 dark:text-slate-100 transition">
                    </div>
                </div>
            </div>
            <div
                class="p-4 bg-slate-50 dark:bg-slate-700 border-t border-slate-200 dark:border-slate-600 flex justify-end gap-2">
                <button type="button" onclick="closeModalEditMateri()"
                    class="px-4 py-2 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-cyan-600 dark:bg-cyan-700 text-white rounded-lg hover:bg-cyan-700 dark:hover:bg-cyan-800 transition">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalEditMateri(materi) {
        document.getElementById('edit_gdk_nilai_id').value = materi.gdk_nilai_id;
        document.getElementById('edit_nama_materi').value = materi.nama_materi;
        document.getElementById('edit_deskripsi_materi').value = materi.deskripsi || '';
        document.getElementById('edit_multiplier_materi').value = materi.multiplier;
        document.getElementById('formEditMateri').action = `/gdk/materi/${materi.id}`;
        document.getElementById('modalEditMateri').classList.remove('hidden');
    }

    function closeModalEditMateri() {
        document.getElementById('modalEditMateri').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('modalEditMateri')?.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
</script>
