<?php

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use App\Exports\UsersExport;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\ChatController;

Route::get('/chat', [ChatController::class, 'index']);
Route::post('/chat/send', [ChatController::class, 'send']);

// Cho phép tất cả người dùng (kể cả chưa login) vào dashboard
Route::get('/', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard-overview');
Route::post('/import-users', [App\Http\Controllers\UserController::class, 'import'])->name('import-users');
Route::get('/test-email', function () {
    $dummy = (object)[
        'id' => 1,
        'name' => 'Cảnh báo thiên tai khẩn cấp',
        'time' => now()->toDateTimeString(),
        'address' => 'Xã ABC, Huyện XYZ'
    ];

    Notification::route('mail', 'hien151003@gmail.com')
        ->notify(new DisasterCreated($dummy, 'Hiền Dương'));

    return 'Email test đã được gửi!';
});

// // Authentication routes
// Route::get('/register', [App\Http\Controllers\AuthController::class, 'viewRegister'])->name('register');
// Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);

Route::get('/login', [App\Http\Controllers\AuthController::class, 'viewLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [App\Http\Controllers\AuthController::class, 'viewForgotPassword'])->name('forgot-password');
Route::get('/reset-password/{token}', [App\Http\Controllers\AuthController::class, 'viewResetPassword'])->name('reset-password');
// Hiển thị trang chỉnh sửa hồ sơ
Route::get('/edit-profile', [App\Http\Controllers\AuthController::class, 'viewEditProfile'])->name('edit-profile');

// Xử lý cập nhật hồ sơ
Route::post('/edit_profile', [App\Http\Controllers\AuthController::class, 'updateProfile'])->name('update-profile');

//Route::middleware(['auth'])->group(function () {
    
    Route::get('/faq', [App\Http\Controllers\AdminController::class, 'faq'])->name('view-faq'); // hướng dẫn
    Route::get('/get-risk-levels', [App\Http\Controllers\AdminController::class, 'getRiskLevels'])->name('get-risk-levels');
    Route::get('/get-sub-type-of-calamities', [App\Http\Controllers\AdminController::class, 'getSubTypeOfCalamities'])->name('get-sub-type-of-calamities');
    Route::post('/create-disaster', [App\Http\Controllers\AdminController::class, 'createDisaster'])->name('create-disaster');

   
    // CRUD User
    Route::middleware(['auth'])->group(function () {
    Route::get('/create-user', [App\Http\Controllers\UserController::class, 'viewFormUser'])->name('create-user');//->middleware('permission:create-user');
    Route::post('/create-user', [App\Http\Controllers\UserController::class, 'store'])->name('store-user');
    Route::get('/list-user', [App\Http\Controllers\UserController::class, 'index'])->name('view-user');//->middleware('permission:view-user');
    Route::get('/export-users', function () {
        return Excel::download(new UsersExport, 'DanhSachNguoiDung.xlsx');
    })->name('export-users');
    Route::get('/edit-user/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('edit-user');//->middleware('permission:edit-user');
    Route::post('/update-user', [App\Http\Controllers\UserController::class, 'update'])->name('update-user');//->middleware('permission:update-user');
    Route::get('/delete-user/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('delete-user');//->middleware('permission:delete-user');
    
  
   


});
     
    

    // CRUD City
    Route::get('/create-city', [App\Http\Controllers\CityController::class, 'viewFormCity'])->name('create-city');//->middleware('permission:create-city');
    Route::post('/create-city', [App\Http\Controllers\CityController::class, 'store'])->name('store-city');
    Route::get('/list-city', [App\Http\Controllers\CityController::class, 'index'])->name('view-city') ;//->middleware('permission:view-city');
    Route::get('/edit-city/{id}', [App\Http\Controllers\CityController::class, 'show'])->name('edit-city');//->middleware('permission:edit-city');
    Route::post('/update-city', [App\Http\Controllers\CityController::class, 'update'])->name('update-city');//->middleware('permission:update-city');
    Route::get('/delete-city/{id}', [App\Http\Controllers\CityController::class, 'destroy'])->name('delete-city');//->middleware('permission:delete-city');

    // CRUD District
    Route::get('/create-district', [App\Http\Controllers\DistrictController::class, 'viewFormDistrict'])->name('create-district');//->middleware('permission:create-district');
    Route::post('/create-district', [App\Http\Controllers\DistrictController::class, 'store'])->name('store-district');
    Route::get('/list-district', [App\Http\Controllers\DistrictController::class, 'index'])->name('view-district');//->middleware('permission:view-district');
    Route::get('/edit-district/{id}', [App\Http\Controllers\DistrictController::class, 'show'])->name('edit-district');//->middleware('permission:edit-district');
    Route::post('/update-district', [App\Http\Controllers\DistrictController::class, 'update'])->name('update-district');//->middleware('permission:update-district');
    Route::get('/delete-district/{id}', [App\Http\Controllers\DistrictController::class, 'destroy'])->name('delete-district');//->middleware('permission:delete-district');

    // CRUD Commune
    Route::get('/create-commune', [App\Http\Controllers\CommuneController::class, 'viewFormCommune'])->name('create-commune');//->middleware('permission:create-commune');
    Route::post('/create-commune', [App\Http\Controllers\CommuneController::class, 'store'])->name('store-commune');
    Route::get('/list-commune', [App\Http\Controllers\CommuneController::class, 'index'])->name('view-commune');//->middleware('permission:view-commune');
    Route::get('/edit-commune/{id}', [App\Http\Controllers\CommuneController::class, 'show'])->name('edit-commune');//->middleware('permission:edit-commune');
    Route::post('/update-commune', [App\Http\Controllers\CommuneController::class, 'update'])->name('update-commune');//->middleware('permission:update-commune');
    Route::get('/delete-commune/{id}', [App\Http\Controllers\CommuneController::class, 'destroy'])->name('delete-commune');//->middleware('permission:delete-commune');
    Route::get('/get-commune', [App\Http\Controllers\CommuneController::class, 'getCommunesByDistrict'])->name('get-communes');//->middleware('permission:get-communes');


    // CRUD Type Of Calamity
    Route::get('/create-type-of-calamity', [App\Http\Controllers\TypeOfCalamityController::class, 'viewFormTypeOfCalamity'])->name('create-type-of-calamity');//->middleware('permission:create-type-of-calamity');
    Route::post('/create-type-of-calamity', [App\Http\Controllers\TypeOfCalamityController::class, 'store'])->name('store-type-of-calamity');
    Route::get('/list-type-of-calamity', [App\Http\Controllers\TypeOfCalamityController::class, 'index'])->name('view-type-of-calamity');//->middleware('permission:view-type-of-calamity');
    Route::get('/edit-type-of-calamity/{id}', [App\Http\Controllers\TypeOfCalamityController::class, 'show'])->name('edit-type-of-calamity');//->middleware('permission:edit-type-of-calamity');
    Route::post('/edit-type-of-calamity', [App\Http\Controllers\TypeOfCalamityController::class, 'update'])->name('update-type-of-calamity');//->middleware('permission:update-type-of-calamity');
    Route::get('/delete-type-of-calamity/{id}', [App\Http\Controllers\TypeOfCalamityController::class, 'destroy'])->name('delete-type-of-calamity');//->middleware('permission:delete-type-of-calamity');

    // CRUD Risk Level
    Route::get('/create-risk-level', [App\Http\Controllers\RiskLevelController::class, 'viewFormRiskLevel'])->name('create-risk-level');//->middleware('permission:create-risk-level');
    Route::post('/create-risk-level', [App\Http\Controllers\RiskLevelController::class, 'store'])->name('store-risk-level');//->middleware('permission:');
    Route::get('/list-risk-level', [App\Http\Controllers\RiskLevelController::class, 'index'])->name('view-risk-level');//->middleware('permission:view-risk-level');
    Route::get('/edit-risk-level/{id}', [App\Http\Controllers\RiskLevelController::class, 'show'])->name('edit-risk-level');//->middleware('permission:edit-risk-level');
    Route::post('/update-risk-level', [App\Http\Controllers\RiskLevelController::class, 'update'])->name('update-risk-level');//->middleware('permission:update-risk-level');
    Route::get('/delete-risk-level/{id}', [App\Http\Controllers\RiskLevelController::class, 'destroy'])->name('delete-risk-level');//->middleware('permission:delete-risk-level');

    // CRUD Construction
    Route::get('/create-type-of-construction', [App\Http\Controllers\TypeOfConstructionController::class, 'viewFormTypeOfConstruction'])->name('create-type-of-construction');//->middleware('permission:create-type-of-construction');
    Route::post('/create-type-of-construction', [App\Http\Controllers\TypeOfConstructionController::class, 'store'])->name('store-type-of-construction');
    Route::get('/list-type-of-construction', [App\Http\Controllers\TypeOfConstructionController::class, 'index'])->name('view-type-of-construction');//->middleware('permission:view-type-of-construction');
    Route::get('/edit-type-of-construction/{id}', [App\Http\Controllers\TypeOfConstructionController::class, 'show'])->name('edit-type-of-construction');//->middleware('permission:edit-type-of-construction');
    Route::post('/update-type-of-construction', [App\Http\Controllers\TypeOfConstructionController::class, 'update'])->name('update-type-of-construction');//->middleware('permission:update-type-of-construction');
    Route::get('/delete-type-of-construction/{id}', [App\Http\Controllers\TypeOfConstructionController::class, 'destroy'])->name('delete-type-of-construction');//->middleware('permission:delete-type-of-construction');

    // CRUD Sub Type Of Calamity
    Route::get('/create-sub-type-of-calamity', [App\Http\Controllers\SubTypeOfCalamityController::class, 'viewFormTypeOfCalamity'])->name('create-sub-type-of-calamity');//->middleware('permission:create-sub-type-of-calamity');
    Route::post('/create-sub-type-of-calamity', [App\Http\Controllers\SubTypeOfCalamityController::class, 'store'])->name('store-sub-type-of-calamity');
    Route::get('/list-sub-type-of-calamity', [App\Http\Controllers\SubTypeOfCalamityController::class, 'index'])->name('view-sub-type-of-calamity');//->middleware('permission:view-sub-type-of-calamity');
    Route::get('/edit-sub-type-of-calamity/{id}', [App\Http\Controllers\SubTypeOfCalamityController::class, 'show'])->name('edit-sub-type-of-calamity');//->middleware('permission:edit-sub-type-of-calamity');
    Route::post('/update-sub-type-of-calamity', [App\Http\Controllers\SubTypeOfCalamityController::class, 'update'])->name('update-sub-type-of-calamity');//->middleware('permission:update-sub-type-of-calamity');
    Route::get('/delete-sub-type-of-calamity/{id}', [App\Http\Controllers\SubTypeOfCalamityController::class, 'destroy'])->name('delete-sub-type-of-calamity');//->middleware('permission:delete-sub-type-of-calamity');

    Route::prefix('calamity')->group(function () {
        // CRUD RiverBank (SẠT LỞ ĐẤT)
        Route::get('/create-river-bank', [App\Http\Controllers\Calamities\RiverBankCalamityController::class, 'viewFormRiverbank'])->name('create-calamity-river-bank');//->middleware('permission:create-calamity-river-bank');
        Route::post('/create-river-bank', [App\Http\Controllers\Calamities\RiverBankCalamityController::class, 'store'])->name('store-calamity-river-bank');
        Route::get('/list-river-bank', [App\Http\Controllers\Calamities\RiverBankCalamityController::class, 'index'])->name('view-calamity-river-bank');//->middleware('permission:view-calamity-river-bank');
        Route::get('/edit-river-bank/{id}', [App\Http\Controllers\Calamities\RiverBankCalamityController::class, 'show'])->name('edit-calamity-river-bank');//->middleware('permission:edit-calamity-river-bank');
        Route::post('/update-river-bank', [App\Http\Controllers\Calamities\RiverBankCalamityController::class, 'update'])->name('update-calamity-river-bank');//->middleware('permission:update-calamity-river-bank');
        Route::get('/delete-river-bank/{id}', [App\Http\Controllers\Calamities\RiverBankCalamityController::class, 'destroy'])->name('delete-calamity-river-bank');//->middleware('permission:delete-calamity-river-bank');

        // CRUD Flooding (NGẬP LỤT)
        Route::get('/create-flooding', [App\Http\Controllers\Calamities\FloodingCalamityController::class, 'viewFormFlooding'])->name('create-calamity-flooding');//->middleware('permission:create-calamity-flooding');
        Route::post('/create-flooding', [App\Http\Controllers\Calamities\FloodingCalamityController::class, 'store'])->name('store-calamity-flooding');
        Route::get('/list-flooding', [App\Http\Controllers\Calamities\FloodingCalamityController::class, 'index'])->name('view-calamity-flooding');//->middleware('permission:view-calamity-flooding');
        Route::get('/edit-flooding/{id}', [App\Http\Controllers\Calamities\FloodingCalamityController::class, 'show'])->name('edit-calamity-flooding');//->middleware('permission:edit-calamity-flooding');
        Route::post('/update-flooding', [App\Http\Controllers\Calamities\FloodingCalamityController::class, 'update'])->name('update-calamity-flooding');//->middleware('permission:update-calamity-flooding');
        Route::get('/delete-flooding/{id}', [App\Http\Controllers\Calamities\FloodingCalamityController::class, 'destroy'])->name('delete-calamity-flooding');//->middleware('permission:delete-calamity-flooding');

        // CRUD Storm (BÃO)
        Route::get('/create-storm', [App\Http\Controllers\Calamities\StormCalamityController::class, 'viewFormStorm'])->name('create-calamity-storm');//->middleware('permission:create-calamity-storm');
        Route::post('/create-storm', [App\Http\Controllers\Calamities\StormCalamityController::class, 'store'])->name('store-calamity-storm');
        Route::get('/list-storm', [App\Http\Controllers\Calamities\StormCalamityController::class, 'index'])->name('view-calamity-storm');//->middleware('permission:view-calamity-storm');
        Route::get('/edit-storm/{id}', [App\Http\Controllers\Calamities\StormCalamityController::class, 'show'])->name('edit-calamity-storm');//->middleware('permission:edit-calamity-storm');
        Route::post('/update-storm', [App\Http\Controllers\Calamities\StormCalamityController::class, 'update'])->name('update-calamity-storm');//->middleware('permission:update-calamity-storm');
        Route::get('/delete-storm/{id}', [App\Http\Controllers\Calamities\StormCalamityController::class, 'destroy'])->name('delete-calamity-storm');//->middleware('permission:delete-calamity-storm');
    });//->middleware('permission:');


    Route::prefix('construction')->group(function () {
        // CRUD RiverBank (SẠT LỞ ĐẤT)
        Route::get('/create-river-bank', [App\Http\Controllers\Constructions\RiverBankConstructionController::class, 'viewFormRiverbank'])->name('create-construction-river-bank');//->middleware('permission:create-construction-river-bank');
        Route::post('/create-river-bank', [App\Http\Controllers\Constructions\RiverBankConstructionController::class, 'store'])->name('store-construction-river-bank');
        Route::get('/list-river-bank', [App\Http\Controllers\Constructions\RiverBankConstructionController::class, 'index'])->name('view-construction-river-bank');//->middleware('permission:view-construction-river-bank');
        Route::get('/edit-river-bank/{id}', [App\Http\Controllers\Constructions\RiverBankConstructionController::class, 'show'])->name('edit-construction-river-bank');//->middleware('permission:edit-construction-river-bank');
        Route::post('/update-river-bank', [App\Http\Controllers\Constructions\RiverBankConstructionController::class, 'update'])->name('update-construction-river-bank');//->middleware('permission:update-construction-river-bank');
        Route::get('/delete-river-bank/{id}', [App\Http\Controllers\Constructions\RiverBankConstructionController::class, 'destroy'])->name('delete-construction-river-bank');//->middleware('permission:delete-construction-river-bank');

        // CRUD Flooding (NGẬP LỤT)
        Route::get('/create-flooding', [App\Http\Controllers\Constructions\FloodingConstructionController::class, 'viewFormFlooding'])->name('create-construction-flooding');//->middleware('permission:create-construction-flooding');
        Route::post('/create-flooding', [App\Http\Controllers\Constructions\FloodingConstructionController::class, 'store'])->name('store-construction-flooding');
        Route::get('/list-flooding', [App\Http\Controllers\Constructions\FloodingConstructionController::class, 'index'])->name('view-construction-flooding');//->middleware('permission:view-construction-flooding');
        Route::get('/edit-flooding/{id}', [App\Http\Controllers\Constructions\FloodingConstructionController::class, 'show'])->name('edit-construction-flooding');//->middleware('permission:edit-construction-flooding');
        Route::post('/update-flooding', [App\Http\Controllers\Constructions\FloodingConstructionController::class, 'update'])->name('update-construction-flooding');//->middleware('permission:update-construction-flooding');
        Route::get('/delete-flooding/{id}', [App\Http\Controllers\Constructions\FloodingConstructionController::class, 'destroy'])->name('delete-construction-flooding');//->middleware('permission:delete-construction-flooding');

        // CRUD Storm (BÃO)
        Route::get('/create-storm', [App\Http\Controllers\Constructions\StormConstructionController::class, 'viewFormStorm'])->name('create-construction-storm');//->middleware('permission:create-construction-storm');
        Route::post('/create-storm', [App\Http\Controllers\Constructions\StormConstructionController::class, 'store'])->name('store-construction-storm');
        Route::get('/list-storm', [App\Http\Controllers\Constructions\StormConstructionController::class, 'index'])->name('view-construction-storm');//->middleware('permission:view-construction-storm');
        Route::get('/edit-storm/{id}', [App\Http\Controllers\Constructions\StormConstructionController::class, 'show'])->name('edit-construction-storm');//->middleware('permission:edit-construction-storm');
        Route::post('/update-storm', [App\Http\Controllers\Constructions\StormConstructionController::class, 'update'])->name('update-construction-storm');//->middleware('permission:update-construction-storm');
        Route::get('/delete-storm/{id}', [App\Http\Controllers\Constructions\StormConstructionController::class, 'destroy'])->name('delete-construction-storm');//->middleware('permission:delete-construction-storm');
    });//->middleware('role:can_bo');

    Route::prefix('geographical')->group(function () {
        // CRUD Xói Bồi - Lịch sử đường bờ - Mặt cắt ngang - Mốc quan trắc
        $types = ['erosion', 'shoreline', 'cross-section', 'monitoring'];
        foreach ($types as $type) {
            Route::get("/list-{$type}", [App\Http\Controllers\GeographicalDataController::class, 'index'])
                ->name("view-{$type}")->defaults('type', $type);

            Route::get("/create-{$type}", [App\Http\Controllers\GeographicalDataController::class, 'viewForm'])
                ->name("create-{$type}")->defaults('type', $type);

            Route::post("/create-{$type}", [App\Http\Controllers\GeographicalDataController::class, 'store'])
                ->name("store-{$type}")->defaults('type', $type);

            Route::get("/edit-{$type}/{id}", [App\Http\Controllers\GeographicalDataController::class, 'show'])
                ->name("edit-{$type}");

            Route::post("/edit-{$type}", [App\Http\Controllers\GeographicalDataController::class, 'update'])
                ->name("update-{$type}");

            Route::get("/delete-{$type}/{id}", [App\Http\Controllers\GeographicalDataController::class, 'destroy'])
                ->name("delete-{$type}");
        }
    });

    Route::prefix('administrative')->group(function () {
        // CRUD trường học - y tế - trung tâm hành chính
        $types = ['school', 'medical', 'center'];
        foreach ($types as $type) {
            Route::get("/list-{$type}", [App\Http\Controllers\AdministrativeController::class, 'index'])
                ->name("view-{$type}")->defaults('type', $type);//->middleware("permission:view-{$type}");

            Route::get("/create-{$type}", [App\Http\Controllers\AdministrativeController::class, 'viewForm'])
                ->name("create-{$type}")->defaults('type', $type);//->middleware("permission:create-{$type}");

            Route::post("/create-{$type}", [App\Http\Controllers\AdministrativeController::class, 'store'])
                ->name("store-{$type}")->defaults('type', $type);

            Route::get("/edit-{$type}/{id}", [App\Http\Controllers\AdministrativeController::class, 'show'])
                ->name("edit-{$type}");//->middleware("permission:edit-{$type}");

            Route::post("/edit-{$type}", [App\Http\Controllers\AdministrativeController::class, 'update'])
                ->name("update-{$type}");//->middleware("permission:update-{$type}");

            Route::get("/delete-{$type}/{id}", [App\Http\Controllers\AdministrativeController::class, 'destroy'])
                ->name("delete-{$type}");//->middleware("permission:delete-{$type}");
        }
    });

    Route::prefix('map')->group(function () {
        // CRUD Map (BẢN ĐỒ)
        Route::get('/river-bank', [App\Http\Controllers\MapController::class, 'viewRiverBank'])->name('view-map-river-bank');//->middleware('permission:view-map-river-bank');
        Route::get('/flooding', [App\Http\Controllers\MapController::class, 'viewFlooding'])->name('view-map-flooding');//->middleware('permission:view-map-flooding');
        Route::get('/storm', [App\Http\Controllers\MapController::class, 'viewStorm'])->name('view-map-storm');//->middleware('permission:view-map-storm');
        // Route::get('/test', [App\Http\Controllers\MapController::class, 'getCategoryData']);//->middleware('permission:');

    });//->middleware('permission:');

    // CRUD scenarios (PHƯƠNG ÁN ỨNG PHÓ)
    Route::get('/create-scenarios', [App\Http\Controllers\ResponsePlan\ScenarioController::class, 'viewFormScenarios'])->name('create-scenarios');//->middleware('permission:create-scenarios');
    Route::post('/create-scenarios', [App\Http\Controllers\ResponsePlan\ScenarioController::class, 'store'])->name('store-scenarios');
    Route::get('/list-scenarios', [App\Http\Controllers\ResponsePlan\ScenarioController::class, 'index'])->name('view-scenarios');//->middleware('permission:view-scenarios');
    Route::get('/edit-scenarios/{id}', [App\Http\Controllers\ResponsePlan\ScenarioController::class, 'show'])->name('edit-scenarios');//->middleware('permission:edit-scenarios');
    Route::post('/update-scenarios', [App\Http\Controllers\ResponsePlan\ScenarioController::class, 'update'])->name('update-scenarios');//->middleware('permission:update-scenarios');
    Route::get('/delete-scenarios/{id}', [App\Http\Controllers\ResponsePlan\ScenarioController::class, 'destroy'])->name('delete-scenarios');//->middleware('permission:delete-scenarios');

   

//});
