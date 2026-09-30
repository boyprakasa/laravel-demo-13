import Swal from "sweetalert2";

// Konfirmasi (dipakai untuk hapus, dll.)
export const confirmAction = (options = {}) =>
    Swal.fire({
        title: "Yakin?",
        text: "Tindakan ini tidak bisa dibatalkan.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, lanjutkan",
        cancelButtonText: "Batal",
        confirmButtonColor: "#dc3545",
        reverseButtons: false,
        ...options,
    });

// Toast kecil di pojok kanan atas
export const toast = (icon, title) =>
    Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    }).fire({ icon, title });

export default Swal;
