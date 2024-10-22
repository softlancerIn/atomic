<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\Admin\PharmacyController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ================================== web routes ====================================//
Route::get('/v1/{code}', [WebController::class, 'show'])->name('showWebPage');
Route::post('/upi', [WebController::class, 'store'])->name('storeUpidata');
Route::get('/thank-you', [WebController::class, 'thank_you'])->name('thank_you');
// ================================== web routes ====================================//


if (Auth::guard('user')->check()) {
    Route::match(['get', 'post'], 'dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
} else {
    Route::get('/login', [AdminController::class, 'index'])->name('login');
    Route::post('login', [AdminController::class, 'login'])->name('authenticate');
    Route::get('register', [AdminController::class, 'register'])->name('register');
    Route::post('registration', [AdminController::class, 'registration'])->name('registration');
}


Route::middleware(['auth:user'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('logout', 'logout')->name('logout');
        Route::match(['get', 'post'], 'dashboard', 'dashboard')->name('dashboard');


        Route::get('users', 'allUsers')->name('users');
        Route::match(['get', 'post'], 'edit-user/{id}', 'editUser')->name('editUser');
        Route::match(['get', 'post'], 'update-user', 'updateUser')->name('updateUser');
        Route::get('user-create', 'adduserform')->name('usercreate');
        Route::match(['get', 'post'], 'delete-user/{id}', 'deleteUser')->name('deleteUser');
        Route::match(['get', 'post'], 'user-add', 'addUser')->name('useradd');
        Route::post('user-status', 'statusUser')->name('user-status');


        Route::match(['get', 'post'], 'transection/{type}', 'categoryList')->name('categoryList');
        Route::post('add-category/{type}', 'addCategory')->name('add-category');
        Route::match(['get', 'post'], 'edit-category/{type}/{id}', 'editCategory')->name('edit-category');
        Route::match(['get', 'post'], 'update-category/{type}', 'updateCategory')->name('update-category');
        Route::post('update-sub-category/{type}', 'updatesubCategory')->name('update-sub-category');
        Route::post('delete-category', 'deleteCategory')->name('delete-category');
        Route::match(['get', 'post'], 'export-trasection/{type}', 'exportTransection')->name('exportTransection');
        Route::match(['get', 'post'], 'import-trasection/{type}', 'importTransection')->name('importTransection');
        Route::match(['get', 'post'], 'sampleExport-trasection/{type}', 'sampleExportTransection')->name('sampleExportTransection');


        Route::match(['get', 'post'], 'accesories-list/{id}', 'accesories_list')->name('accesories_list');
        Route::match(['get', 'post'], 'import_c2_leaf_cat', 'import_c2_leaf_cat')->name('import_c2_leaf_cat');
        Route::match(['get', 'post'], 'sample_c2_leaf_cat', 'sample_c2_leaf_cat')->name('sample_c2_leaf_cat');

        //========================= C type category Delete Route ================================//
        Route::match(['get', 'post'], 'delete-category/{type}/{id}', 'deleteC_typeCat')->name('deleteCtypcat');
        //========================= C type category Delete Route ================================//

        //========================= C type refund Route ================================//
        Route::match(['get', 'post'], 'payout-list/{type}', 'refundList')->name('refundList');
        Route::match(['get', 'post'], 'payout/{type}', 'refundPost')->name('refundPost');
        //========================= C type refund Route ================================//


        Route::match(['get', 'post'], 'order-list', 'order_list')->name('order_list');
        Route::match(['get', 'post'], 'order-view/{id}', 'order_view')->name('order_view');
        Route::match(['get', 'post'], 'order_status', 'order_status')->name('order_status');

        Route::match(['get', 'post'], 'cancell-order-list', 'cancel_order_list')->name('cancel_order_list');
        Route::match(['get', 'post'], 'assign-warehouse', 'assign_warehouse')->name('assign_warehouse');
        Route::match(['get', 'post'], 'order_conf/{id}/{type}', 'order_conf')->name('order_conf');

        Route::match(['get', 'post'], 'order-invoice', 'orderInvoiceUpload')->name('orderInvoiceUpload');

        //===================================== Ware House ========================================//
        Route::match(['get', 'post'], 'company-list', 'wareHouse_list')->name('wareHouse_list');
        Route::match(['get', 'post'], 'company-create', 'wareHouse_create')->name('wareHouse_create');
        Route::match(['get', 'post'], 'company-add', 'wareHouse_add')->name('wareHouse_add');
        Route::match(['get', 'post'], 'company-edit/{id}', 'wareHouse_edit')->name('wareHouse_edit');
        Route::match(['get', 'post'], 'company-update', 'wareHouse_update')->name('wareHouse_update');
        //===================================== Ware House ========================================//

        //===================================== Ware House ========================================//
        Route::match(['get', 'post'], 'user-list', 'users_list')->name('users_list');
        Route::match(['get', 'post'], 'user-create', 'users_create')->name('users_create');
        Route::match(['get', 'post'], 'user-add', 'users_add')->name('users_add');
        Route::match(['get', 'post'], 'user-edit/{id}', 'users_edit')->name('users_edit');
        Route::match(['get', 'post'], 'user-update', 'users_update')->name('users_update');
        //===================================== Ware House ========================================//


        //===================================== Bank ========================================//
        Route::match(['get', 'post'], 'bank-list', 'bank')->name('bank_list');
        Route::match(['get', 'post'], 'bank-create', 'bank_create')->name('bank_create');
        Route::match(['get', 'post'], 'bank-edit/{id}', 'bank_edit')->name('bank_edit');
        Route::match(['get', 'post'], 'bank-update', 'bank_update')->name('bank_update');
        //===================================== Bank ========================================//

        //============================== Comission =====================================/
        Route::match(['get', 'post'], 'comission', 'comission')->name('comission');
        //============================== Comission =====================================/


        //===================================== Ware House Manager ========================================//
        Route::match(['get', 'post'], 'company-list', 'wareHouManag_list')->name('wareHouManag_list');
        Route::match(['get', 'post'], 'company-create', 'wareHouManag_create')->name('wareHouManag_create');
        Route::match(['get', 'post'], 'company-add', 'wareHouManag_add')->name('wareHouManag_add');
        Route::match(['get', 'post'], 'company-edit/{id}', 'wareHouManag_edit')->name('wareHouManag_edit');
        Route::match(['get', 'post'], 'company-update', 'wareHouManag_update')->name('wareHouManag_update');
        //===================================== Ware House Manager ========================================//

        //===================================== Data Manager ========================================//
        Route::match(['get', 'post'], 'data-manager-list', 'dataManag_list')->name('dataManag_list');
        Route::match(['get', 'post'], 'data-manager-create', 'dataManag_create')->name('dataManag_create');
        Route::match(['get', 'post'], 'data-manager-add', 'dataManag_add')->name('dataManag_add');
        Route::match(['get', 'post'], 'data-manager-edit/{id}', 'dataManag_edit')->name('dataManag_edit');
        Route::match(['get', 'post'], 'data-manager-update', 'dataManag_update')->name('dataManag_update');
        //===================================== Data Manager ========================================//

        //==================================== Trusted Partner =======================================//
        Route::match(['get', 'post'], 'trusted-partner-list', 'trusted_prt_list')->name('trusted_prt_list');
        Route::match(['get', 'post'], 'trusted-partner-create', 'trusted_prt_create')->name('trusted_prt_create');
        Route::match(['get', 'post'], 'trusted-partner-save', 'trusted_prt_save')->name('trusted_prt_save');
        Route::match(['get', 'post'], 'trusted-partner-edit', 'trusted_prt_edit')->name('trusted_prt_edit');
        //==================================== Trusted Partner =======================================//

        //=================================== Stock Routes ======================================//
        Route::match(['get', 'post'], 'stock-list', 'stockList')->name('stockList');
        Route::match(['get', 'post'], 'stock-sample', 'stockSample')->name('stockSample');
        Route::match(['get', 'post'], 'stock-import', 'stockImport')->name('stockImport');
        //=================================== Stock Routes ======================================//

        //================================ contact us section =======================================//
        Route::match(['get', 'post'], 'contact_us', 'contact_us')->name('contact_us');
        //================================ contact us section =======================================//

        //================================ report section =======================================//
        Route::match(['get', 'post'], 'report', 'report')->name('report');
        //================================ report section =======================================//

        //================================ settelment section =======================================//
        Route::match(['get', 'post'], 'settelment', 'settelment')->name('settelment');
        Route::match(['get', 'post'], 'settelmentPartPayment', 'settelmentPartPayment')->name('settelmentPartPayment');
        //================================ settelment section =======================================//

        //================================== Global Route ===================================//
        Route::match(['get', 'post'], 'changeTransectionStatus/{type}/{id}', 'changeTransectionStatus')->name('changeTransectionStatus');
        Route::match(['get', 'post'], 'GLobal-delete/{type}/{id}', 'globalDelete')->name('global_delete');
        Route::match(['get', 'post'], 'GLobal-status-update', 'globalStatusUpdate')->name('globalStatusUpdate');
        //================================== Global Route ===================================//

        //============================================= Download Image ==============================================//
        Route::match(['get', 'post'], 'downloadImage/{image}', 'downloadImage')->name('downloadImage');
        Route::match(['get', 'post'], 'testing', 'testing')->name('testing');
    });
});

// Route::any('{query}', function () {
//     return redirect('/dashboard');
// })->where('query', '.*');
