<div id="upload-file-modal" class="fixed inset-0 z-50 hidden" aria-modal="true">
        <div class="fixed inset-0 bg-black/50"></div>
        <div class="flex min-h-screen items-center justify-center">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md z-50 p-6 relative">
                <h2 class="text-xl font-bold mb-4 text-center text-blue-700 flex items-center justify-center gap-2">
                    Tải lên file dữ liệu
                </h2>
                <form id="upload-excel-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="dropzone-file" id="dropzone-area"
                        class="flex flex-col items-center justify-center w-full h-44 border-2 border-dashed rounded-lg cursor-pointer transition hover:border-blue-400 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 mb-4">
                        <svg class="w-12 h-12 mb-2 text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-8m0 0l-3 3m3-3l3 3" /></svg>
                        <span class="text-gray-500 dark:text-gray-300 text-sm">Kéo thả file Excel vào đây hoặc <span class="text-blue-600 underline">chọn file</span></span>
                        <input id="dropzone-file" name="excelFile" type="file" accept=".xls,.xlsx" class="hidden" />
                    </label>
                    <div id="file-info" class="text-center text-sm text-gray-700 dark:text-gray-200 mb-2 hidden"></div>
                    <div id="upload-error" class="text-center text-red-600 text-sm mb-2 hidden"></div>

                    
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" onclick="window.closeUploadModal()" class="px-4 py-2 rounded border text-gray-700 hover:bg-gray-100 bg-white">Hủy</button>
                        <button type="submit" id="btn-upload" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Tải lên</button>
                    </div>
                </form>
            </div>
        </div>
    </div>