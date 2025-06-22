@extends('themes.base')

@section('subhead')
    <title>Hướng dẫn - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-5  flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            <x-base.lucide class="h-8 w-8 mr-2" icon="HelpCircle" />
            Hướng dẫn
        </div>
    </div>
    <div x-data="{ activeTab: 'dashboard' }" class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: FAQ Menu -->
        <div class="intro-y col-span-12 lg:col-span-4 xl:col-span-3">
            <div class="box h-screen overflow-y-auto">
                <div class="p-5 text-base">
                    <a href="javascript:;" class="flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'dashboard' }" @click="activeTab = 'dashboard'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="User" /> Trang chủ
                    </a>
                </div>
                <div class="border-t border-slate-200/60 p-5 dark:border-darkmode-800 text-base">
                    <a href="javascript:;" class="flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'group-user' }"
                        @click="activeTab = 'group-user'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="User" /> Nhóm người dùng
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'user' }" @click="activeTab = 'user'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="User" /> Người dùng
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'role' }" @click="activeTab = 'role'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="User" /> Vai trò
                    </a>
                </div>
                <div class="border-t border-slate-200/60 p-5 dark:border-darkmode-800 text-base">
                    <a href="javascript:;" class="flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'city' }" @click="activeTab = 'city'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Home" /> Tỉnh-Thành
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'district' }" @click="activeTab = 'district'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Home" /> Quận-Huyện
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'commune' }" @click="activeTab = 'commune'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Home" /> Phường-Xã
                    </a>
                </div>
                <div class="border-t border-slate-200/60 p-5 dark:border-darkmode-800 text-base">
                    <a href="javascript:;" class="flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'type-of-calamity' }"
                        @click="activeTab = 'type-of-calamity'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronsRight" /> Loại thiên tai
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'sub-type-of-calamity' }"
                        @click="activeTab = 'sub-type-of-calamity'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronsRight" /> Loại thiên tai phụ
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'risk-level' }"
                        @click="activeTab = 'risk-level'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronsRight" /> Cấp độ thiên tai
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'type-of-construction' }"
                        @click="activeTab = 'type-of-construction'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronsRight" /> Loại công trình
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'scenarios' }"
                        @click="activeTab = 'scenarios'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronsRight" /> Phương án ứng phó
                    </a>
                </div>
                <div class="border-t border-slate-200/60 p-5 dark:border-darkmode-800 text-base">
                    <a href="javascript:;" class="flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'calamity-river-bank' }"
                        @click="activeTab = 'calamity-river-bank'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="CloudRain" />Thiên tai Ngập Lụt
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'calamity-flooding' }"
                        @click="activeTab = 'calamity-flooding'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="AlertTriangle" />Thiên tai ngập lụt
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'calamity-storm' }"
                        @click="activeTab = 'calamity-storm'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="CloudLightning" />Thiên tai bão và ATNĐ
                    </a>
                </div>
                <div class="border-t border-slate-200/60 p-5 dark:border-darkmode-800 text-base">
                    <a href="javascript:;" class="flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'construction-river-bank' }"
                        @click="activeTab = 'construction-river-bank'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="CloudRain" />Công trình sạt lở
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'construction-flooding' }"
                        @click="activeTab = 'construction-flooding'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="AlertTriangle" />Công trình ngập lụt
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'construction-storm' }"
                        @click="activeTab = 'construction-storm'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="CloudLightning" />Công trình bão và ATNĐ
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'construction-school' }"
                        @click="activeTab = 'construction-school'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Aperture" />Công trình trường học
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'construction-medical' }"
                        @click="activeTab = 'construction-medical'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Aperture" />Công trình y tế
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'construction-center' }"
                        @click="activeTab = 'construction-center'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Aperture" />Công trình TTHC và Khác
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'construction-harbors' }"
                        @click="activeTab = 'construction-harbors'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Aperture" />Công trình cảng cá, neo đậu
                    </a>
                    <a href="javascript:;" class="mt-5 flex items-center"
                        :class="{ 'font-medium text-primary': activeTab === 'construction-anchorage-points' }"
                        @click="activeTab = 'construction-anchorage-points'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Aperture" />Công trình kênh - rạch
                    </a>
                </div>
            </div>
        </div>
        <!-- END: FAQ Menu -->

        <!-- BEGIN: FAQ Content -->
        <div class="intro-y col-span-12 lg:col-span-8 xl:col-span-9">
            <!-- Trang chủ -->
            <div x-show="activeTab === 'dashboard'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Báo cáo tổng hợp:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/dashboard/synthetic.png') }}"
                            alt="Báo cáo tổng hợp - PCTT Cà Mau" class="h-60 w-auto" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Hiển thị tổng số thiên tai và tổng công trình của 3 loại thiên tai.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Dữ liệu mới nhất:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/dashboard/new-calamity.png') }}"
                            alt="Dữ liệu mới nhất - PCTT Cà Mau" class="h-60 w-auto" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Hiển thị 5 dữ liệu thiên tai hoặc công trình mới nhất.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Biểu đồ thiên tai:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/dashboard/bieudo-calamity.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-60 w-auto" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Biểu đồ hiển thị phần trăm về tổng số lượng thiên tai bao gồm: Sạt lở - Ngập Lụt - Bão & ATNĐ.
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">4.</span>
                        <span class="font-bold text-primary text-xl">Biểu đồ thiên tai 7 ngày gần nhất:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/dashboard/new-calamity-7days.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-60 w-auto" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Biểu đồ hiển thị thiên tai 7 ngày gần nhất bao gồm: Sạt lở - Ngập lụt - Bão & ATNĐ.
                        </li>
                        <li class="flex items-center space-y-1 space-x-1">
                            <x-base.image-zoom src="/uploads/map/falling_rocks.png" alt="icon" class="w-5 h-5" />
                            <span>Icon biểu thị thiên tai Sạt Lở.</span>
                        </li>
                        <li class="flex items-center space-y-1 space-x-1">
                            <x-base.image-zoom src="/uploads/map/swimming.png" alt="icon" class="w-5 h-5" />
                            <span>Icon biểu thị thiên tai Ngập Lụt.</span>
                        </li>
                        <li class="flex items-center space-y-1 space-x-1">
                            <x-base.image-zoom src="/uploads/map/caution.png" alt="icon" class="w-5 h-5" />
                            <span>Icon biểu thị thiên tai Bão & ATNĐ.</span>
                        </li>
                        <li class="flex items-center space-y-1 space-x-1">
                            <x-base.image-zoom
                                src="{{ Vite::asset('resources/images/faq/dashboard/button-create-new-calamity.png') }}"
                                alt="icon" class="w-15 h-15" />
                            <span>Nút để tạo mới cảnh báo thiên tai.</span>
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">5.</span>
                        <span class="font-bold text-primary text-xl">Mẫu tạo mới cảnh báo thiên tai:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/dashboard/form-create-new.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Biểu đồ hiển thị thiên tai 7 ngày gần nhất bao gồm: Sạt lở - Ngập lụt - Bão & ATNĐ.
                        </li>
                        <li>Cách chọn địa điểm bằng cách chấm điểm trên bản đồ, hoặc có thể dán toạ độ thẳng vào hộp bản đồ.
                        </li>
                        <li>Hộp xã bắt buộc phải tự nhập xã tương ứng với địa điểm - toạ độ tương ứng.
                        </li>
                        <li>Chọn Loại thiên tai -> chọn tác nhân -> chọn cấp độ tương ứng.
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">6.</span>
                        <span class="font-bold text-primary text-xl">Bản đồ hiển thị lượng mưa ở Cà Mau:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/dashboard/map-windy.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Hiển thị lượng mưa ở các xã/phường ở Cà Mau.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Nhóm Người Dùng -->
            <div x-show="activeTab === 'group-user'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Trang danh sách:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/group-user/list.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Hiển thị tên danh sách các nhóm người dùng - mô tả.
                        </li>
                        <li class="flex items-center space-y-1 space-x-1">
                            <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/group-user/search.png') }}"
                                alt="icon" class="w-50 h-10" />
                            <span>Nhập ký tự sau đó bấm nút tìm kếm để lọc ra danh sách tương ứng.</span>
                        </li>
                        <li>Sau khi lọc danh sách tìm kiếm nhưng muốn quay lại trang thái ban đầu -> bấm nút tải lại dữ
                            liệu.
                        </li>
                        <li class="flex items-center space-y-1 space-x-1">
                            <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/group-user/button-create.png') }}"
                                alt="icon" class="w-auto h-10" />
                            <span>Nhấp vào nút để tạo mới nhóm người dùng.</span>
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Trang tạo:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/group-user/create.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Nhập thông tin nhóm người dùng -> chọn vai trò của nhóm người dùng.
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Trang chi tiết/cập nhật:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/group-user/detail.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Mô tả chi tiết 1 nhóm người dùng.
                        </li>
                        <li>Cập nhật :Nhập tên mới nhóm người dùng -> Chọn vai trò mới người dùng -> Lưu.
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">4.</span>
                        <span class="font-bold text-primary text-xl">Xoá 1 nhóm người dùng:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/group-user/delete.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Xoá 1 nhóm người dùng -> xoá tất cả vai trò mà đã thuộc nhóm người dùng đó.
                        </li>
                    </ul>
                </div>
            </div>

            <!--  Người Dùng -->
            <div x-show="activeTab === 'user'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Trang danh sách:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/user/list.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Hiển thị tên danh sách các người dùng - tên đăng nhập của người dùng - thuộc nhóm người dùng
                            nào.
                        </li>
                        <li class="flex items-center space-y-1 space-x-1">
                            <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/user/search.png') }}"
                                alt="icon" class="w-50 h-10" />
                            <span>Nhập ký tự sau đó bấm nút tìm kếm để lọc ra danh sách người dùng tương ứng.</span>
                        </li>
                        <li class="flex items-center space-y-1 space-x-1">
                            <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/user/select-group-user.png') }}"
                                alt="icon" class="w-auto h-20" />
                            <span>Tìm kiếm theo nhóm người dùng bấm nút tìm kếm để lọc ra danh sách người dùng tương
                                ứng.</span>
                        </li>
                        <li>Sau khi lọc danh sách tìm kiếm nhưng muốn quay lại trang thái ban đầu -> bấm nút tải lại dữ
                            liệu.
                        </li>
                        <li class="flex items-center space-y-1 space-x-1">
                            <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/user/button-create.png') }}"
                                alt="icon" class="w-auto h-10" />
                            <span>Nhấp vào nút để tạo mới người dùng.</span>
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Trang tạo:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/user/create.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Nhập thông tin người dùng -> chọn nhóm người dùng.
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Trang chi tiết/cập nhật:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/user/detail.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Mô tả chi tiết 1 người dùng.
                        </li>
                        <li>Cập nhật :Nhập tên mới người dùng -> Chọn mới nhóm người dùng -> Lưu.
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">4.</span>
                        <span class="font-bold text-primary text-xl">Xoá 1 nhóm người dùng:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/user/delete.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Xoá mọi thông tin liên quan đến người dùng (không khôi phục được).
                        </li>
                    </ul>
                </div>
            </div>

            <!--  Vai trò -->
            <div x-show="activeTab === 'role'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Trang danh sách:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/role/list.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Hiển thị tên danh sách các vai trò - và các quyền của từng vai trò.
                        </li>
                        <li class="flex items-center space-y-1 space-x-1">
                            <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/role/search.png') }}"
                                alt="icon" class="w-50 h-10" />
                            <span>Nhập ký tự sau đó bấm nút tìm kếm để lọc ra danh sách vai trò tương ứng.</span>
                        </li>


                        <li>Sau khi lọc danh sách tìm kiếm nhưng muốn quay lại trang thái ban đầu -> bấm nút tải lại dữ
                            liệu.
                        </li>
                        <li class="flex items-center space-y-1 space-x-1">
                            <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/role/button-create.png') }}"
                                alt="icon" class="w-auto h-10" />
                            <span>Nhấp vào nút để tạo mới vai trò.</span>
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Trang tạo:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/role/create.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Nhập thông tin vai trò - mô tả -> chọn quyền cho người dùng.
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Thêm quyền cho vai trò:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/role/permission-for-role.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Một vài cho sẽ có quyền tương ứng để có thể truy cập/không truy cập vào trang được chỉ định.
                        </li>
                        <li class="flex items-center space-y-1 space-x-1">
                            <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/role/all-permission.png') }}"
                                alt="icon" class="w-50 h-20" />
                            <span>Nhấn vào nút này sẽ chọn tất cả các quyền.</span>
                        </li>

                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">4.</span>
                        <span class="font-bold text-primary text-xl">Trang chi tiết/cập nhật vai trò:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/role/detail.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Sửa thông tin vai trò.
                        </li>
                        <li>Thêm hoặc sửa các quyền của vai trò -> Lưu.
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">5.</span>
                        <span class="font-bold text-primary text-xl">Xoá vai trò:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/role/delete.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Xoá mọi thông tin liên quan đến vai trò và tất cả quyền của vai trò (không khôi phục được).
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tỉnh-Thành -->
            <div x-show="activeTab === 'city'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Trang danh sách:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/city/list.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Hiển thị tên danh sách các tỉnh/thành.
                        </li>
                        <li class="flex items-center space-y-1 space-x-1">
                            <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/city/button-create.png') }}"
                                alt="icon" class="w-auto h-10" />
                            <span>Nhấp vào nút để tạo mới tỉnh/thành.</span>
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Trang tạo:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/city/create.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Nhập thông tin tỉnh/thành - mô tả.
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Trang chi tiết/cập nhật tỉnh/thành:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/city/detail.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Sửa thông tin tỉnh/thành -> Lưu.
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">4.</span>
                        <span class="font-bold text-primary text-xl">Xoá tỉnh/thành:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/city/delete.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Xoá mọi thông tin liên quan đến tỉnh/thành(không khôi phục được).
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Quận/Huyện -->
            <div x-show="activeTab === 'district'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Trang danh sách:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/district/list.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Hiển thị tên danh sách các quận/huyện - mã - thuộc tỉnh/thành - toạ độ - sức chứa - lớp bản đồ.
                        </li>
                        <li class="flex items-center space-y-1 space-x-1">
                            <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/district/search.png') }}"
                                alt="icon" class="w-auto h-10" />
                            <span>Loại tìm kiếm - nhập tên quận/huyện -> tìm kiếm -> hiển thị ra danh sách tương ứng.</span>
                        </li>
                        <li class="flex items-center space-y-1 space-x-1">
                            <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/district/select-search.png') }}"
                                alt="icon" class="w-auto h-13" />
                            <span>Loại tìm kiếm tương ứng.</span>
                        </li>
                        <li class="flex items-center space-y-1 space-x-1">
                            <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/district/button-create.png') }}"
                                alt="icon" class="w-auto h-10" />
                            <span>Nhấp vào nút để tạo mới quận/huyện.</span>
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Trang tạo:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/district/create.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Nhập thông tin quận/huyện - mô tả.
                        </li>
                        <li>Mã là mã của quận/huyện
                        </li>
                        <li>Toạ độ được đặt ở trung tâm quân/huyện
                        </li>
                        <li>Sức chứa có nghĩa khi thiên tai xảy ra quận/huyện có thể chứa được bao nhiêu dân.
                        </li>
                        <li>Lớp bản đồ được tải lên là tệp tin có đuôi file là kml hoặc kmz, nhưng mặc định là đuôi kml.
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Trang chi tiết/cập nhật quận/huyện:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/district/detail.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Sửa thông tin quận/huyện -> Lưu.
                        </li>
                        <li>Mã là mã của quận/huyện
                        </li>
                        <li>Toạ độ được đặt ở trung tâm quân/huyện
                        </li>
                        <li>Sức chứa có nghĩa khi thiên tai xảy ra quận/huyện có thể chứa được bao nhiêu dân.
                        </li>
                        <li>Lớp bản đồ được tải lên là tệp tin có đuôi file là kml hoặc kmz, nhưng mặc định là đuôi kml.
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">4.</span>
                        <span class="font-bold text-primary text-xl">Xoá quận/huyện:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/district/delete.png') }}"
                            alt="Biểu đồ thiên tai - PCTT Cà Mau" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Xoá mọi thông tin liên quan đến quận/huyện(không khôi phục được).
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Xã/Phường -->
            <div x-show="activeTab === 'commune'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Trang danh sách xã/phường:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/commune/list.png') }}"
                            alt="Trang danh sách xã/phường" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang hiển thị danh sách các xã/phường bao gồm: mã, tên xã/phường, quận/huyện trực thuộc, tọa
                            độ.</li>
                        <li class="flex items-center space-x-2">
                            <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/commune/search.png') }}"
                                alt="Tìm kiếm xã/phường" class="w-auto h-10" />
                            <span>Sử dụng bộ lọc theo huyện, loại tìm kiếm và ô nhập từ khóa để lọc nhanh danh sách
                                xã/phường.</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/commune/select-search-1.png') }}"
                                alt="Chọn loại tìm kiếm" class="w-auto h-13" />
                            <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/commune/select-search-2.png') }}"
                                alt="Chọn loại tìm kiếm" class="w-auto h-13" />
                            <span>Chọn tiêu chí tìm kiếm phù hợp (theo tên, mã, v.v) để thu hẹp kết quả.</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/commune/button-create.png') }}"
                                alt="Nút thêm mới" class="w-auto h-10" />
                            <span>Nhấn nút <strong>“Thêm Mới Xã Phường”</strong> để mở form tạo mới bản ghi.</span>
                        </li>
                        <li>Ở cột <strong>Hành động</strong>, bạn có thể chọn <span
                                class="text-blue-600 font-medium">Sửa</span> để cập nhật thông tin hoặc <span
                                class="text-red-600 font-medium">Xoá</span> để xóa xã/phường khỏi hệ thống.</li>
                        <li>Cuối trang là thanh phân trang, cho phép chuyển giữa các trang nếu có nhiều dữ liệu.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Trang tạo xã/phường:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/commune/create.png') }}"
                            alt="Form tạo xã/phường" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang dùng để nhập thông tin và thêm mới một xã/phường vào hệ thống.</li>
                        <li><strong>Tên Xã Phường</strong> <span class="text-red-500">*</span>: Nhập tên đầy đủ của
                            xã/phường (bắt buộc).</li>
                        <li><strong>Mã</strong> <span class="text-red-500">*</span>: Nhập mã định danh cho xã/phường theo
                            quy định (bắt buộc).</li>
                        <li><strong>Tọa Độ</strong> <span class="text-red-500">*</span>: Nhập tọa độ địa lý dạng
                            <code>lat,long</code> để định vị xã/phường trên bản đồ (bắt buộc).
                        </li>
                        <li><strong>Quận Huyện</strong> <span class="text-red-500">*</span>: Chọn quận/huyện mà xã/phường
                            trực thuộc từ danh sách có sẵn (bắt buộc).</li>
                        <li>Sau khi điền đầy đủ thông tin, nhấn nút <span class="font-semibold text-primary">"Lưu"</span>
                            để hoàn tất việc thêm mới.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Trang chi tiết / cập nhật xã/phường:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/commune/detail.png') }}"
                            alt="Form cập nhật xã/phường" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang hiển thị thông tin chi tiết của xã/phường và cho phép cập nhật nếu người dùng có quyền
                            chỉnh sửa.</li>
                        <li><strong>Tên Xã Phường</strong>: Có thể sửa đổi tên xã/phường nếu cần cập nhật.</li>
                        <li><strong>Mã</strong>: Mã định danh có thể được thay đổi nếu cần điều chỉnh theo quy chuẩn mới.
                        </li>
                        <li><strong>Tọa Độ</strong>: Có thể cập nhật lại tọa độ nếu vị trí xã/phường thay đổi hoặc bị nhập
                            sai.</li>
                        <li><strong>Quận Huyện</strong>: Có thể chọn lại nếu xã/phường được điều chuyển đơn vị hành chính.
                        </li>
                        <li>Nút <span class="font-semibold text-primary">"Lưu"</span> dùng để lưu thông tin đã chỉnh sửa.
                        </li>
                        <li>Nút <span class="font-semibold text-gray-500">"Huỷ Bỏ"</span> dùng để quay lại trang trước mà
                            không lưu thay đổi.</li>
                    </ul>
                </div>
            </div>

            <!-- Loại hình thiên tai -->
            <div x-show="activeTab === 'type-of-calamity'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Trang danh sách loại hình thiên tai:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/type-of-calamity/list.png') }}"
                            alt="Danh sách loại hình thiên tai" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang hiển thị toàn bộ danh sách các loại hình thiên tai đang được quản lý trong hệ thống.</li>
                        <li>Người dùng có thể <strong>tìm kiếm</strong> loại hình thiên tai bằng từ khóa tên hoặc mô tả.
                        </li>
                        <li>Thông tin hiển thị gồm:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>STT</strong></li>
                                <li><strong>Loại thiên tai</strong>: Tên gọi chính thức.</li>
                                <li><strong>Mô tả</strong>: Thuyết minh chi tiết về loại thiên tai đó.</li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-primary">"Tạo Mới Loại Hình Thiên Tai"</span> dùng để thêm
                            mới một loại thiên tai mới.</li>
                        <li>Mỗi dòng dữ liệu có các hành động:
                            <ul class="list-disc list-inside ml-5">
                                <li><span class="text-blue-600 font-medium">Sửa</span>: chỉnh sửa thông tin.</li>
                                <li><span class="text-red-600 font-medium">Xoá</span>: xóa loại thiên tai khỏi hệ thống
                                    (sau khi xác nhận).</li>
                            </ul>
                        </li>
                        <li>Thông báo tổng số loại thiên tai giúp người dùng dễ theo dõi quy mô dữ liệu.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Trang tạo loại hình thiên tai:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/type-of-calamity/create.png') }}"
                            alt="Tạo loại hình thiên tai" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang cho phép người dùng <strong>thêm mới một loại hình thiên tai</strong> vào hệ thống.</li>
                        <li>Thông tin cần nhập gồm:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên loại hình thiên tai</strong> (bắt buộc): ít nhất 5 ký tự.</li>
                                <li><strong>Mô tả</strong>: nội dung giải thích rõ về loại thiên tai (tối thiểu 5 ký tự).
                                </li>
                            </ul>
                        </li>
                        <li>Phần nhập liệu được gom trong nhóm <span class="font-medium text-gray-700">"Thông Tin Loại Hình
                                Thiên Tai"</span> với khả năng thu gọn/mở rộng.</li>
                        <li>Nút <span class="text-primary font-semibold">"Lưu"</span> dùng để gửi biểu mẫu và thêm loại
                            thiên tai mới vào hệ thống.</li>
                        <li>Hệ thống sẽ hiển thị thông báo lỗi nếu người dùng không nhập đủ điều kiện (ví dụ: dưới 5 ký tự).
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Trang chi tiết/cập nhật loại hình thiên tai:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/type-of-calamity/detail.png') }}"
                            alt="Cập nhật loại hình thiên tai" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>chỉnh sửa thông tin của một loại hình thiên tai</strong>
                            đã có trong hệ thống.</li>
                        <li>Thông tin sẽ được <strong>tự động điền sẵn</strong> để người dùng dễ dàng cập nhật:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên loại hình thiên tai</strong>: bắt buộc, ít nhất 5 ký tự.</li>
                                <li><strong>Mô tả</strong>: yêu cầu tối thiểu 5 ký tự.</li>
                            </ul>
                        </li>
                        <li>Phần nội dung được gom lại trong nhóm <span class="font-medium text-gray-700">"Thông Tin Loại
                                Hình Thiên Tai"</span>, có thể thu gọn/mở rộng.</li>
                        <li>Nút <span class="text-primary font-semibold">"Lưu"</span> để xác nhận cập nhật. Nút <span
                                class="font-medium text-gray-600">"Huỷ Bỏ"</span> để quay lại mà không thay đổi dữ liệu.
                        </li>
                        <li>Hệ thống sẽ kiểm tra tính hợp lệ của dữ liệu trước khi lưu thay đổi.</li>
                    </ul>
                </div>

            </div>

            <!-- SUB Loại hình thiên tai -->
            <div x-show="activeTab === 'sub-type-of-calamity'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Trang danh sách loại hình thiên tai phụ:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/sub-type-of-calamity/list.png') }}"
                            alt="Danh sách loại hình thiên tai phụ" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này hiển thị <strong>toàn bộ danh sách loại thiên tai phụ</strong>, được phân loại theo
                            <strong>loại thiên tai chính</strong>.
                        </li>
                        <li>Người dùng có thể tìm kiếm bằng:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Loại thiên tai</strong> (dropdown chọn loại chính)</li>
                                <li><strong>Tên loại thiên tai phụ</strong> (ô nhập từ khóa)</li>
                            </ul>
                        </li>
                        <li>Hiển thị tổng số loại thiên tai phụ hiện có.</li>
                        <li>Bảng dữ liệu gồm các cột:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>#</strong>: số thứ tự</li>
                                <li><strong>Loại thiên tai</strong>: loại chính liên kết</li>
                                <li><strong>Loại thiên tai phụ</strong>: tên loại phụ</li>
                                <li><strong>Mô tả</strong>: thông tin chi tiết</li>
                                <li><strong>Hành động</strong>: gồm nút <span class="text-primary font-semibold">Sửa</span>
                                    và <span class="text-red-500 font-semibold">Xoá</span></li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Tạo Loại Thiên Tai
                                Phụ</span> ở góc phải cho phép thêm mới.</li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Tải lại dữ liệu</span>
                            giúp làm mới danh sách sau khi thêm/sửa/xóa.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Trang tạo / chỉnh sửa loại hình thiên tai phụ:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/sub-type-of-calamity/create.png') }}"
                            alt="Tạo hoặc chỉnh sửa loại thiên tai phụ" class="h-72 w-auto" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang dùng để <strong>tạo mới hoặc chỉnh sửa</strong> thông tin loại hình thiên tai phụ.</li>
                        <li>Thông tin nhập gồm:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên Loại Hình Thiên Tai Phụ</strong> <span class="text-red-500">*</span>: yêu
                                    cầu nhập ít nhất 5 ký tự.</li>
                                <li><strong>Mô Tả</strong>: mô tả chi tiết, không bắt buộc nhưng cũng yêu cầu tối thiểu 5 ký
                                    tự nếu có nhập.</li>
                                <li><strong>Loại Hình Thiên Tai</strong> <span class="text-red-500">*</span>: dropdown chọn
                                    loại thiên tai chính liên kết.</li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> ở góc dưới
                            giúp lưu lại dữ liệu.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Trang cập nhật loại hình thiên tai phụ:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/sub-type-of-calamity/detail.png') }}"
                            alt="Cập nhật loại hình thiên tai phụ" class="h-72 w-auto" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này dùng để <strong>chỉnh sửa thông tin loại thiên tai phụ</strong> đã có sẵn trong hệ
                            thống.</li>
                        <li>Các trường thông tin hiển thị tương tự như trang tạo mới:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên Loại Hình Thiên Tai Phụ</strong>: đã có giá trị cũ, có thể chỉnh sửa.</li>
                                <li><strong>Mô Tả</strong>: nếu có mô tả cũ thì cũng hiển thị để sửa.</li>
                                <li><strong>Loại Hình Thiên Tai</strong>: dropdown đã chọn đúng giá trị hiện tại, cho phép
                                    thay đổi.</li>
                            </ul>
                        </li>
                        <li>Ngoài nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span>, còn
                            có nút <span class="font-semibold border px-4 py-1 rounded">Huỷ Bỏ</span> để quay lại mà không
                            lưu thay đổi.</li>
                    </ul>
                </div>
            </div>

            <!--cấp độ thiên tai -->
            <div x-show="activeTab === 'risk-level'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Trang danh sách cấp độ thiên tai:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/risk-level/list.png') }}"
                            alt="Danh sách cấp độ thiên tai" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này hiển thị <strong>toàn bộ danh sách cấp độ thiên tai</strong>, được phân loại theo
                            <strong>tên loại thiên tai</strong>.
                        </li>
                        <li>Người dùng có thể tìm kiếm bằng:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Loại thiên tai</strong> (dropdown chọn loại thiên tai)</li>
                                <li><strong>Tên cấp độ thiên tai</strong> (ô nhập từ khóa)</li>
                            </ul>
                        </li>
                        <li>Hiển thị tổng số cấp độ thiên tai hiện có.</li>
                        <li>Bảng dữ liệu gồm các cột:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>#</strong>: số thứ tự</li>
                                <li><strong>Tên loại thiên tai</strong>: tên loại thiên tai liên kết</li>
                                <li><strong>Tên cấp độ</strong>: tên cấp độ thiên tai</li>
                                <li><strong>Mô tả</strong>: thông tin chi tiết về cấp độ thiên tai</li>
                                <li><strong>Hành động</strong>: gồm nút <span class="text-primary font-semibold">Sửa</span>
                                    và <span class="text-red-500 font-semibold">Xoá</span></li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Tạo Mới Cấp Độ Thiên
                                Tai</span> ở góc phải cho phép thêm mới cấp độ thiên tai.</li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Tải lại dữ liệu</span>
                            giúp làm mới danh sách sau khi thêm/sửa/xóa.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Tạo mới cấp độ thiên tai:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/risk-level/create.png') }}"
                            alt="Danh sách cấp độ thiên tai" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>thêm mới cấp độ thiên tai</strong>.</li>
                        <li>Thông tin cần nhập bao gồm:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên cấp độ thiên tai</strong> (bắt buộc): Nhập tên cấp độ thiên tai, tối thiểu 5
                                    ký tự.</li>
                                <li><strong>Mô tả</strong> (bắt buộc): Cung cấp thông tin chi tiết về cấp độ thiên tai, tối
                                    thiểu 5 ký tự.</li>
                                <li><strong>Loại hình thiên tai</strong> (bắt buộc): Chọn loại hình thiên tai từ danh sách
                                    dropdown.</li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> ở góc phải
                            cho phép lưu thông tin cấp độ thiên tai mới.</li>
                    </ul>
                </div>

                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Trang cập nhật cấp độ thiên tai:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/risk-level/detail.png') }}"
                            alt="Cập nhật cấp độ thiên tai" class="h-72 w-auto" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này dùng để <strong>chỉnh sửa thông tin loại thiên tai phụ</strong> đã có sẵn trong hệ
                            thống.</li>
                        <li>Các trường thông tin hiển thị tương tự như trang tạo mới:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên cấp độ thiên tai</strong>: đã có giá trị cũ, có thể chỉnh sửa.</li>
                                <li><strong>Mô Tả</strong>: nếu có mô tả cũ thì cũng hiển thị để sửa.</li>
                                <li><strong>Loại Hình Thiên Tai</strong>: dropdown đã chọn đúng giá trị hiện tại, cho phép
                                    thay đổi.</li>
                            </ul>
                        </li>
                        <li>Ngoài nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span>, còn
                            có nút <span class="font-semibold border px-4 py-1 rounded">Huỷ Bỏ</span> để quay lại mà không
                            lưu thay đổi.</li>
                    </ul>
                </div>
            </div>

            <!--loại công trình -->
            <div x-show="activeTab === 'type-of-construction'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Trang danh sách loại công trình:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/type-of-construction/list.png') }}"
                            alt="Danh sách loại công trình" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này hiển thị <strong>toàn bộ danh sách loại công trình</strong>, được phân loại theo
                            <strong>tên loại thiên tai</strong>.
                        </li>
                        <li>Người dùng có thể tìm kiếm bằng:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Loại thiên tai</strong> (dropdown chọn loại thiên tai)</li>
                                <li><strong>Tên loại công trình</strong> (ô nhập từ khóa)</li>
                            </ul>
                        </li>
                        <li>Hiển thị tổng số loại công trình hiện có.</li>
                        <li>Bảng dữ liệu gồm các cột:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>#</strong>: số thứ tự</li>
                                <li><strong>Tên loại thiên tai</strong>: tên loại thiên tai liên kết</li>
                                <li><strong>Tên cấp độ</strong>: tên loại công trình</li>
                                <li><strong>Mô tả</strong>: thông tin chi tiết về loại công trình</li>
                                <li><strong>Hành động</strong>: gồm nút <span class="text-primary font-semibold">Sửa</span>
                                    và <span class="text-red-500 font-semibold">Xoá</span></li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Tạo Mới loại công
                                trình</span> ở góc phải cho phép thêm mới loại công trình.</li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Tải lại dữ liệu</span>
                            giúp làm mới danh sách sau khi thêm/sửa/xóa.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Tạo mới loại công trình:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/type-of-construction/create.png') }}"
                            alt="Danh sách loại công trình" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>thêm mới loại công trình</strong>.</li>
                        <li>Thông tin cần nhập bao gồm:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên loại công trình</strong> (bắt buộc): Nhập tên loại công trình, tối thiểu 5
                                    ký tự.</li>
                                <li><strong>Mô tả</strong> (bắt buộc): Cung cấp thông tin chi tiết về loại công trình, tối
                                    thiểu 5 ký tự.</li>
                                <li><strong>Loại hình thiên tai</strong> (bắt buộc): Chọn loại hình thiên tai từ danh sách
                                    dropdown.</li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> ở góc phải
                            cho phép lưu thông tin loại công trình mới.</li>
                    </ul>
                </div>

                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Trang cập nhật loại công trình:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/type-of-construction/detail.png') }}"
                            alt="Cập nhật loại công trình" class="h-72 w-auto" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này dùng để <strong>chỉnh sửa thông tin loại công trình</strong> đã có sẵn trong hệ
                            thống.</li>
                        <li>Các trường thông tin hiển thị tương tự như trang tạo mới:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên loại công trình</strong>: đã có giá trị cũ, có thể chỉnh sửa.</li>
                                <li><strong>Mô Tả</strong>: nếu có mô tả cũ thì cũng hiển thị để sửa.</li>
                                <li><strong>Loại Hình Thiên Tai</strong>: dropdown đã chọn đúng giá trị hiện tại, cho phép
                                    thay đổi.</li>
                            </ul>
                        </li>
                        <li>Ngoài nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span>, còn
                            có nút <span class="font-semibold border px-4 py-1 rounded">Huỷ Bỏ</span> để quay lại mà không
                            lưu thay đổi.</li>
                    </ul>
                </div>
            </div>

            <!--phương án ứng phó -->
            <div x-show="activeTab === 'scenarios'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Trang danh sách phương án ứng phó:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/scenarios/list.png') }}"
                            alt="Danh sách phương án ứng phó" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này hiển thị <strong>toàn bộ danh sách phương án ứng phó</strong>, được phân loại theo
                            <strong>tên loại thiên tai</strong>.
                        </li>
                        <li>Người dùng có thể tìm kiếm bằng:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Loại thiên tai</strong> (dropdown chọn loại thiên tai)</li>
                                <li><strong>Quận/huyện</strong> (dropdown chọn Quận/huyện)</li>
                                <li><strong>Tên phương án ứng phó</strong> (ô nhập từ khóa)</li>
                            </ul>
                        </li>
                        <li>Hiển thị tổng số phương án ứng phó hiện có.</li>
                        <li>Bảng dữ liệu gồm các cột:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>#</strong>: số thứ tự</li>
                                <li><strong>Tên phương án ứng phó</strong>: tên phương án ứng phó.</li>
                                <li><strong>Mô tả ngắn</strong>: thông tin chi tiết về phương án ứng phó.</li>
                                <li><strong>Tên loại thiên tai</strong>: tên loại thiên tai liên kết.</li>
                                <li><strong>Quận/huyện</strong>: phướng án ứng phó tại quận/huyện.</li>
                                <li><strong>Thời gian cập nhật</strong>: Mô tả về thời gian cập nhật phương án.</li>
                                <li><strong>Mô tả văn bản</strong>: Mô tả về nội dụng file được đính kèm.</li>
                                <li><strong>Tệp tip</strong>: File pdf hoặc docs.</li>
                                <li><strong>Hành động</strong>: gồm nút <span class="text-primary font-semibold">Sửa</span>
                                    và <span class="text-red-500 font-semibold">Xoá</span></li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Thêm mới phương
                                án</span> ở góc phải cho phép thêm mới phương án ứng phó.</li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Tải lại dữ liệu</span>
                            giúp làm mới danh sách sau khi thêm/sửa/xóa.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Tạo mới phương án ứng phó:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/scenarios/create.png') }}"
                            alt="Tạo mới phương án ứng phó" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>thêm mới phương án ứng phó</strong>.</li>
                        <li>Thông tin cần nhập bao gồm:
                            <ul class="list-disc list-inside ml-5 space-y-1">
                                <li><strong>Tên phương án</strong> (bắt buộc): Nhập tên phương án, tối thiểu 5 ký tự.</li>
                                <li><strong>Mô tả ngắn</strong> (bắt buộc): Mô tả tóm tắt về phương án, tối thiểu 5 ký tự.
                                </li>
                                <li><strong>Loại thiên tai</strong> (bắt buộc): Chọn loại thiên tai phù hợp từ danh sách
                                    dropdown.</li>
                                <li><strong>Quận/Huyện</strong> (bắt buộc): Chọn địa bàn áp dụng phương án.</li>
                                <li><strong>Ngày cập nhật</strong> (bắt buộc): Chọn ngày cập nhật thông tin phương án.</li>
                                <li><strong>Trạng thái</strong> (bắt buộc): Chọn trạng thái hiện tại của phương án.</li>
                                <li><strong>Mô tả văn bản</strong>: Nhập nội dung mô tả chi tiết hơn nếu cần.</li>
                                <li><strong>Tệp tin đính kèm</strong>: Có thể tải lên các file dạng PDF hoặc DOCS để bổ sung
                                    tài liệu liên quan.</li>
                            </ul>
                        </li>
                        <li>Sau khi nhập đầy đủ thông tin, nhấn nút
                            <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> ở góc dưới bên
                            phải để hoàn tất việc tạo phương án ứng phó.
                        </li>
                    </ul>
                </div>

                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Cập nhật phương án ứng phó:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/scenarios/detail.png') }}"
                            alt="Cập nhật phương án ứng phó" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>chỉnh sửa thông tin của phương án ứng phó đã có</strong>.
                        </li>
                        <li>Các trường có thể cập nhật bao gồm:
                            <ul class="list-disc list-inside ml-5 space-y-1">
                                <li><strong>Tên phương án</strong> (bắt buộc): Có thể chỉnh sửa tên phương án, tối thiểu 5
                                    ký tự.</li>
                                <li><strong>Mô tả ngắn</strong> (bắt buộc): Sửa thông tin mô tả ngắn, tối thiểu 5 ký tự.
                                </li>
                                <li><strong>Loại thiên tai</strong> (bắt buộc): Có thể thay đổi loại hình thiên tai nếu cần
                                    thiết.</li>
                                <li><strong>Quận/Huyện</strong> (bắt buộc): Cập nhật địa phương áp dụng phương án.</li>
                                <li><strong>Ngày cập nhật</strong> (bắt buộc): Chọn lại ngày cập nhật nếu có thay đổi thông
                                    tin.</li>
                                <li><strong>Trạng thái</strong> (bắt buộc): Chuyển đổi giữa các trạng thái như “Hoạt động”,
                                    “Không hoạt động”,... tùy theo tình hình thực tế.</li>
                                <li><strong>Mô tả văn bản</strong>: Thêm hoặc sửa mô tả chi tiết hơn cho phương án.</li>
                                <li><strong>Tệp tin đính kèm</strong>: Có thể chọn lại hoặc bổ sung tài liệu liên quan
                                    (PDF/DOCS).</li>
                            </ul>
                        </li>
                        <li>Sau khi hoàn tất chỉnh sửa, nhấn nút
                            <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> để cập nhật
                            thông tin.
                        </li>
                        <li>Nếu không muốn lưu thay đổi, có thể nhấn nút
                            <span class="font-semibold text-slate-600 bg-gray-200 px-4 py-1 rounded">Huỷ Bỏ</span> để quay
                            lại mà không lưu dữ liệu.
                        </li>
                    </ul>
                </div>

            </div>

            <!--thiên tai Sạt lở  -->
            <div x-show="activeTab === 'calamity-river-bank'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Danh sách thiên tai sạt lở:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/calamity/river-bank/list-1.png') }}"
                            alt="Danh sách thiên tai sạt lở 1" class="h-40 w-auto rounded-lg shadow-md" />
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/calamity/river-bank/list-2.png') }}"
                            alt="Danh sách thiên tai sạt lở 2" class="h-40 w-auto rounded-lg shadow-md" />
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/calamity/river-bank/list-3.png') }}"
                            alt="Danh sách thiên tai sạt lở 3" class="h-40 w-auto rounded-lg shadow-md" />
                    </div>

                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này hiển thị <strong>toàn bộ vị trí sạt lở</strong> đã được cập nhật trong hệ thống.</li>
                        <li>Người dùng có thể <strong>lọc danh sách</strong> theo:
                            <ul class="list-disc list-inside ml-5">
                                <li>Năm</li>
                                <li>Huyện</li>
                                <li>Xã</li>
                                <li>Cấp độ thiên tai</li>
                            </ul>
                        </li>
                        <li>Trường tìm kiếm cho phép lọc nhanh theo tên vị trí sạt lở.</li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Tạo Mới Sạt Lở</span>
                            dùng để thêm vị trí mới.</li>
                        <li>Bảng dữ liệu hiển thị các thông tin như:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên vị trí sạt lở</strong></li>
                                <li><strong>Loại sạt lở</strong></li>
                                <li><strong>Cấp độ rủi ro</strong></li>
                                <li><strong>Địa điểm, phường/xã, quận/huyện</strong></li>
                                <li><strong>Chiều dài, chiều rộng, diện tích</strong></li>
                                <li><strong>Thời gian, nguyên nhân, địa chất</strong></li>
                                <li><strong>Đặc điểm thuỷ văn, thiệt hại về người, thiệt hại về tài sản </strong></li>
                                <li><strong>Mức độ, các biện pháp giảm thiểu, chính sách hỗ trợ </strong></li>
                                <li><strong>Bản đồ, hình ảnh, video</strong></li>
                                <li><strong>Hành động</strong>: gồm nút <span class="text-primary font-semibold">Sửa</span>
                                    và <span class="text-red-500 font-semibold">Xoá</span></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Tạo mới sạt lở:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/calamity/river-bank/create.png') }}"
                            alt="Tạo mới sạt lở" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>thêm mới thông tin sạt lở</strong> vào hệ thống.</li>
                        <li>Thông tin cần nhập bao gồm:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Vị trí sạt lở</strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về vị trí xảy ra sạt
                                    lở.</li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Loại hình thiên tai</strong> và <strong>Loại sạt lở</strong> (bắt buộc): Chọn từ
                                    danh sách các loại có sẵn.</li>
                                <li><strong>Cấp độ thiên tai</strong> và <strong>Thời gian</strong> (bắt buộc): Nhập mức độ
                                    và ngày xảy ra sự kiện.</li>
                                <li><strong>Thông tin kích thước</strong> (không bắt buộc): Bao gồm chiều dài, chiều rộng,
                                    diện tích.</li>
                                <li><strong>Nguyên nhân</strong>, <strong>Địa chất</strong>, <strong>Đặc điểm thủy
                                        văn</strong>, <strong>Chính sách hỗ trợ</strong>, <strong>Các biện pháp giảm
                                        thiểu</strong>, <strong>Mức độ</strong>: Nhập thông tin mô tả nếu có.</li>
                                <li><strong>Thiệt hại</strong>: Ghi nhận thiệt hại về người và tài sản nếu có.</li>
                                <li><strong>Đính kèm</strong>: Có thể tải lên lớp bản đồ, hình ảnh và video minh họa (nếu
                                    cần).</li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> ở góc phải
                            cho phép lưu thông tin sạt lở vào hệ thống.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Cập nhật sạt lở:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom
                            src="{{ Vite::asset('resources/images/faq/calamity/river-bank/detail-1.png') }}"
                            alt="Cập nhật sạt lở" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>chỉnh sửa thông tin sạt lở đã có</strong>.</li>
                        <li>Người dùng có thể điều chỉnh hoặc bổ sung các trường sau:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Vị trí sạt lở</strong>, <strong>Tọa độ</strong>, <strong>Địa điểm</strong>,
                                    <strong>Phường/Xã</strong> (bắt buộc): Cho phép sửa vị trí và địa lý cụ thể.
                                </li>
                                <li><strong>Loại hình thiên tai</strong> và <strong>Loại sạt lở</strong>: Có thể thay đổi
                                    nếu thông tin ban đầu chưa chính xác.</li>
                                <li><strong>Cấp độ thiên tai</strong> và <strong>Thời gian</strong>: Điều chỉnh mức độ và
                                    ngày xảy ra sự cố.</li>
                                <li><strong>Kích thước</strong>: Bao gồm chiều rộng, chiều dài và diện tích (đơn vị: mét).
                                </li>
                                <li><strong>Nguyên nhân, Đặc điểm thủy văn, Địa chất</strong>: Ghi rõ nếu có thông tin cập
                                    nhật.</li>
                                <li><strong>Các biện pháp giảm thiểu, Chính sách hỗ trợ</strong>: Bổ sung các biện pháp hoặc
                                    chính sách liên quan.</li>
                                <li><strong>Thiệt hại</strong>: Điều chỉnh thông tin về thiệt hại người và tài sản.</li>
                                <li><strong>Mức độ</strong>: Nhập mô tả mức độ ảnh hưởng nếu cần thiết.</li>
                                <li><strong>Hình ảnh và video</strong>: Có thể thay đổi hoặc cập nhật file minh họa trực
                                    quan.</li>
                                <li><strong>Lớp bản đồ</strong>: Nếu cần, tải lại file lớp bản đồ mới cho điểm sạt lở này.
                                </li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> sẽ lưu các
                            thay đổi đã chỉnh sửa.</li>
                        <li>Nút <span class="font-semibold text-slate-600 bg-slate-200 px-4 py-1 rounded">Huỷ Bỏ</span> để
                            quay lại mà không lưu thay đổi.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">4.</span>
                        <span class="font-bold text-primary text-xl">Bạn đồ trong trang chi tiết cập nhật:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom
                            src="{{ Vite::asset('resources/images/faq/calamity/river-bank/detail-2.png') }}"
                            alt="Cập nhật sạt lở" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Bản đồ hiển thị điểm sạt lở và mô tả của sạt lở.</li>
                        <li>Khi click 1 diểm khác trên bạn đồ (vị trí mới cần thay đổi) thì hộp toạ đoạ - địa chỉ sẽ được
                            cập nhật. Sau đó người dùng phải tự nhập ô xã/phường
                        </li>
                    </ul>
                </div>
            </div>

            <!--thiên tai ngập lụt  -->
            <div x-show="activeTab === 'calamity-flooding'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Danh sách thiên tai ngập lụt:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/calamity/flooding/list-1.png') }}"
                            alt="Danh sách thiên tai ngập lụt 1" class="h-40 w-auto rounded-lg shadow-md" />
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/calamity/flooding/list-2.png') }}"
                            alt="Danh sách thiên tai ngập lụt 2" class="h-40 w-auto rounded-lg shadow-md" />
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/calamity/flooding/list-3.png') }}"
                            alt="Danh sách thiên tai ngập lụt 3" class="h-40 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Hiển thị danh sách các vị trí bị ngập lụt đã được cập nhật vào hệ thống.</li>
                        <li>Cho phép lọc dữ liệu theo năm, huyện, xã, cấp độ thiên tai hoặc tìm kiếm theo tên khu vực.</li>
                        <li>Bảng đầu hiển thị thông tin tổng quan: tên khu vực, loại hình ngập, mức độ, diện tích...</li>
                        <li>Bảng thứ hai (cuộn ngang hoặc ẩn hiện theo giao diện) hiển thị thông tin chi tiết như: thời gian
                            bắt đầu, kết thúc, nguyên nhân gây ngập, thiệt hại về người và tài sản,...</li>
                        <li>Nhấn <span class="font-medium text-primary">"Tạo Mới Ngập Lụt"</span> để thêm mới một vị trí
                            ngập.</li>
                        <li>Nhấn vào dòng dữ liệu để xem chi tiết hoặc chỉnh sửa nếu có quyền.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Tạo mới sạt lở:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/calamity/flooding/create.png') }}"
                            alt="Tạo mới sạt lở" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>thêm mới thông tin ngập lụt</strong> vào hệ thống.</li>
                        <li>Thông tin cần nhập bao gồm:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên khu vực ngập</strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về vị trí xảy ra
                                    ngập lụt.</li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Loại hình thiên tai</strong> và <strong>Loại hình ngập</strong> (bắt buộc)và
                                    <strong>Khoảng ngập lụt</strong> (bắt buộc): Chọn từ
                                    danh sách các loại có sẵn.
                                </li>
                                <li><strong>Cấp độ thiên tai</strong> và <strong>Thời gian bắt đầu, thời gian kết thúc
                                    </strong> (bắt buộc): Nhập mức độ
                                    và ngày xảy ra sự kiện.</li>
                                <li><strong>Thông tin kích thước</strong> (không bắt buộc): Bao gồm mức độ ngập (m)
                                    , diện tích ngập (ha).</li>
                                <li><strong>Nguyên nhân</strong>, <strong>Số dân bị ảnh hưởng</strong>, <strong>Thời gian
                                        nước rút (giờ)
                                    </strong>, <strong>Biện pháp ứng phó
                                    </strong>, <strong>Cơ sở hạ tầng hư hại</strong>, <strong>Thiệt hại về người
                                    </strong>,<strong>Nguồn dữ liệu
                                    </strong>,<strong>Thiệt hại về tài sản
                                    </strong>: Nhập thông tin mô tả nếu có.</li>
                                <li><strong>Đính kèm</strong>: Có thể tải lên lớp bản đồ, hình ảnh và video minh họa (nếu
                                    cần).</li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> ở góc phải
                            cho phép lưu thông tin sạt lở vào hệ thống.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Chi tiết/Cập nhật ngập lụt:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/calamity/flooding/detail-1.png') }}"
                            alt="Cập nhật sạt lở" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>chỉnh sửa thông tin sạt lở đã có</strong>.</li>
                        <li>Người dùng có thể điều chỉnh hoặc bổ sung các trường sau:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên khu vực ngập</strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về vị trí xảy ra
                                    ngập lụt.</li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Loại hình thiên tai</strong> và <strong>Loại hình ngập</strong> (bắt buộc)và
                                    <strong>Khoảng ngập lụt</strong> (bắt buộc): Chọn từ
                                    danh sách các loại có sẵn.
                                </li>
                                <li><strong>Cấp độ thiên tai</strong> và <strong>Thời gian bắt đầu, thời gian kết thúc
                                    </strong> (bắt buộc): Nhập mức độ
                                    và ngày xảy ra sự kiện.</li>
                                <li><strong>Thông tin kích thước</strong> (không bắt buộc): Bao gồm mức độ ngập (m)
                                    , diện tích ngập (ha).</li>
                                <li><strong>Nguyên nhân</strong>, <strong>Số dân bị ảnh hưởng</strong>, <strong>Thời gian
                                        nước rút (giờ)
                                    </strong>, <strong>Biện pháp ứng phó
                                    </strong>, <strong>Cơ sở hạ tầng hư hại</strong>, <strong>Thiệt hại về người
                                    </strong>,<strong>Nguồn dữ liệu
                                    </strong>,<strong>Thiệt hại về tài sản
                                    </strong>: Nhập thông tin mô tả nếu có.</li>
                                <li><strong>Đính kèm</strong>: Có thể tải lên lớp bản đồ, hình ảnh và video minh họa (nếu
                                    cần).</li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> sẽ lưu các
                            thay đổi đã chỉnh sửa.</li>
                        <li>Nút <span class="font-semibold text-slate-600 bg-slate-200 px-4 py-1 rounded">Huỷ Bỏ</span> để
                            quay lại mà không lưu thay đổi.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">4.</span>
                        <span class="font-bold text-primary text-xl">Bạn đồ trong trang chi tiết cập nhật:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/calamity/flooding/detail-2.png') }}"
                            alt="Cập nhật ngập lụt" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Bản đồ hiển thị điểm ngập lụt và mô tả của ngập lụt.</li>
                        <li>Khi click 1 diểm khác trên bạn đồ (vị trí mới cần thay đổi) thì hộp toạ đoạ - địa chỉ sẽ được
                            cập nhật. Sau đó người dùng phải tự nhập ô xã/phường
                        </li>
                    </ul>
                </div>
            </div>

            <!--thiên tai bão  -->
            <div x-show="activeTab === 'calamity-storm'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Danh sách thiên tai bão:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/calamity/storm/list-1.png') }}"
                            alt="Danh sách thiên tai bão 1" class="h-40 w-auto rounded-lg shadow-md" />
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/calamity/storm/list-2.png') }}"
                            alt="Danh sách thiên tai bão 2" class="h-40 w-auto rounded-lg shadow-md" />
                    </div>

                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Hiển thị danh sách các vị trí bão & ATNĐ đã được cập nhật vào hệ thống.</li>
                        <li>Cho phép lọc dữ liệu theo năm, huyện, xã, cấp độ thiên tai hoặc tìm kiếm theo tên khu vực.</li>
                        <li>Bảng đầu hiển thị thông tin tổng quan: tên bão, loại hình. địa phương ảnh hưởng, toạ độ, cấp độ,
                            cấp độ rủi ro thiên tai...</li>
                        <li>Bảng thứ hai (cuộn ngang hoặc ẩn hiện theo giao diện) hiển thị thông tin chi tiết như: thời gian
                            bắt đầu, kết thúc, thiệt hại về người và tài sản, biện pháp ứng phó, lớp bản đồ, hình ảnh,
                            video...</li>
                        <li>Nhấn <span class="font-medium text-primary">"Tạo Mới Bão & ATNĐ"</span> để thêm mới một vị trí
                            bão.</li>
                        <li>Nhấn vào dòng dữ liệu để xem chi tiết hoặc chỉnh sửa nếu có quyền.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Tạo mới bão & ATNĐ:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/calamity/storm/create.png') }}"
                            alt="Tạo mới sạt lở" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>thêm mới thông tin bão và ATNĐ</strong> vào hệ thống.</li>
                        <li>Thông tin cần nhập bao gồm:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên bão</strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về bão.</li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Loại hình thiên tai</strong> và <strong>Loại hình</strong> (bắt buộc): Chọn từ
                                    danh sách các loại có sẵn.</li>
                                <li><strong>Cấp độ thiên tai</strong> và <strong>Thời gian bắt đầu và kết thúc</strong> (bắt
                                    buộc): Nhập mức độ
                                    và ngày xảy ra sự kiện.</li>
                                <li> <strong>Biện pháp ứng phó
                                    </strong>, <strong>Cấp độ
                                    </strong>, <strong>Các biện pháp giảm
                                        thiểu</strong>: Nhập thông tin mô tả nếu có.</li>
                                <li><strong>Thiệt hại</strong>: Ghi nhận thiệt hại về người và tài sản nếu có.</li>
                                <li><strong>Đính kèm</strong>: Có thể tải lên lớp bản đồ, hình ảnh và video minh họa (nếu
                                    cần).</li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> ở góc phải
                            cho phép lưu thông tin bão vào hệ thống.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Cập nhật bão:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/calamity/storm/detail-1.png') }}"
                            alt="Cập nhật bão" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>chỉnh sửa thông tin bão đã có</strong>.</li>
                        <li>Người dùng có thể điều chỉnh hoặc bổ sung các trường sau:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên bão</strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về bão.</li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Loại hình thiên tai</strong> và <strong>Loại hình</strong> (bắt buộc): Chọn từ
                                    danh sách các loại có sẵn.</li>
                                <li><strong>Cấp độ thiên tai</strong> và <strong>Thời gian bắt đầu và kết thúc</strong> (bắt
                                    buộc): Nhập mức độ
                                    và ngày xảy ra sự kiện.</li>
                                <li> <strong>Biện pháp ứng phó
                                    </strong>, <strong>Cấp độ
                                    </strong>, <strong>Các biện pháp giảm
                                        thiểu</strong>: Nhập thông tin mô tả nếu có.</li>
                                <li><strong>Thiệt hại</strong>: Ghi nhận thiệt hại về người và tài sản nếu có.</li>
                                <li><strong>Đính kèm</strong>: Có thể tải lên lớp bản đồ, hình ảnh và video minh họa (nếu
                                    cần).</li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> sẽ lưu các
                            thay đổi đã chỉnh sửa.</li>
                        <li>Nút <span class="font-semibold text-slate-600 bg-slate-200 px-4 py-1 rounded">Huỷ Bỏ</span> để
                            quay lại mà không lưu thay đổi.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">4.</span>
                        <span class="font-bold text-primary text-xl">Bạn đồ trong trang chi tiết cập nhật:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/calamity/storm/detail-2.png') }}"
                            alt="Cập nhật bão" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Bản đồ hiển thị điểm bão và mô tả của bão.</li>
                        <li>Khi click 1 diểm khác trên bạn đồ (vị trí mới cần thay đổi) thì hộp toạ đoạ - địa chỉ sẽ được
                            cập nhật. Sau đó người dùng phải tự nhập ô xã/phường
                        </li>
                    </ul>
                </div>
            </div>

            <!--công trình sạt lở  -->
            <div x-show="activeTab === 'construction-river-bank'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Danh sách công trình sạt lở:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom
                            src="{{ Vite::asset('resources/images/faq/construction/river-bank/list-1.png') }}"
                            alt="Danh sách công trình sạt lở 1" class="h-40 w-auto rounded-lg shadow-md" />
                        <x-base.image-zoom
                            src="{{ Vite::asset('resources/images/faq/construction/river-bank/list-2.png') }}"
                            alt="Danh sách công trình sạt lở 2" class="h-40 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Hiển thị danh sách các vị trí công trình sạt lở đã được cập nhật vào hệ thống.</li>
                        <li>Cho phép lọc dữ liệu theo năm, huyện, xã, cấp độ thiên tai hoặc tìm kiếm theo tên công trình.
                        </li>
                        <li>Bảng đầu hiển thị thông tin tổng quan: tên công trình, loại hình. địa phương ảnh hưởng, tiến độ
                            thực hiện, năm xây dựng,
                            năm hoàn thành, chiều dài (km), chiều rộng (m)...</li>
                        <li>Bảng thứ hai (cuộn ngang hoặc ẩn hiện theo giao diện) hiển thị thông tin chi tiết như: Quy mô,
                            mức độ ảnh hưởng, toạ độ, tổng mức đầu tư, Nguồn vốn , lớp bản đồ, hình ảnh,
                            video...</li>
                        <li>Nhấn <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Tạo Mới CT Sạt
                                lở</span> để thêm mới một vị trí
                            CT Sạt Lở.</li>
                        <li>Nhấn vào dòng dữ liệu để xem chi tiết hoặc chỉnh sửa nếu có quyền.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Tạo mới công trình Sạt Lở:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom
                            src="{{ Vite::asset('resources/images/faq/construction/river-bank/create.png') }}"
                            alt="Tạo mới sạt lở" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>thêm mới thông tin công trình sạt lở</strong> vào hệ
                            thống.</li>
                        <li>Thông tin cần nhập bao gồm:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên công trình</strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về bão.</li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Loại hình thiên tai</strong> và <strong>Loại hình</strong> (bắt buộc): Chọn từ
                                    danh sách các loại có sẵn.</li>
                                <li><strong>Cấp độ thiên tai</strong> và <strong>Năm xây dựng và năm hoàn thành</strong>
                                    (bắt
                                    buộc): Nhập mức độ
                                    và năm xảy ra sự kiện.</li>
                                <li> <strong>chiều rộng</strong>,
                                    <strong>chiều dài (km)</strong>,
                                    <strong>mức độ ảnh hưởngthiểu</strong>,
                                    <strong>nguồn vốn </strong>,
                                    <strong>tổng mức đầu tư </strong>
                                    : Nhập thông tin mô tả nếu có.
                                </li>
                                <li><strong>Đính kèm</strong>: Có thể tải, hình ảnh và video minh họa (nếu
                                    cần).</li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> ở góc phải
                            cho phép lưu thông tin sạt lở vào hệ thống.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Chi tiết/Cập nhật CT Sạt lở:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom
                            src="{{ Vite::asset('resources/images/faq/construction/river-bank/detail.png') }}"
                            alt="Chi tiết/Cập nhật CT Sạt lở" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>chỉnh sửa thông tin sạt lở đã có</strong>.</li>
                        <li>Người dùng có thể điều chỉnh hoặc bổ sung các trường sau:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên công trình</strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về sạt lở.</li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Loại hình thiên tai</strong> và <strong>Loại hình</strong> (bắt buộc): Chọn từ
                                    danh sách các loại có sẵn.</li>
                                <li><strong>Cấp độ thiên tai</strong> và <strong>Năm xây dựng và năm hoàn thành</strong>
                                    (bắt
                                    buộc): Nhập mức độ
                                    và năm xảy ra sự kiện.</li>
                                <li> <strong>chiều rộng</strong>,
                                    <strong>chiều dài (km)</strong>,
                                    <strong>mức độ ảnh hưởngthiểu</strong>,
                                    <strong>nguồn vốn </strong>,
                                    <strong>tổng mức đầu tư </strong>
                                    : Nhập thông tin mô tả nếu có.
                                </li>
                                <li><strong>Đính kèm</strong>: Có thể tải, hình ảnh và video minh họa (nếu
                                    cần).</li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> sẽ lưu các
                            thay đổi đã chỉnh sửa.</li>
                        <li>Nút <span class="font-semibold text-slate-600 bg-slate-200 px-4 py-1 rounded">Huỷ Bỏ</span> để
                            quay lại mà không lưu thay đổi.</li>
                    </ul>
                </div>
            </div>

            <!--công trình Ngập Lụt  -->
            <div x-show="activeTab === 'construction-flooding'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Danh sách công trình ngập Lụt:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom
                            src="{{ Vite::asset('resources/images/faq/construction/flooding/list-1.png') }}"
                            alt="Danh sách công trình ngập Lụt 1" class="h-40 w-auto rounded-lg shadow-md" />
                        <x-base.image-zoom
                            src="{{ Vite::asset('resources/images/faq/construction/flooding/list-2.png') }}"
                            alt="Danh sách công trình ngập Lụt 2" class="h-40 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Hiển thị danh sách các vị trí công trình Ngập Lụt đã được cập nhật vào hệ thống.</li>
                        <li>Cho phép lọc dữ liệu theo năm, huyện, xã, cấp độ thiên tai hoặc tìm kiếm theo tên công trình.
                        </li>
                        <li>Bảng đầu hiển thị thông tin tổng quan: tên công trình, loại hình. địa phương ảnh hưởng, tiến độ
                            thực hiện, năm xây dựng,
                            năm hoàn thành, chiều dài (km), chiều rộng (m)...</li>
                        <li>Bảng thứ hai (cuộn ngang hoặc ẩn hiện theo giao diện) hiển thị thông tin chi tiết như: Quy mô,
                            Đặc điểm nhận dạng , Bề rộng 1 cửa (m), Cao trình đấy (m), Cao trình đỉnh trụ pin (m), Hình thức
                            vận hành, Hệ thống thuỷ lợi, Vùng thuỷ lợi, Loại cống, Mã cống Đơn vị quản lý, Ghi chú , lớp bản
                            đồ, hình ảnh,
                            video...</li>
                        <li>Nhấn <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Tạo Mới Công
                                Trình</span> để thêm mới một vị trí
                            CT Ngập Lụt.</li>
                        <li>Nhấn vào dòng dữ liệu để xem chi tiết hoặc chỉnh sửa nếu có quyền.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Tạo mới công trình Ngập Lụt:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom
                            src="{{ Vite::asset('resources/images/faq/construction/flooding/create.png') }}"
                            alt="Tạo mới Ngập Lụt" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>thêm mới thông tin công trình Ngập Lụt</strong> vào hệ
                            thống.</li>
                        <li>Thông tin cần nhập bao gồm:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên công trình</strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về bão.</li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Loại hình thiên tai</strong> và <strong>Loại hình</strong> (bắt buộc): Chọn từ
                                    danh sách các loại có sẵn.</li>
                                <li><strong>Cấp độ thiên tai</strong> và <strong>Năm xây dựng và năm hoàn thành</strong>
                                    (bắt
                                    buộc): Nhập mức độ
                                    và năm xảy ra sự kiện.</li>
                                <li> <strong>Thời gian cập nhật </strong>,
                                    <strong>Chức năng chính </strong>,
                                    <strong>Quy mô</strong>,
                                    <strong>Đặc điểm đặc dạng </strong>,
                                    <strong>Bề rộng 1 cửa (m) </strong>,
                                    <strong>Cao trình đấy (m) </strong>,
                                    <strong>Cao trình đỉnh trụ pin (m) </strong>,
                                    <strong>Tổng bề rộng cửa (m) </strong>,
                                    <strong>Ghi chú </strong>,
                                    <strong>Hình thức vận hành </strong>,
                                    <strong>Hệ thống thuỷ lợi</strong>,
                                    <strong>Vùng thuỷ lợi </strong>,
                                    <strong>Loại cống </strong>,
                                    <strong>Mã cống </strong>,
                                    <strong>Đơn vị quản lý </strong>
                                    : Nhập thông tin mô tả nếu có.
                                </li>
                                <li><strong>Đính kèm</strong>: Có thể tải, hình ảnh và video minh họa (nếu
                                    cần).</li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> ở góc phải
                            cho phép lưu thông tin bão vào hệ thống.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Chi tiết/Cập nhật CT Ngập Lụt:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom
                            src="{{ Vite::asset('resources/images/faq/construction/flooding/detail.png') }}"
                            alt="Chi tiết/Cập nhật CT Ngập Lụt" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>chỉnh sửa thông tin ngập lụt đã có</strong>.</li>
                        <li>Người dùng có thể điều chỉnh hoặc bổ sung các trường sau:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên công trình</strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về ngập lụt.</li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Loại hình thiên tai</strong> và <strong>Loại hình</strong> (bắt buộc): Chọn từ
                                    danh sách các loại có sẵn.</li>
                                <li><strong>Cấp độ thiên tai</strong> và <strong>Năm xây dựng và năm hoàn thành</strong>
                                    (bắt
                                    buộc): Nhập mức độ
                                    và năm xảy ra sự kiện.</li>
                                <li> <strong>Thời gian cập nhật </strong>,
                                    <strong>Chức năng chính </strong>,
                                    <strong>Quy mô</strong>,
                                    <strong>Đặc điểm đặc dạng </strong>,
                                    <strong>Bề rộng 1 cửa (m) </strong>,
                                    <strong>Cao trình đấy (m) </strong>,
                                    <strong>Cao trình đỉnh trụ pin (m) </strong>,
                                    <strong>Tổng bề rộng cửa (m) </strong>,
                                    <strong>Ghi chú </strong>,
                                    <strong>Hình thức vận hành </strong>,
                                    <strong>Hệ thống thuỷ lợi</strong>,
                                    <strong>Vùng thuỷ lợi </strong>,
                                    <strong>Loại cống </strong>,
                                    <strong>Mã cống </strong>,
                                    <strong>Đơn vị quản lý </strong>
                                    : Nhập thông tin mô tả nếu có.
                                </li>
                                <li><strong>Đính kèm</strong>: Có thể tải, hình ảnh và video minh họa (nếu
                                    cần).</li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> sẽ lưu các
                            thay đổi đã chỉnh sửa.</li>
                        <li>Nút <span class="font-semibold text-slate-600 bg-slate-200 px-4 py-1 rounded">Huỷ Bỏ</span> để
                            quay lại mà không lưu thay đổi.</li>
                    </ul>
                </div>
            </div>

            <!--công trình bão  -->
            <div x-show="activeTab === 'construction-storm'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Danh sách công trình bão:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/construction/storm/list-1.png') }}"
                            alt="Danh sách công trình bão 1" class="h-40 w-auto rounded-lg shadow-md" />
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/construction/storm/list-2.png') }}"
                            alt="Danh sách công trình bão 2" class="h-40 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Hiển thị danh sách các vị trí công trình bão đã được cập nhật vào hệ thống.</li>
                        <li>Cho phép lọc dữ liệu theo năm, huyện, xã, cấp độ thiên tai hoặc tìm kiếm theo tên công trình.
                        </li>
                        <li>Bảng đầu hiển thị thông tin tổng quan: tên công trình, loại hình. địa phương ảnh hưởng, tiến độ
                            thực hiện, ngày xây dựng,
                            ngày hoàn thành, chiều dài (km), chiều rộng (m)...</li>
                        <li>Bảng thứ hai (cuộn ngang hoặc ẩn hiện theo giao diện) hiển thị thông tin chi tiết như: Chi phí,
                            Tình trạng hoạt động, Nhà thầu, Mức độ hiệu quả...</li>
                        <li>Nhấn <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Tạo Mới Công
                                Trình</span> để thêm mới một vị trí
                            CT bão.</li>
                        <li>Nhấn vào dòng dữ liệu để xem chi tiết hoặc chỉnh sửa nếu có quyền.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Tạo mới công trình bão:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/construction/storm/create.png') }}"
                            alt="Tạo mới bão" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>thêm mới thông tin công trình bão</strong> vào hệ
                            thống.</li>
                        <li>Thông tin cần nhập bao gồm:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên công trình</strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về bão.</li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Loại hình thiên tai</strong> và <strong>Loại hình</strong> (bắt buộc): Chọn từ
                                    danh sách các loại có sẵn.</li>
                                <li><strong>Cấp độ thiên tai</strong> và <strong>ngày xây dựng và ngày hoàn thành</strong>
                                    (bắt
                                    buộc): Nhập mức độ
                                    và năm xảy ra sự kiện.</li>
                                <li> <strong>Kích thước </strong>,
                                    <strong>Tình trạng </strong>,
                                    <strong>Nguồn vốn </strong>,
                                    <strong>Chi phí </strong>,
                                    <strong>Tình trạng hoạt động </strong>,
                                    <strong>Nhà thầu </strong>,
                                    <strong>Mức độ hiệu quả </strong>
                                    : Nhập thông tin mô tả nếu có.
                                </li>
                                <li><strong>Đính kèm</strong>: Có thể tải, hình ảnh và video minh họa (nếu
                                    cần).</li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> ở góc phải
                            cho phép lưu thông tin bão vào hệ thống.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Chi tiết/Cập nhật CT bão:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/construction/storm/detail.png') }}"
                            alt="Chi tiết/Cập nhật CT bão" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>chỉnh sửa thông tin bão đã có</strong>.</li>
                        <li>Người dùng có thể điều chỉnh hoặc bổ sung các trường sau:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên công trình</strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về bão.</li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Loại hình thiên tai</strong> và <strong>Loại hình</strong> (bắt buộc): Chọn từ
                                    danh sách các loại có sẵn.</li>
                                <li><strong>Cấp độ thiên tai</strong> và <strong>ngày xây dựng và ngày hoàn thành</strong>
                                    (bắt
                                    buộc): Nhập mức độ
                                    và năm xảy ra sự kiện.</li>
                                <li> <strong>Kích thước </strong>,
                                    <strong>Tình trạng </strong>,
                                    <strong>Nguồn vốn </strong>,
                                    <strong>Chi phí </strong>,
                                    <strong>Tình trạng hoạt động </strong>,
                                    <strong>Nhà thầu </strong>,
                                    <strong>Mức độ hiệu quả </strong>
                                    : Nhập thông tin mô tả nếu có.
                                </li>
                                <li><strong>Đính kèm</strong>: Có thể tải, hình ảnh và video minh họa (nếu
                                    cần).</li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> sẽ lưu các
                            thay đổi đã chỉnh sửa.</li>
                        <li>Nút <span class="font-semibold text-slate-600 bg-slate-200 px-4 py-1 rounded">Huỷ Bỏ</span> để
                            quay lại mà không lưu thay đổi.</li>
                    </ul>
                </div>
            </div>

            <!--công trình trường học  -->
            <div x-show="activeTab === 'construction-school'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Danh sách công trình trường học:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/construction/school/list.png') }}"
                            alt="Danh sách công trình trường học 1" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Hiển thị danh sách các vị trí công trình trường học đã được cập nhật vào hệ thống.</li>
                        <li>Cho phép lọc dữ liệu theo xã, hoặc tìm kiếm theo tên công trình.
                        </li>
                        <li>Bảng đầu hiển thị thông tin tổng quan: tên công trình, Mã, Địa Điểm, Xã, Toạ Độ, Sức Chứa, Mô
                            Tả...</li>
                        <li>Nhấn <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Tạo mới trường
                                học</span> để thêm mới một vị trí
                            CT trường học.</li>
                        <li>Nhấn vào dòng dữ liệu để xem chi tiết hoặc chỉnh sửa nếu có quyền.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Tạo mới công trình trường học:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/construction/school/create.png') }}"
                            alt="Tạo mới trường học" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>thêm mới thông tin công trình trường học</strong> vào hệ
                            thống.</li>
                        <li>Thông tin cần nhập bao gồm:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên </strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về trường học.</li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Mã</strong>(bắt buộc): Mã trường học.</li>
                                <li> <strong>Sức chứa</strong>,
                                    <strong>Mô tả</strong>
                                    : Nhập thông tin mô tả nếu có.
                                </li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> ở góc phải
                            cho phép lưu thông tin trường học vào hệ thống.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Chi tiết/Cập nhật CT trường học:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/construction/school/detail.png') }}"
                            alt="Chi tiết/Cập nhật CT trường học" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>chỉnh sửa thông tin trường học đã có</strong>.</li>
                        <li>Người dùng có thể điều chỉnh hoặc bổ sung các trường sau:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên </strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về trường học.</li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Mã</strong>(bắt buộc): Mã trường học.</li>
                                <li> <strong>Sức chứa</strong>,
                                    <strong>Mô tả</strong>
                                    : Nhập thông tin mô tả nếu có.
                                </li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> sẽ lưu các
                            thay đổi đã chỉnh sửa.</li>
                        <li>Nút <span class="font-semibold text-slate-600 bg-slate-200 px-4 py-1 rounded">Huỷ Bỏ</span> để
                            quay lại mà không lưu thay đổi.</li>
                    </ul>
                </div>
            </div>


            <!--công trình y tế  -->
            <div x-show="activeTab === 'construction-medical'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Danh sách công trình y tế:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/construction/medical/list.png') }}"
                            alt="Danh sách công trình y tế 1" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Hiển thị danh sách các vị trí công trình y tế đã được cập nhật vào hệ thống.</li>
                        <li>Cho phép lọc dữ liệu theo xã, hoặc tìm kiếm theo tên công trình.
                        </li>
                        <li>Bảng đầu hiển thị thông tin tổng quan: Tên Địa Điểm Y Tế, Địa Điểm, Xã, Huyện, Loại Hình, Phận
                            Loại, Mô Tả, Toạ Độ, Sức Chứa...</li>
                        <li>Nhấn <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Tạo mới </span> để
                            thêm mới một vị trí
                            CT y tế.</li>
                        <li>Nhấn vào dòng dữ liệu để xem chi tiết hoặc chỉnh sửa nếu có quyền.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Tạo mới công trình y tế:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom
                            src="{{ Vite::asset('resources/images/faq/construction/medical/create.png') }}"
                            alt="Tạo mới y tế" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>thêm mới thông tin công trình y tế</strong> vào hệ
                            thống.</li>
                        <li>Thông tin cần nhập bao gồm:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên Y Tế </strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về y tế.</li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Mã</strong>(bắt buộc): Mã y tế.</li>
                                <li> <strong>Sức chứa</strong>,
                                    <strong>Loại hình</strong>,
                                    <strong>Phân loại</strong>,
                                    <strong>Mô tả</strong>
                                    : Nhập thông tin mô tả nếu có.
                                </li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> ở góc phải
                            cho phép lưu thông tin y tế vào hệ thống.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Chi tiết/Cập nhật CT y tế:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom
                            src="{{ Vite::asset('resources/images/faq/construction/medical/detail.png') }}"
                            alt="Chi tiết/Cập nhật CT y tế" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>chỉnh sửa thông tin y tế đã có</strong>.</li>
                        <li>Người dùng có thể điều chỉnh hoặc bổ sung các trường sau:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên Y Tế </strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về y tế.</li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Mã</strong>(bắt buộc): Mã y tế.</li>
                                <li> <strong>Sức chứa</strong>,
                                    <strong>Loại hình</strong>,
                                    <strong>Phân loại</strong>,
                                    <strong>Mô tả</strong>
                                    : Nhập thông tin mô tả nếu có.
                                </li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> sẽ lưu các
                            thay đổi đã chỉnh sửa.</li>
                        <li>Nút <span class="font-semibold text-slate-600 bg-slate-200 px-4 py-1 rounded">Huỷ Bỏ</span> để
                            quay lại mà không lưu thay đổi.</li>
                    </ul>
                </div>
            </div>

            <!--công trình TTHC & khác  -->
            <div x-show="activeTab === 'construction-center'" class="intro-y box h-screen overflow-y-auto" x-cloak>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">1.</span>
                        <span class="font-bold text-primary text-xl">Danh sách công trình TTHC & khác:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom src="{{ Vite::asset('resources/images/faq/construction/center/list.png') }}"
                            alt="Danh sách công trình TTHC & khác 1" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Hiển thị danh sách các vị trí công trình TTHC & khác đã được cập nhật vào hệ thống.</li>
                        <li>Cho phép lọc dữ liệu theo xã, hoặc tìm kiếm theo tên công trình.
                        </li>
                        <li>Bảng đầu hiển thị thông tin tổng quan: Tên Địa Điểm TTHC & khác, Địa Điểm, Xã, Huyện, Loại Hình,
                            Phận
                            Loại, Mô Tả, Toạ Độ, Sức Chứa...</li>
                        <li>Nhấn <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Tạo mới </span> để
                            thêm mới một vị trí
                            CT TTHC & khác.</li>
                        <li>Nhấn vào dòng dữ liệu để xem chi tiết hoặc chỉnh sửa nếu có quyền.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">2.</span>
                        <span class="font-bold text-primary text-xl">Tạo mới công trình TTHC & khác:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom
                            src="{{ Vite::asset('resources/images/faq/construction/center/create.png') }}"
                            alt="Tạo mới TTHC & khác" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>thêm mới thông tin công trình TTHC & khác</strong> vào hệ
                            thống.</li>
                        <li>Thông tin cần nhập bao gồm:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên TTHC & khác </strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về TTHC & khác.
                                </li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Mã</strong>(bắt buộc): Mã TTHC & khác.</li>
                                <li> <strong>Sức chứa</strong>,
                                    <strong>Loại hình</strong>,
                                    <strong>Phân loại</strong>,
                                    <strong>Mô tả</strong>
                                    : Nhập thông tin mô tả nếu có.
                                </li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> ở góc phải
                            cho phép lưu thông tin TTHC & khác vào hệ thống.</li>
                    </ul>
                </div>
                <div class="p-5 space-y-5">
                    <div class="flex items-start mb-2">
                        <span class="font-bold mr-2 text-primary text-xl">3.</span>
                        <span class="font-bold text-primary text-xl">Chi tiết/Cập nhật CT TTHC & khác:</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <x-base.image-zoom
                            src="{{ Vite::asset('resources/images/faq/construction/center/detail.png') }}"
                            alt="Chi tiết/Cập nhật CT TTHC & khác" class="h-80 w-auto rounded-lg shadow-md" />
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-500 text-base">
                        <li>Trang này cho phép người dùng <strong>chỉnh sửa thông tin TTHC & khác đã có</strong>.</li>
                        <li>Người dùng có thể điều chỉnh hoặc bổ sung các trường sau:
                            <ul class="list-disc list-inside ml-5">
                                <li><strong>Tên TTHC & khác </strong> (bắt buộc): Nhập tên hoặc mô tả ngắn về TTHC & khác.
                                </li>
                                <li><strong>Tọa độ vị trí</strong> (bắt buộc): Nhập tọa độ theo định dạng lat, lng.</li>
                                <li><strong>Địa điểm</strong> & <strong>Phường/Xã</strong> (bắt buộc): Nhập hoặc chọn thông
                                    tin địa phương nơi xảy ra thiên tai.</li>
                                <li><strong>Mã</strong>(bắt buộc): Mã TTHC & khác.</li>
                                <li> <strong>Sức chứa</strong>,
                                    <strong>Loại hình</strong>,
                                    <strong>Phân loại</strong>,
                                    <strong>Mô tả</strong>
                                    : Nhập thông tin mô tả nếu có.
                                </li>
                            </ul>
                        </li>
                        <li>Nút <span class="font-semibold text-white bg-primary px-4 py-1 rounded">Lưu</span> sẽ lưu các
                            thay đổi đã chỉnh sửa.</li>
                        <li>Nút <span class="font-semibold text-slate-600 bg-slate-200 px-4 py-1 rounded">Huỷ Bỏ</span> để
                            quay lại mà không lưu thay đổi.</li>
                    </ul>
                </div>
            </div>

        </div>
        <!-- END: FAQ Content -->
    </div>
@endsection
<script src="//unpkg.com/alpinejs" defer></script>
