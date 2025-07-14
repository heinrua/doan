window.openUploadModal = function (url) {
    const modal = document.getElementById('upload-file-modal');
    const form = document.getElementById('upload-excel-form');

    modal.classList.remove('hidden');
    form.reset();
    form.setAttribute('action', url);
    document.getElementById('file-info').classList.add('hidden');
    const error = document.getElementById('upload-error');
    if (error) error.classList.add('hidden');
};

window.closeUploadModal = function () {
    document.getElementById('upload-file-modal').classList.add('hidden');
};

window.fileInput = document.getElementById('dropzone-file');
window.dropzone = document.getElementById('dropzone-area');
window.fileInfo = document.getElementById('file-info');

window.dropzone.addEventListener('click', () => window.fileInput.click());


window.fileInput.addEventListener('change', () => {
    if (window.fileInput.files.length) {
        window.fileInfo.textContent = 'Đã chọn: ' + window.fileInput.files[0].name;
        window.fileInfo.classList.remove('hidden');
    } else {
        window.fileInfo.classList.add('hidden');
    }
});


window.dropzone.addEventListener('dragover', function (e) {
    e.preventDefault();
    window.dropzone.classList.add('border-blue-500', 'bg-blue-50'); 
});

window.dropzone.addEventListener('dragleave', function () {
    window.dropzone.classList.remove('border-blue-500', 'bg-blue-50');
});

window.dropzone.addEventListener('drop', function (e) {
    e.preventDefault();
    window.dropzone.classList.remove('border-blue-500', 'bg-blue-50');

    const files = e.dataTransfer.files;
    if (files.length > 0) {
        window.fileInput.files = files;

        window.fileInfo.textContent = 'Đã chọn: ' + files[0].name;
        window.fileInfo.classList.remove('hidden');
    }
});
