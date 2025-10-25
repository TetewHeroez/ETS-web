<!-- Modal Edit Metode -->
<div id="modalEditMetode" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full">
        <form id="formEditMetode" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="gdk_materi_id" id="edit_gdk_materi_id">
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100 mb-4">Edit Metode</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama
                            Metode</label>
                        <input type="text" name="nama_metode" id="edit_nama_metode" required
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 dark:bg-slate-700 dark:text-slate-100 transition">
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi_metode" rows="2"
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 dark:bg-slate-700 dark:text-slate-100 transition"></textarea>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Multiplier</label>
                        <input type="number" name="multiplier" id="edit_multiplier_metode" step="0.01"
                            min="0" required
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 dark:bg-slate-700 dark:text-slate-100 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">PA
                            (Performance
                            Appraisal)</label>
                        <input type="text" name="pa" id="edit_pa_metode"
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 dark:bg-slate-700 dark:text-slate-100 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">PI
                            (Performance Indicator)</label>
                        <input type="text" name="pi" id="edit_pi_metode"
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 dark:bg-slate-700 dark:text-slate-100 transition">
                    </div>
                </div>
            </div>
            <div
                class="p-4 bg-slate-50 dark:bg-slate-700 border-t border-slate-200 dark:border-slate-600 flex justify-end gap-2">
                <button type="button" onclick="closeModalEditMetode()"
                    class="px-4 py-2 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 dark:bg-green-700 text-white rounded-lg hover:bg-green-700 dark:hover:bg-green-800 transition">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalEditMetode(metode) {
        document.getElementById('edit_gdk_materi_id').value = metode.gdk_materi_id;
        document.getElementById('edit_nama_metode').value = metode.nama_metode;
        document.getElementById('edit_deskripsi_metode').value = metode.deskripsi || '';
        document.getElementById('edit_multiplier_metode').value = metode.multiplier;
        document.getElementById('edit_pa_metode').value = metode.pa || '';
        document.getElementById('edit_pi_metode').value = metode.pi || '';
        document.getElementById('formEditMetode').action = `/gdk/metode/${metode.id}`;
        document.getElementById('modalEditMetode').classList.remove('hidden');
    }

    function closeModalEditMetode() {
        document.getElementById('modalEditMetode').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('modalEditMetode')?.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
</script>
