import Alpine from "alpinejs";
import $ from "jquery";
import * as bootstrap from "bootstrap";
import Swal, { confirmAction, toast } from "./swal";

window.$ = window.jQuery = $;
window.bootstrap = bootstrap;
window.Swal = Swal;
window.confirmAction = confirmAction;
window.toast = toast;

import DataTable from "datatables.net-bs5";
import "datatables.net-buttons-bs5";
import "datatables.net-select-bs5";
import "datatables.net-buttons/js/buttons.colVis";
import "laravel-datatables-vite";
import JSZip from "jszip";
import "datatables.net-buttons-bs5";
import "datatables.net-buttons/js/buttons.html5.mjs";

DataTable.Buttons.jszip(JSZip);

window.DataTable = DataTable;
window.Alpine = Alpine;
Alpine.start();

const toFieldName = (key) => key.replace(/\.(\w+)/g, "[$1]");
const esc = (text) => $("<div>").text(text).html();

const clearErrors = ($form) => {
    $form.find(".is-invalid").removeClass("is-invalid");
    $form.find(".invalid-feedback.js-error").remove();
};

$(document).on("submit", "form.ajax-form", function (e) {
    e.preventDefault();

    const $form = $(this);
    const $btn = $form.find('[type="submit"]');
    const btnText = $btn.html();

    clearErrors($form);
    $btn.prop("disabled", true).html(
        '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...',
    );

    $.ajax({
        url: $form.attr("action"),
        type: "POST", // PUT/PATCH lewat field _method dari @method()
        data: new FormData(this),
        processData: false,
        contentType: false,
        dataType: "json",
        headers: {
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .done((res) => {
            Swal.fire({
                icon: "success",
                title: "Berhasil",
                text: res.message ?? "Data berhasil disimpan.",
                timer: 1500,
                showConfirmButton: false,
            }).then(() => {
                if (res.redirect) window.location.href = res.redirect;
            });
        })
        .fail((xhr) => {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON?.errors ?? {};

                Object.entries(errors).forEach(([key, messages]) => {
                    const name = toFieldName(key);
                    $form
                        .find(`[name="${name}"], [name="${name}[]"]`)
                        .first()
                        .addClass("is-invalid")
                        .after(
                            `<div class="invalid-feedback js-error">${esc(messages[0])}</div>`,
                        );
                });

                const list = Object.values(errors)
                    .flat()
                    .map((m) => `<li>${esc(m)}</li>`)
                    .join("");

                Swal.fire({
                    icon: "error",
                    title: "Validasi gagal",
                    html: `<ul class="text-start mb-0">${list}</ul>`,
                });
            } else {
                Swal.fire(
                    "Gagal",
                    xhr.responseJSON?.message ?? "Terjadi kesalahan server.",
                    "error",
                );
            }
        })
        .always(() => $btn.prop("disabled", false).html(btnText));
});

// Form: <form data-confirm="Hapus buku ini?">
$(document).on("submit", "form[data-confirm]", function (e) {
    e.preventDefault();
    const form = this;

    confirmAction({ text: $(form).data("confirm") }).then((r) => {
        if (r.isConfirmed) form.submit();
    });
});

// Tombol AJAX: <button class="btn-delete" data-url="..." data-table="book-table">
$(document).on("click", ".btn-delete", function () {
    const { url, table } = $(this).data();

    confirmAction().then((r) => {
        if (!r.isConfirmed) return;

        $.ajax({
            url,
            type: "POST",
            data: {
                _method: "DELETE",
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: (res) => {
                toast("success", res.message ?? "Data dihapus.");
                window.LaravelDataTables?.[table]?.ajax.reload(null, false);
            },
            error: () => toast("error", "Gagal menghapus data."),
        });
    });
});
