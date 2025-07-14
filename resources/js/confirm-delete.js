
window.openDeleteModal = function(url) {
    const modal = document.getElementById('delete-confirmation-modal');
    modal.classList.remove('hidden');
    setDeleteUrl(url);
};

window.closeDeleteModal = function() {
    document.getElementById('delete-confirmation-modal').classList.add('hidden');
};

window.openDeleteMultipleModal = function() {
    const modal = document.getElementById('delete-multiple-confirmation-modal');
    modal.classList.remove('hidden');
};

window.closeDeleteMultipleModal = function() {
    document.getElementById('delete-multiple-confirmation-modal').classList.add('hidden');
};

window.openImportModal = function() {
    const modal = document.getElementById('import-modal');
    modal.classList.remove('hidden');
};

window.closeImportModal = function() {
    document.getElementById('import-modal').classList.add('hidden');
};

window.setDeleteUrl = function(url) {
    document.getElementById('confirm-delete').setAttribute('href', url);
};

window.setDeleteMultipleUrl = function(url) {
    document.getElementById('confirm-delete-multiple').setAttribute('href', url);
};

window.initializeCheckboxLogic = function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const countSpan = document.getElementById('selected-count');
    const deleteBtn = document.getElementById('delete-multiple-btn');

    if (!selectAllCheckbox || !countSpan || !deleteBtn) return;

    function updateCount() {
        const selectedCount = document.querySelectorAll('.item-checkbox:checked').length;
        countSpan.textContent = selectedCount;
        deleteBtn.disabled = selectedCount === 0;
    }

    selectAllCheckbox.addEventListener('change', function () {
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateCount();
    });

    checkboxes.forEach(cb => cb.addEventListener('change', updateCount));

    updateCount();
};  

document.addEventListener('DOMContentLoaded', () => {
    window.initializeCheckboxLogic();
    
    const confirmDelete = document.getElementById('confirm-delete');
    if (confirmDelete) {
        confirmDelete.addEventListener('click', window.closeDeleteModal);
    }

    const confirmDeleteMultiple = document.getElementById('confirm-delete-multiple');
    if (confirmDeleteMultiple) {
        confirmDeleteMultiple.addEventListener('click', function() {
            const form = document.getElementById('delete-multiple-form');
            if (form) {
               
                form.querySelectorAll('input[name="ids[]"][type="hidden"]').forEach(e => e.remove());

                document.querySelectorAll('.item-checkbox:checked').forEach(checkbox => {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'ids[]';
                    hidden.value = checkbox.value;
                    form.appendChild(hidden);
                });

                form.submit();
                window.closeDeleteMultipleModal();
            }
        });
    }

    const importFile = document.getElementById('import-file');
    if (importFile) {
        importFile.addEventListener('change', window.openImportModal);
    }
}); 