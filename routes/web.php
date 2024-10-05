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

// web routes

Route::get('/upi', [WebController::class, 'show'])->name('showWebPage');
Route::post('/upi', [WebController::class, 'store'])->name('storeUpidata');


if (Auth::guard('user')->check()) {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
} else {
    Route::get('/login', [AdminController::class, 'index'])->name('login');
    Route::post('login', [AdminController::class, 'login'])->name('authenticate');
    Route::get('register', [AdminController::class, 'register'])->name('register');
    Route::post('registration', [AdminController::class, 'registration'])->name('registration');
}


Route::middleware(['auth:user'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('logout', 'logout')->name('logout');
        Route::get('dashboard', 'dashboard')->name('dashboard');


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

        Route::match(['get', 'post'], 'accesories-list/{id}', 'accesories_list')->name('accesories_list');
        Route::match(['get', 'post'], 'import_c2_leaf_cat', 'import_c2_leaf_cat')->name('import_c2_leaf_cat');
        Route::match(['get', 'post'], 'sample_c2_leaf_cat', 'sample_c2_leaf_cat')->name('sample_c2_leaf_cat');

        //========================= C type category Delete Route ================================//
        Route::match(['get', 'post'], 'delete-category/{type}/{id}', 'deleteC_typeCat')->name('deleteCtypcat');
        //========================= C type category Delete Route ================================//

        //========================= Brand Releted Route ========================//
        Route::match(['get', 'post'], 'brand-list', 'brandList')->name('brandList');
        Route::match(['get', 'post'], 'brand-add', 'brandAdd')->name('brand_add');
        Route::match(['get', 'post'], 'brand-edit/{id}', 'brandEdit')->name('brand_edit');
        //========================= Brand Releted Route ========================//

        //========================= Discount Coupon Releted Route ========================//
        Route::match(['get', 'post'], 'coupon_list', 'coupon_list')->name('coupon_list');
        Route::match(['get', 'post'], 'counpon_create', 'counpon_create')->name('counpon_create');
        Route::match(['get', 'post'], 'coupon_add', 'coupon_add')->name('coupon_add');
        Route::match(['get', 'post'], 'coupon_edit/{id}', 'coupon_edit')->name('coupon_edit');
        Route::match(['get', 'post'], 'coupon_update', 'coupon_update')->name('coupon_update');
        Route::match(['get', 'post'], 'coupon_delete/{id}', 'coupon_delete')->name('coupon_delete');
        //========================= Discount Coupon Releted Route ========================//


        Route::get('sub-category-list', 'subCategoryList')->name('subCategoryList');
        Route::get('add-subCategory/{type}/{id}', 'addSubCategory')->name('addSubCategory');
        Route::post('save-subCategory', 'saveSubCategory')->name('saveSubCategory');
        Route::post('update-category', 'updateCategory')->name('update-category');
        Route::post('update-sub-category', 'updatesubCategory')->name('update-sub-category');
        Route::post('delete-category', 'deleteCategory')->name('delete-category');

        Route::match(['get', 'post'], 'sub-category/{cat_id}', 'sub_category')->name('sub_category');
        Route::match(['get', 'post'], 'add-subcategory/{type}/{cat_id}/{id}', 'add_subcategory_form')->name('add_subcategory_form');
        Route::match(['get', 'post'], 'add-subcategory', 'add_subcategory')->name('add_subcategory');
        Route::post('delete-sub_category', 'delSubCategory')->name('delete-sub_category');

        Route::get('banners', 'banner')->name('banners');
        Route::post('banner-dropdown-data', 'banner_dropdown_data')->name('banner-dropdown-data');
        Route::get('banners-create', 'addbannersForm')->name('banners-create');
        Route::match(['get', 'post'], 'add-banner', 'addBanner')->name('addbanner');
        Route::match(['get', 'post'], 'edit-banner/{id}', 'editBanner')->name('edit-banner');
        Route::match(['get', 'post'], 'update-banner', 'upadateBanner')->name('updatebanner');
        Route::get('delete-banner/{id}', 'deleteBanner')->name('delete_banner');


        Route::match(['get', 'post'], 'product-list', 'product_list')->name('product_list');
        Route::match(['get', 'post'], 'export-product-sample', 'export_pro_sample')->name('export_sample');
        Route::match(['get', 'post'], 'import-product', 'import_product')->name('import_product');
        Route::match(['get', 'post'], 'export-product-data', 'export_pro_data')->name('export_data');
        Route::match(['get', 'post'], 'product-edit/{id}', 'product_edit')->name('product_edit');
        Route::match(['get', 'post'], 'product-update', 'product_update')->name('product_update');


        Route::match(['get', 'post'], 'testing-import-product', 'testing_import_product')->name('testing_import_product');


        Route::match(['get', 'post'], 'product_create/{id}', 'product_create')->name('product_create');
        Route::match(['get', 'post'], 'product_save', 'product_save')->name('product_save');
        Route::match(['get', 'post'], 'product-varient-list/{id}', 'product_varientList')->name('product_varientList');
        Route::match(['get', 'post'], 'add-product-varient/{id}', 'addProductVarient')->name('addProductVarient');
        Route::match(['get', 'post'], 'edit-product-varient', 'editProductVarient')->name('editProductVarient');
        Route::match(['get', 'post'], 'save-product-varient', 'saveProductVarient')->name('saveProductVarient');
        Route::match(['get', 'post'], 'get_subCatData', 'get_subCatData')->name('get_subCatData');


        Route::match(['get', 'post'], 'home-slider-list', 'home_slider_list')->name('home_slider_list');
        Route::match(['get', 'post'], 'home-slider-create', 'home_slider_create')->name('home_slider_create');
        Route::match(['get', 'post'], 'home-slider-save', 'home_slider_save')->name('home_slider_save');
        Route::match(['get', 'post'], 'home-slider-edit/{id}', 'home_slider_edit')->name('home_slider_edit');
        Route::match(['get', 'post'], 'get-product-list', 'get_product_list')->name('get_product_list');


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


        //===================================== Bank ========================================//
        Route::match(['get', 'post'], 'bank-list', 'bank')->name('bank_list');
        Route::match(['get', 'post'], 'bank-create', 'bank_create')->name('bank_create');
        // Route::match(['get', 'post'], 'bank-add', 'bank_add')->name('bank_add');
        Route::match(['get', 'post'], 'bank-edit/{id}', 'bank_edit')->name('bank_edit');
        Route::match(['get', 'post'], 'bank-update', 'bank_update')->name('bank_update');
        //===================================== Bank ========================================//




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

        //==================================== Industry Section =======================================//
        Route::match(['get', 'post'], 'industry-list', 'industry_list')->name('industry_list');
        Route::match(['get', 'post'], 'industry-save', 'industry_save')->name('industry_save');
        Route::match(['get', 'post'], 'industry-edit', 'industry_edit')->name('industry_edit');
        //==================================== Industry Section =======================================//

        //==================================== offer Section =======================================//
        Route::match(['get', 'post'], 'offer-list', 'offer_list')->name('offer_list');
        Route::match(['get', 'post'], 'offer-save', 'offer_save')->name('offer_save');
        Route::match(['get', 'post'], 'offer-edit', 'offer_edit')->name('offer_edit');
        //==================================== offer Section =======================================//

        //==================================== career Section =======================================//
        Route::match(['get', 'post'], 'career-list', 'career_list')->name('career_list');
        Route::match(['get', 'post'], 'career-create', 'career_create')->name('career_create');
        Route::match(['get', 'post'], 'career-save', 'career_save')->name('career_save');
        Route::match(['get', 'post'], 'career-edit/{id}', 'career_edit')->name('career_edit');
        //==================================== career Section =======================================//

        //================================ contact us section =======================================//
        Route::match(['get', 'post'], 'contact_us', 'contact_us')->name('contact_us');
        //================================ contact us section =======================================//

        //============================== Reward Section =====================================//
        Route::match(['get', 'post'], 'reward_list', 'reward_list')->name('reward_list');
        Route::match(['get', 'post'], 'add_reward', 'add_reward')->name('add_reward');
        Route::match(['get', 'post'], 'edit_reward', 'edit_reward')->name('edit_reward');
        //============================== Reward Section =====================================//

        //=============================== Upload Image Section ====================================//
        Route::match(['get', 'post'], 'upload-image-list', 'upload_image_list')->name('upload_image_list');
        Route::match(['get', 'post'], 'upload-image-save', 'upload_image_save')->name('upload_image_save');
        //=============================== Upload Image Section ====================================//

        //================================== Global Delete Route ===================================//
        Route::match(['get', 'post'], 'GLobal-delete/{type}/{id}', 'globalDelete')->name('global_delete');
        //================================== Global Delete Route ===================================//

        //============================================= Download Image ==============================================//
        Route::match(['get', 'post'], 'downloadImage/{image}', 'downloadImage')->name('downloadImage');
        Route::match(['get', 'post'], 'testing', 'testing')->name('testing');
    });
});

Route::any('{query}', function () {
    return redirect('/dashboard');
})->where('query', '.*');
