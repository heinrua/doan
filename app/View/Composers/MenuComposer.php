<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\User;

class MenuComposer
{
    /**
     * Bind menu to the view.
     */
    public function compose(View $view): void
    {
        
        $menus = [
            'dashboard-overview' => [
                'icon' => 'activity',
                'route_name' => 'dashboard-overview',
                'title' => 'Tổng Quan'
            ],
            'view-user' => [
                'icon' => 'users',
                'route_name' => 'view-user',
                'title' => 'Người Dùng',
                'only_master' => true,
            ],
           
            'location' => [
                'icon' => 'home',
                'title' => 'Địa Điểm',
                'sub_menu' => [
                    'view-city' => [
                        'icon' => 'activity',
                        'route_name' => 'view-city',
                        'title' => 'Tỉnh-Thành',
                        
                    ],
                    'view-district' => [
                        'icon' => 'activity',
                        'route_name' => 'view-district',
                        'title' => 'Quận-Huyện',
                      
                    ],
                    'view-commune' => [
                        'icon' => 'activity',
                        'route_name' => 'view-commune',
                        'title' => 'Phường-Xã',
                        
                    ],
                ]
            ],
            'type-of-calamity' => [
                'icon' => 'group',
                'title' => 'Loại Thiên Tai',
                'sub_menu' => [
                    'view-type-of-calamity' => [
                        'icon' => 'activity',
                        'route_name' => 'view-type-of-calamity',
                        'title' => 'Loại Thiên Tai',
                        
                    ],
                    'view-sub-type-of-calamity' => [
                        'icon' => 'activity',
                        'route_name' => 'view-sub-type-of-calamity',
                        'title' => 'Loại Thiên Tai Phụ',
                    ],
                    'view-risk-level' => [
                        'icon' => 'activity',
                        'route_name' => 'view-risk-level',
                        'title' => 'Cấp Độ Thiên Tai',
                    ],
                    'view-type-of-construction' => [
                        'icon' => 'activity',
                        'route_name' => 'view-type-of-construction',
                        'title' => 'Loại Công Trình',
                    ],
                    'view-scenarios' => [
                        'icon' => 'activity',
                        'route_name' => 'view-scenarios',
                        'title' => 'Phương Án Ứng Phó'
                    ],
                ]
            ],
            'calamities' => [
                'icon' => 'group',
                'title' => 'Dữ Liệu Thiên Tai',
                'sub_menu' => [
                    'view-calamity-river-bank' => [
                        'icon' => 'activity',
                        'route_name' => 'view-calamity-river-bank',
                        'title' => 'Sạt Lở'
                    ],
                    'view-calamity-flooding' => [
                        'icon' => 'activity',
                        'route_name' => 'view-calamity-flooding',
                        'title' => 'Ngập Lụt'
                    ],
                    'view-calamity-storm' => [
                        'icon' => 'activity',
                        'route_name' => 'view-calamity-storm',
                        'title' => 'Bão và ATNĐ'
                    ],
                ],
            ],
            'constructions' => [
                'icon' => 'constructions',
                'title' => 'Công Trình PCTT',
                'sub_menu' => [
                    'view-construction-river-bank' => [
                        'icon' => 'activity',
                        'route_name' => 'view-construction-river-bank',
                        'title' => 'Sạt Lở'
                    ],
                    'view-construction-flooding' => [
                        'icon' => 'activity',
                        'route_name' => 'view-construction-flooding',
                        'title' => 'Ngập Lụt'
                    ],
                    'view-construction-storm' => [
                        'icon' => 'activity',
                        'route_name' => 'view-construction-storm',
                        'title' => 'Bão và ATNĐ'

                    ],
                    ]
                ],
            'construction_different' => [
                'icon' => 'group',
                'title' => 'Địa danh hành chính',
                'sub_menu' => [
                    'view-school' => [
                        'icon' => 'school',
                        'route_name' => 'view-school',
                        'title' => 'Trường Học'
                        ],
                    'view-medical' => [
                        'icon' => 'hospital',
                        'route_name' => 'view-medical',
                        'title' => 'Địa Điểm Y Tế'
                    ],
                    'view-center' => [
                        'icon' => 'university',
                        'route_name' => 'view-center',
                        'title' => 'TTHC và Khác'
                    ],

                ],
            ],
            'geographical_data' => [
                'icon' => 'group',
                'title' => 'Dữ Liệu Khác',
                'sub_menu' => [
                    'view-erosion' => [
                        'icon' => 'activity',
                        'route_name' => 'view-erosion',
                        'title' => 'Khu vực xói, bồi'

                    ],
                    'view-shoreline' => [
                        'icon' => 'activity',
                        'route_name' => 'view-shoreline',
                        'title' => 'Lịch sử đường bờ'
                    ],
                    'view-cross-section' => [
                        'icon' => 'activity',
                        'route_name' => 'view-cross-section',
                        'title' => 'Mặt cắt ngang'
                    ],
                    'view-monitoring' => [
                        'icon' => 'activity',
                        'route_name' => 'view-monitoring',
                        'title' => 'Mốc quan trắc'
                    ],
                ]
            ],
            'map' => [
                'icon' => 'map',
                'title' => 'Bản Đồ',
                'route_name' => 'view-map',
            ],
           
            'chat' =>[
                'icon' => 'chat',
                'route_name' => 'chat',
                'title' => 'Tham gia cộng đồng',
            ]
        ];
    $user = null;
    $isMaster = false;

    if (app()->has('auth') && auth()->check()) {
        $user = auth()->user();
        $isMaster = $user?->is_master;
    }


    $filterMenu = function (array $items) use ($user, $isMaster, &$filterMenu) {
        $filtered = [];
        foreach ($items as $key => $item) {

            // 1. Kiểm tra menu chỉ dành cho master
            if (isset($item['only_master']) && $item['only_master'] && (!$user || !$isMaster)) {
                continue;
            }
            

            // 2. Nếu có submenu → đệ quy
            if (isset($item['sub_menu'])) {
                $item['sub_menu'] = $filterMenu($item['sub_menu']);

                if (!empty($item['sub_menu'])) {
                    $filtered[$key] = $item;
                }

                continue;
            }

            // 3. Nếu chưa login → chỉ hiển thị menu không có 'only_master'
            if (!$user) {
                $filtered[$key] = $item;
                continue;
            }

            // 4. Nếu là master hoặc user thường → đều thấy (trừ menu bị giới hạn only_master)
            $filtered[$key] = $item;
    }

    return $filtered;
};


        $filteredMenus = $filterMenu($menus);
        $view->with('mainMenu', $filteredMenus);
        if ($user && !is_null(request()->route())) {
            $pageName = request()->route()->getName();
            $activeMenu = $this->activeMenu($pageName, $filteredMenus);
            $view->with('firstLevelActiveIndex', $activeMenu['first_level_active_index']);
            $view->with('secondLevelActiveIndex', $activeMenu['second_level_active_index']);
            $view->with('thirdLevelActiveIndex', $activeMenu['third_level_active_index']);
            $view->with('pageName', $pageName);
        }

    
    }
    /**
     * Set active menu & submenu.
     */
    public function activeMenu($pageName, $menus): array
    {
        $first = '';
        $second = '';
        $third = '';

        // Nhóm route cho từng menu
        $routeGroups = [
            'view-user' => ['view-user', 'create-user', 'edit-user'],
            'view-city' => ['view-city', 'create-city', 'edit-city'],
            'view-district' => ['view-district', 'create-district', 'edit-district'],
            'view-commune' => ['view-commune', 'create-commune', 'edit-commune'],
            'view-type-of-calamity' => ['view-type-of-calamity', 'create-type-of-calamity', 'edit-type-of-calamity'],
            'view-risk-level' => ['view-risk-level', 'create-risk-level', 'edit-risk-level'],
            'view-type-of-construction' => ['view-type-of-construction', 'create-type-of-construction', 'edit-type-of-construction'],
            'view-sub-type-of-calamity' => ['view-sub-type-of-calamity', 'create-sub-type-of-calamity', 'edit-sub-type-of-calamity'],
            'view-calamity-river-bank' => ['view-calamity-river-bank', 'create-calamity-river-bank', 'edit-calamity-river-bank'],
            'view-calamity-flooding' => ['view-calamity-flooding', 'create-calamity-flooding', 'edit-calamity-flooding'],
            'view-calamity-storm' => ['view-calamity-storm', 'create-calamity-storm', 'edit-calamity-storm'],
            'view-construction-river-bank' => ['view-construction-river-bank', 'create-construction-river-bank', 'edit-construction-river-bank'],
            'view-construction-flooding' => ['view-construction-flooding', 'create-construction-flooding', 'edit-construction-flooding'],
            'view-construction-storm' => ['view-construction-storm', 'create-construction-storm', 'edit-construction-storm'],
            'view-erosion' => ['view-erosion', 'create-erosion', 'edit-erosion'],
            'view-shoreline' => ['view-shoreline', 'create-shoreline', 'edit-shoreline'],
            'view-cross-section' => ['view-cross-section', 'create-cross-section', 'edit-cross-section'],
            'view-monitoring' => ['view-monitoring', 'create-monitoring', 'edit-monitoring'],
            'view-school' => ['view-school', 'create-school', 'edit-school'],
            'view-medical' => ['view-medical', 'create-medical', 'edit-medical'],
            'view-center' => ['view-center', 'create-center', 'edit-center'],
            'view-scenarios' => ['view-scenarios', 'create-scenarios', 'edit-scenarios'],
        ];

        
        // Xác định route chính tương ứng
      
        foreach ($routeGroups as $main => $group) {
            if (in_array($pageName, $group)) {
                $pageName = $main;
                break;
            }
        }

        // Xử lý active menu dựa trên route chính
       foreach ($menus as $menuKey => $menu) {
            if ($menu !== 'divider') {
                if (($menu['route_name'] ?? '') === $pageName) {
                    $first = $menuKey;
                }

                foreach ($menu['sub_menu'] ?? [] as $subKey => $sub) {
                    if (($sub['route_name'] ?? '') === $pageName) {
                        $first = $menuKey;
                        $second = $subKey;
                    }

                    foreach ($sub['sub_menu'] ?? [] as $lastKey => $last) {
                        if (($last['route_name'] ?? '') === $pageName) {
                            $first = $menuKey;
                            $second = $subKey;
                            $third = $lastKey;
                        }
                    }
                }
            }
        }
        

        return [
            'first_level_active_index' => $first,
            'second_level_active_index' => $second,
            'third_level_active_index' => $third,
        ];
    }
}

