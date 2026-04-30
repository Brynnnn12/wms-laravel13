document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('[data-bulk-delete]').forEach(form => {

        const selectAll = form.querySelector('[data-select-all]');
        const checkboxes = form.querySelectorAll('[data-checkbox]');
        const bulkBtn = form.querySelector('[data-delete-button]');

        if (!selectAll || !bulkBtn) return;

        function refreshButton() {
            const checked = form.querySelectorAll('[data-checkbox]:checked').length;

            bulkBtn.classList.toggle('hidden', checked === 0);
        }

        selectAll.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
            refreshButton();
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {

                const checked = form.querySelectorAll('[data-checkbox]:checked').length;

                selectAll.checked = checked === checkboxes.length;
                selectAll.indeterminate =
                    checked > 0 && checked < checkboxes.length;

                refreshButton();
            });
        });

        bulkBtn.addEventListener('click', () => {

            const total = form.querySelectorAll('[data-checkbox]:checked').length;

            if (!total) return;

            const message =
                bulkBtn.dataset.confirmMessage ||
                `Hapus ${total} data terpilih?`;

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

        });

    });

});
