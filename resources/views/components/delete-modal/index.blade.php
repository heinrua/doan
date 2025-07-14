<div class="fixed inset-0 z-50 hidden" id="delete-confirmation-modal" aria-modal="true">
    <div class="fixed inset-0 bg-black/50"></div>
    <div class="flex min-h-screen items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md z-50 p-6">
            <div class="flex items-start space-x-3">
                <div class="text-red-500">
                    {!! $icons['warning-circle'] !!}
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Xác nhận xoá</h3>
                    <p class="mt-1 text-sm text-gray-600">Xác nhận xóa dữ liệu này?</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-2">
                <button type="button" onclick="closeDeleteModal()" class="bg-white px-4 py-2 rounded border text-gray-700 hover:bg-gray-100">
                    Hủy
                </button>
                <a href="#" id="confirm-delete"
                    class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">
                    Xoá
                </a>
            </div>
        </div>
    </div>
</div>