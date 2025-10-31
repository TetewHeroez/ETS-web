// Profile Photo Upload dengan Status Indicator
function validateAndPreviewFile(input, section) {
    const file = input.files[0];
    const fileInfo = document.getElementById(`file-info-${section}`);

    if (!file) {
        fileInfo.textContent = "JPG, PNG, atau GIF (max 2MB)";
        fileInfo.className = "text-xs text-slate-500 dark:text-slate-400 mt-1";
        return;
    }

    // Validate file size (max 2MB)
    const maxSize = 2 * 1024 * 1024; // 2MB
    if (file.size > maxSize) {
        fileInfo.innerHTML =
            "❌ <strong>Gagal:</strong> File terlalu besar (" +
            (file.size / 1024 / 1024).toFixed(2) +
            "MB). Maksimal 2MB.";
        fileInfo.className =
            "text-xs text-red-600 dark:text-red-400 mt-1 font-medium";
        input.value = ""; // Clear input
        return;
    }

    // Validate file type
    const validTypes = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
    if (!validTypes.includes(file.type)) {
        fileInfo.innerHTML =
            "❌ <strong>Gagal:</strong> Format file tidak valid. Hanya JPG, PNG, atau GIF yang diizinkan.";
        fileInfo.className =
            "text-xs text-red-600 dark:text-red-400 mt-1 font-medium";
        input.value = ""; // Clear input
        return;
    }

    // Show success info
    const sizeKB = (file.size / 1024).toFixed(2);
    fileInfo.innerHTML =
        "✅ <strong>Siap diupload:</strong> " +
        file.name +
        " (" +
        sizeKB +
        ' KB) - Klik "Simpan Perubahan"';
    fileInfo.className =
        "text-xs text-green-600 dark:text-green-400 mt-1 font-medium";
}

// Show loading state on form submit
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector('form[action*="profile"]');

    if (form) {
        form.addEventListener("submit", function (e) {
            const memberInput = document.getElementById("profile_photo_member");
            const adminInput = document.getElementById("profile_photo_admin");
            const submitBtn = this.querySelector('button[type="submit"]');

            // Check if file is selected
            if (
                (memberInput && memberInput.files.length > 0) ||
                (adminInput && adminInput.files.length > 0)
            ) {
                // Show uploading status
                const section =
                    memberInput && memberInput.files.length > 0
                        ? "member"
                        : "admin";
                const fileInfo = document.getElementById(
                    `file-info-${section}`
                );

                if (fileInfo) {
                    fileInfo.innerHTML =
                        "⏳ <strong>Sedang mengupload gambar...</strong> Mohon tunggu, jangan tutup halaman ini.";
                    fileInfo.className =
                        "text-xs text-blue-600 dark:text-blue-400 mt-1 font-medium animate-pulse";
                }

                // Disable submit button
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <svg class="animate-spin h-5 w-5 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    `;
                }
            }
        });
    }
});
