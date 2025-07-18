<?php

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use App\Exports\UsersExport;

use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

 

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->middleware('guest')->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest')->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->middleware('guest')->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest')->name('password.store');


    Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat');
    Route::post('/chat/send', [App\Http\Controllers\ChatController::class, 'send']);
    
    Route::post('/mark-notifications-as-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])
        ->middleware('auth')->name('mark-notifications-as-read');
    
    Route::post('/mark-notification-as-read', [App\Http\Controllers\NotificationController::class, 'markSingleAsRead'])
        ->middleware('auth')->name('mark-notification-as-read');

    Route::get('/incident-report', [App\Http\Controllers\IncidentReportController::class, 'index'])->name('incident-report');
    Route::get('/delete-incident-report/{id}', [App\Http\Controllers\IncidentReportController::class, 'destroy'])->name('delete-incident-report');
    Route::prefix('incident-reports')->group(function () {
        Route::delete('/delete-multiple-incident-report', [App\Http\Controllers\IncidentReportController::class, 'destroyMultiple'])->name('delete-multiple-incident-report');
    });
    
    Route::get('/create-incident-report', [App\Http\Controllers\IncidentReportController::class, 'create'])->name('incident-reports.create');
    Route::post('/create-incident-report', [App\Http\Controllers\IncidentReportController::class, 'store'])->name('incident-reports.store');
    Route::get('/get-sub-type-of-calamities', [App\Http\Controllers\IncidentReportController::class, 'getSubTypeOfCalamities'])->name('get-sub-type-of-calamities');
    Route::get('/get-communes/{district_id}', [App\Http\Controllers\LocationController::class, 'getCommunes'])->name('get-communes');

    Route::get('/', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard-overview');
    
    Route::post('/guest-disaster-subscribe', [App\Http\Controllers\DisasterSubscriptionController::class, 'store'])
        ->name('guest.disaster.subscribe');


    Route::get('/login', [App\Http\Controllers\AuthController::class, 'viewLogin'])->name('login');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    

    Route::middleware(['auth'])->group(function () {
        Route::get('/create-user', [App\Http\Controllers\UserController::class, 'viewFormUser'])->name('create-user');
        Route::post('/create-user', [App\Http\Controllers\UserController::class, 'store'])->name('store-user');
        Route::get('/list-user', [App\Http\Controllers\UserController::class, 'index'])->name('view-user');
        Route::post('/import-users', [App\Http\Controllers\UserController::class, 'importUsers'])->name('import-users');
        Route::get('/edit-user/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('edit-user');
        Route::post('/update-user', [App\Http\Controllers\UserController::class, 'update'])->name('update-user');
        Route::get('/delete-user/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('delete-user');
        Route::get('/edit-profile', [App\Http\Controllers\AuthController::class, 'viewEditProfile'])->name('edit-profile');

        Route::post('/edit_profile', [App\Http\Controllers\AuthController::class, 'updateProfile'])->name('update-profile');
        Route::delete('/delete-multiple-user', [App\Http\Controllers\UserController::class, 'destroyMultipleUsers'])->name('destroy-multiple-user');


    });
     
    
    Route::get('/list-city', [App\Http\Controllers\CityController::class, 'index'])->name('view-city') ;
    Route::get('/list-district', [App\Http\Controllers\DistrictController::class, 'index'])->name('view-district');
    Route::get('/list-commune', [App\Http\Controllers\CommuneController::class, 'index'])->name('view-commune');

    Route::get('/list-type-of-calamity', [App\Http\Controllers\TypeOfCalamityController::class, 'index'])->name('view-type-of-calamity');
    Route::get('/list-risk-level', [App\Http\Controllers\RiskLevelController::class, 'index'])->name('view-risk-level');
    Route::get('/list-type-of-construction', [App\Http\Controllers\TypeOfConstructionController::class, 'index'])->name('view-type-of-construction');
    Route::get('/list-sub-type-of-calamity', [App\Http\Controllers\SubTypeOfCalamityController::class, 'index'])->name('view-sub-type-of-calamity');
    Route::get('/list-scenarios', [App\Http\Controllers\ResponsePlan\ScenarioController::class, 'index'])->name('view-scenarios');

    Route::prefix('calamity')->group(function () {
        Route::get('/list-river-bank', [App\Http\Controllers\Calamities\RiverBankCalamityController::class, 'index'])->name('view-calamity-river-bank');
        Route::get('/list-flooding', [App\Http\Controllers\Calamities\FloodingCalamityController::class, 'index'])->name('view-calamity-flooding');
        Route::get('/list-storm', [App\Http\Controllers\Calamities\StormCalamityController::class, 'index'])->name('view-calamity-storm');
        
    });
    

    Route::prefix('construction')->group(function () {
        Route::get('/list-river-bank', [App\Http\Controllers\Constructions\RiverBankConstructionController::class, 'index'])->name('view-construction-river-bank');
        Route::get('/list-flooding', [App\Http\Controllers\Constructions\FloodingConstructionController::class, 'index'])->name('view-construction-flooding');
        Route::get('/list-storm', [App\Http\Controllers\Constructions\StormConstructionController::class, 'index'])->name('view-construction-storm');
    });





    Route::prefix('geographical')->group(function () {
        
        $types = ['erosion', 'shoreline', 'cross-section', 'monitoring'];
        foreach ($types as $type) {
        Route::get("/list-{$type}", [App\Http\Controllers\GeographicalDataController::class, 'index'])
            ->name("view-{$type}")->defaults('type', $type);
        }
    });
    Route::prefix('administrative')->group(function () {
       
        $types = ['school', 'medical', 'center'];
        foreach ($types as $type) {
            Route::get("/list-{$type}", [App\Http\Controllers\AdministrativeController::class, 'index'])
                ->name("view-{$type}")->defaults('type', $type);
        }
    });
    Route::get('/map', [App\Http\Controllers\MapController::class, 'viewRiverBank'])->name('view-map');
   
    
        Route::prefix('incident-reports')->group(function () {
            Route::get('/', [App\Http\Controllers\IncidentReportController::class, 'index']);
            Route::post('/', [App\Http\Controllers\IncidentReportController::class, 'store']);
            Route::delete('/{id}', [App\Http\Controllers\IncidentReportController::class, 'destroy']);
            Route::delete('/delete-multiple-incident-report', [App\Http\Controllers\IncidentReportController::class, 'destroyMultiple'])->name('delete-multiple-incident-report');
        }); 
    

    Route::middleware(['auth'])->group(function () {

        Route::get('/create-city', [App\Http\Controllers\CityController::class, 'viewFormCity'])->name('create-city');
        Route::post('/create-city', [App\Http\Controllers\CityController::class, 'store'])->name('store-city');
        Route::get('/edit-city/{id}', [App\Http\Controllers\CityController::class, 'show'])->name('edit-city');
        Route::post('/update-city', [App\Http\Controllers\CityController::class, 'update'])->name('update-city');
        Route::get('/delete-city/{id}', [App\Http\Controllers\CityController::class, 'destroy'])->name('delete-city');
        Route::post('/import-cities', [App\Http\Controllers\CityController::class, 'importCity'])->name('import-cities');
        Route::post('/import-districts', [App\Http\Controllers\DistrictController::class, 'importDistricts'])->name('import-districts');
        Route::post('/import-communes', [App\Http\Controllers\CommuneController::class, 'importCommunes'])->name('import-communes');
        Route::post('/import-school', [App\Http\Controllers\AdministrativeController::class, 'importAdministrative'])->name('import-school');
        Route::post('/import-medical', [App\Http\Controllers\AdministrativeController::class, 'importAdministrative'])->name('import-medical');
        Route::post('/import-center', [App\Http\Controllers\AdministrativeController::class, 'importAdministrative'])->name('import-center');

        Route::delete('/delete-multiple-city', [App\Http\Controllers\CityController::class, 'destroyMultiple'])->name('delete-multiple-city');


        Route::get('/create-district', [App\Http\Controllers\DistrictController::class, 'viewFormDistrict'])->name('create-district');
        Route::post('/create-district', [App\Http\Controllers\DistrictController::class, 'store'])->name('store-district');
        Route::get('/edit-district/{id}', [App\Http\Controllers\DistrictController::class, 'show'])->name('edit-district');
        Route::post('/update-district', [App\Http\Controllers\DistrictController::class, 'update'])->name('update-district');
        Route::get('/delete-district/{id}', [App\Http\Controllers\DistrictController::class, 'destroy'])->name('delete-district');
        Route::delete('/delete-multiple-district', [App\Http\Controllers\DistrictController::class, 'destroyMultiple'])->name('delete-multiple-district');


        Route::get('/create-commune', [App\Http\Controllers\CommuneController::class, 'viewFormCommune'])->name('create-commune');
        Route::post('/create-commune', [App\Http\Controllers\CommuneController::class, 'store'])->name('store-commune');
        Route::get('/edit-commune/{id}', [App\Http\Controllers\CommuneController::class, 'show'])->name('edit-commune');
        Route::post('/update-commune', [App\Http\Controllers\CommuneController::class, 'update'])->name('update-commune');
        Route::get('/delete-commune/{id}', [App\Http\Controllers\CommuneController::class, 'destroy'])->name('delete-commune');
        Route::get('/get-commune', [App\Http\Controllers\CommuneController::class, 'getCommunesByDistrict'])->name('get-communes');
        Route::delete('/delete-multiple-commune', [App\Http\Controllers\CommuneController::class, 'destroyMultiple'])->name('delete-multiple-commune');


      
        Route::get('/create-type-of-calamity', [App\Http\Controllers\TypeOfCalamityController::class, 'viewFormTypeOfCalamity'])->name('create-type-of-calamity');
        Route::post('/create-type-of-calamity', [App\Http\Controllers\TypeOfCalamityController::class, 'store'])->name('store-type-of-calamity');
        Route::get('/edit-type-of-calamity/{id}', [App\Http\Controllers\TypeOfCalamityController::class, 'show'])->name('edit-type-of-calamity');
        Route::post('/edit-type-of-calamity', [App\Http\Controllers\TypeOfCalamityController::class, 'update'])->name('update-type-of-calamity');
        Route::get('/delete-type-of-calamity/{id}', [App\Http\Controllers\TypeOfCalamityController::class, 'destroy'])->name('delete-type-of-calamity');
        Route::delete('/delete-multiple-type-of-calamity', [App\Http\Controllers\TypeOfCalamityController::class, 'destroyMultiple'])->name('delete-multiple-type-of-calamity');

    
        Route::get('/create-risk-level', [App\Http\Controllers\RiskLevelController::class, 'viewFormRiskLevel'])->name('create-risk-level');
        Route::post('/create-risk-level', [App\Http\Controllers\RiskLevelController::class, 'store'])->name('store-risk-level');
        Route::get('/edit-risk-level/{id}', [App\Http\Controllers\RiskLevelController::class, 'show'])->name('edit-risk-level');
        Route::post('/update-risk-level', [App\Http\Controllers\RiskLevelController::class, 'update'])->name('update-risk-level');
        Route::get('/delete-risk-level/{id}', [App\Http\Controllers\RiskLevelController::class, 'destroy'])->name('delete-risk-level');
        Route::delete('/delete-multiple-risk-level', [App\Http\Controllers\RiskLevelController::class, 'destroyMultiple'])->name('delete-multiple-risk-level');

        Route::get('/create-type-of-construction', [App\Http\Controllers\TypeOfConstructionController::class, 'viewFormTypeOfConstruction'])->name('create-type-of-construction');
        Route::post('/create-type-of-construction', [App\Http\Controllers\TypeOfConstructionController::class, 'store'])->name('store-type-of-construction');
        Route::get('/edit-type-of-construction/{id}', [App\Http\Controllers\TypeOfConstructionController::class, 'show'])->name('edit-type-of-construction');
        Route::post('/update-type-of-construction', [App\Http\Controllers\TypeOfConstructionController::class, 'update'])->name('update-type-of-construction');
        Route::get('/delete-type-of-construction/{id}', [App\Http\Controllers\TypeOfConstructionController::class, 'destroy'])->name('delete-type-of-construction');
        Route::delete('/delete-multiple-type-of-construction', [App\Http\Controllers\TypeOfConstructionController::class, 'destroyMultiple'])->name('delete-multiple-type-of-construction');

      
        Route::get('/create-sub-type-of-calamity', [App\Http\Controllers\SubTypeOfCalamityController::class, 'viewFormTypeOfCalamity'])->name('create-sub-type-of-calamity');
        Route::post('/create-sub-type-of-calamity', [App\Http\Controllers\SubTypeOfCalamityController::class, 'store'])->name('store-sub-type-of-calamity');
        Route::get('/edit-sub-type-of-calamity/{id}', [App\Http\Controllers\SubTypeOfCalamityController::class, 'show'])->name('edit-sub-type-of-calamity');
        Route::post('/update-sub-type-of-calamity', [App\Http\Controllers\SubTypeOfCalamityController::class, 'update'])->name('update-sub-type-of-calamity');
        Route::get('/delete-sub-type-of-calamity/{id}', [App\Http\Controllers\SubTypeOfCalamityController::class, 'destroy'])->name('delete-sub-type-of-calamity');
        Route::delete('/delete-multiple-sub-type-of-calamity', [App\Http\Controllers\SubTypeOfCalamityController::class, 'destroyMultiple'])->name('delete-multiple-sub-type-of-calamity');

       
        Route::get('/create-scenarios', [App\Http\Controllers\ResponsePlan\ScenarioController::class, 'viewFormScenarios'])->name('create-scenarios');
        Route::post('/create-scenarios', [App\Http\Controllers\ResponsePlan\ScenarioController::class, 'store'])->name('store-scenarios');
        Route::get('/edit-scenarios/{id}', [App\Http\Controllers\ResponsePlan\ScenarioController::class, 'show'])->name('edit-scenarios');
        Route::post('/update-scenarios', [App\Http\Controllers\ResponsePlan\ScenarioController::class, 'update'])->name('update-scenarios');
        Route::get('/delete-scenarios/{id}', [App\Http\Controllers\ResponsePlan\ScenarioController::class, 'destroy'])->name('delete-scenarios');
        Route::delete('/delete-multiple-scenarios', [App\Http\Controllers\ResponsePlan\ScenarioController::class, 'destroyMultiple'])->name('delete-multiple-scenarios');

        Route::prefix('calamity')->group(function () {
            Route::get('/create-river-bank', [App\Http\Controllers\Calamities\RiverBankCalamityController::class, 'viewFormRiverbank'])->name('create-calamity-river-bank');
            Route::post('/create-river-bank', [App\Http\Controllers\Calamities\RiverBankCalamityController::class, 'store'])->name('store-calamity-river-bank');
            Route::get('/edit-river-bank/{id}', [App\Http\Controllers\Calamities\RiverBankCalamityController::class, 'show'])->name('edit-calamity-river-bank');
            Route::post('/update-river-bank', [App\Http\Controllers\Calamities\RiverBankCalamityController::class, 'update'])->name('update-calamity-river-bank');
            Route::get('/delete-river-bank/{id}', [App\Http\Controllers\Calamities\RiverBankCalamityController::class, 'destroy'])->name('delete-calamity-river-bank');
            Route::delete('/delete-multiple-river-bank', [App\Http\Controllers\Calamities\RiverBankCalamityController::class, 'destroyMultiple'])->name('delete-multiple-calamity-river-bank');
            Route::post('/import-river-bank', [App\Http\Controllers\Calamities\RiverBankCalamityController::class, 'importRiverbank'])->name('import-river-bank-calamity');
            Route::post('/import-flooding', [App\Http\Controllers\Calamities\FloodingCalamityController::class, 'importFlooding'])->name('import-flooding-calamity');
            Route::post('/import-storm', [App\Http\Controllers\Calamities\StormCalamityController::class, 'importStorm'])->name('import-storm-calamity');

            Route::get('/create-flooding', [App\Http\Controllers\Calamities\FloodingCalamityController::class, 'viewFormFlooding'])->name('create-calamity-flooding');
            Route::post('/create-flooding', [App\Http\Controllers\Calamities\FloodingCalamityController::class, 'store'])->name('store-calamity-flooding');
            Route::get('/edit-flooding/{id}', [App\Http\Controllers\Calamities\FloodingCalamityController::class, 'show'])->name('edit-calamity-flooding');
            Route::post('/update-flooding', [App\Http\Controllers\Calamities\FloodingCalamityController::class, 'update'])->name('update-calamity-flooding');
            Route::get('/delete-flooding/{id}', [App\Http\Controllers\Calamities\FloodingCalamityController::class, 'destroy'])->name('delete-calamity-flooding');
            Route::delete('/delete-multiple-flooding', [App\Http\Controllers\Calamities\FloodingCalamityController::class, 'destroyMultiple'])->name('delete-multiple-calamity-flooding');
            Route::post('/import-flooding', [App\Http\Controllers\Calamities\FloodingCalamityController::class, 'importFlooding'])->name('import-flooding-calamity');
            
            Route::get('/create-storm', [App\Http\Controllers\Calamities\StormCalamityController::class, 'viewFormStorm'])->name('create-calamity-storm');
            Route::post('/create-storm', [App\Http\Controllers\Calamities\StormCalamityController::class, 'store'])->name('store-calamity-storm');
            Route::get('/edit-storm/{id}', [App\Http\Controllers\Calamities\StormCalamityController::class, 'show'])->name('edit-calamity-storm');
            Route::post('/update-storm', [App\Http\Controllers\Calamities\StormCalamityController::class, 'update'])->name('update-calamity-storm');
            Route::get('/delete-storm/{id}', [App\Http\Controllers\Calamities\StormCalamityController::class, 'destroy'])->name('delete-calamity-storm');
            Route::delete('/delete-multiple-storm', [App\Http\Controllers\Calamities\StormCalamityController::class, 'destroyMultiple'])->name('delete-multiple-calamity-storm');
            Route::post('/import-storm', [App\Http\Controllers\Calamities\StormCalamityController::class, 'importStorm'])->name('import-storm-calamity');
       
        });
        

        Route::prefix('construction')->group(function () {
           
            Route::get('/create-river-bank', [App\Http\Controllers\Constructions\RiverBankConstructionController::class, 'viewFormRiverbank'])->name('create-construction-river-bank');
            Route::post('/create-river-bank', [App\Http\Controllers\Constructions\RiverBankConstructionController::class, 'store'])->name('store-construction-river-bank');
            Route::get('/edit-river-bank/{id}', [App\Http\Controllers\Constructions\RiverBankConstructionController::class, 'show'])->name('edit-construction-river-bank');
            Route::post('/update-river-bank', [App\Http\Controllers\Constructions\RiverBankConstructionController::class, 'update'])->name('update-construction-river-bank');
            Route::get('/delete-river-bank/{id}', [App\Http\Controllers\Constructions\RiverBankConstructionController::class, 'destroy'])->name('delete-construction-river-bank');
            Route::delete('/delete-multiple-river-bank', [App\Http\Controllers\Constructions\RiverBankConstructionController::class, 'destroyMultiple'])->name('delete-multiple-construction-river-bank');
            Route::post('/import-river-bank-construction', [App\Http\Controllers\Constructions\RiverBankConstructionController::class, 'importRiverBankConstruction'])->name('import-river-bank-construction');

           
            Route::get('/create-flooding', [App\Http\Controllers\Constructions\FloodingConstructionController::class, 'viewFormFlooding'])->name('create-construction-flooding');
            Route::post('/create-flooding', [App\Http\Controllers\Constructions\FloodingConstructionController::class, 'store'])->name('store-construction-flooding');
            Route::get('/edit-flooding/{id}', [App\Http\Controllers\Constructions\FloodingConstructionController::class, 'show'])->name('edit-construction-flooding');
            Route::post('/update-flooding', [App\Http\Controllers\Constructions\FloodingConstructionController::class, 'update'])->name('update-construction-flooding');
            Route::get('/delete-flooding/{id}', [App\Http\Controllers\Constructions\FloodingConstructionController::class, 'destroy'])->name('delete-construction-flooding');
            Route::delete('/delete-multiple-flooding', [App\Http\Controllers\Constructions\FloodingConstructionController::class, 'destroyMultiple'])->name('delete-multiple-construction-flooding');
            Route::post('/import-flooding-construction', [App\Http\Controllers\Constructions\FloodingConstructionController::class, 'importFloodingConstruction'])->name('import-flooding-construction');

            Route::get('/create-storm', [App\Http\Controllers\Constructions\StormConstructionController::class, 'viewFormStorm'])->name('create-construction-storm');
            Route::post('/create-storm', [App\Http\Controllers\Constructions\StormConstructionController::class, 'store'])->name('store-construction-storm');
            Route::get('/edit-storm/{id}', [App\Http\Controllers\Constructions\StormConstructionController::class, 'show'])->name('edit-construction-storm');
            Route::post('/update-storm', [App\Http\Controllers\Constructions\StormConstructionController::class, 'update'])->name('update-construction-storm');
            Route::get('/delete-storm/{id}', [App\Http\Controllers\Constructions\StormConstructionController::class, 'destroy'])->name('delete-construction-storm');
            Route::delete('/delete-multiple-storm', [App\Http\Controllers\Constructions\StormConstructionController::class, 'destroyMultiple'])->name('delete-multiple-construction-storm');
            Route::post('/import-storm-construction', [App\Http\Controllers\Constructions\StormConstructionController::class, 'importStormConstruction'])->name('import-storm-construction');

        });
        
        Route::prefix('administrative')->group(function () {
            $types = ['school', 'medical', 'center'];
            foreach ($types as $type) {
                Route::get("/create-{$type}", [App\Http\Controllers\AdministrativeController::class, 'viewForm'])
                    ->name("create-{$type}")->defaults('type', $type);

                Route::post("/create-{$type}", [App\Http\Controllers\AdministrativeController::class, 'store'])
                    ->name("store-{$type}")->defaults('type', $type);

                Route::get("/edit-{$type}/{id}", [App\Http\Controllers\AdministrativeController::class, 'show'])
                    ->name("edit-{$type}");
                Route::post("/edit-{$type}", [App\Http\Controllers\AdministrativeController::class, 'update'])
                    ->name("update-{$type}");

                Route::get("/delete-{$type}/{id}", [App\Http\Controllers\AdministrativeController::class, 'destroy'])
                    ->name("delete-{$type}");
                    
                Route::delete("/delete-multiple-{$type}", [App\Http\Controllers\AdministrativeController::class, 'destroyMultiple'])
                    ->name("delete-multiple-{$type}")->defaults('type', $type);
            }
        });
        Route::prefix('geographical')->group(function () {
            $types = ['erosion', 'shoreline', 'cross-section', 'monitoring'];
            foreach ($types as $type) {
                Route::get("/create-{$type}", [App\Http\Controllers\AdministrativeController::class, 'viewForm'])
                    ->name("create-{$type}")->defaults('type', $type);

                Route::post("/create-{$type}", [App\Http\Controllers\AdministrativeController::class, 'store'])
                    ->name("store-{$type}")->defaults('type', $type);

                Route::get("/edit-{$type}/{id}", [App\Http\Controllers\AdministrativeController::class, 'show'])
                    ->name("edit-{$type}");
                Route::post("/edit-{$type}", [App\Http\Controllers\AdministrativeController::class, 'update'])
                    ->name("update-{$type}");

                Route::get("/delete-{$type}/{id}", [App\Http\Controllers\AdministrativeController::class, 'destroy'])
                    ->name("delete-{$type}");
                    
                Route::delete("/delete-multiple-{$type}", [App\Http\Controllers\AdministrativeController::class, 'destroyMultiple'])
                    ->name("delete-multiple-{$type}")->defaults('type', $type);
            }
        });
    
    
    });



    
    
    
  
    





   

   








   

   




Route::prefix('export')->group(function () {
    Route::get('/storm', [App\Http\Controllers\ExportController::class, 'exportStormCalamity'])->name('export-storm-calamity');
    Route::get('/river-bank', [App\Http\Controllers\ExportController::class, 'exportRiverBankCalamity'])->name('export-river-bank-calamity');
    Route::get('/flooding', [App\Http\Controllers\ExportController::class, 'exportFloodingCalamity'])->name('export-flooding-calamity');
    Route::get('/storm-construction', [App\Http\Controllers\ExportController::class, 'exportStormConstruction'])->name('export-storm-construction');
    Route::get('/flooding-construction', [App\Http\Controllers\ExportController::class, 'exportFloodingConstruction'])->name('export-flooding-construction');
    Route::get('/river-bank-construction', [App\Http\Controllers\ExportController::class, 'exportRiverBankConstruction'])->name('export-river-bank-construction');
});





   

   





   

   


