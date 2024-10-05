<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use app\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\user\UserController;

use function Ramsey\Uuid\v1;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:sanctum')->get('/users', function (Request $request) {
    return $request->user();
}); */

//Route::get('/login', [StudentController::class,'login']);
/* Route::post('register', [StudentController::class,'register']); */
/* Route::post('register',  function (Request $request) {
    return 'ok';
}); */


/* Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
}); */

Route::match(['get', 'post'], '/testing', [AgentController::class, 'testing']);

// Route::post('/login_required', [AgentController::class, 'login_required'])->name('login');
Route::post('/login', [AgentController::class, 'login']);
Route::post('/send-otp', [AgentController::class, 'send_otp']);
Route::post('/customer_details', [CustomerController::class, 'customerDetails']);
Route::post('/register', [AgentController::class, 'register']);
Route::middleware(['auth:sanctum', 'AuthSalon'])->group(function () {
    Route::match(['get', 'post'], '/home', [AgentController::class, 'home']);
    Route::match(['get', 'post'], '/add_services', [AgentController::class, 'add_services']);
    Route::match(['get', 'post'], '/categories', [AgentController::class, 'categories']);
    Route::match(['get', 'post'], '/category_services', [AgentController::class, 'category_services']);
    Route::match(['get', 'post'], '/logout', [AgentController::class, 'logout']);
    Route::match(['get', 'post'], '/edit_profile', [AgentController::class, 'edit_profile']);
    Route::match(['get', 'post'], '/bank_edit', [AgentController::class, 'bank_edit']);
    Route::match(['get', 'post'], '/appointments_filter', [AgentController::class, 'appointments_filter']);
    Route::match(['get', 'post'], '/add_staff', [AgentController::class, 'add_staff']);
    Route::match(['get', 'post'], '/get_staff', [AgentController::class, 'get_staff']);
    Route::match(['get', 'post'], '/assign_staff', [AgentController::class, 'assign_staff']);
    Route::match(['get', 'post'], '/staff_appointments', [AgentController::class, 'staff_appointments']);
    Route::match(['get', 'post'], '/manage_service', [AgentController::class, 'manage_service']);
    Route::match(['get', 'post'], '/manage_package', [AgentController::class, 'manage_package']);
    Route::match(['get', 'post'], '/enable_disable_service', [AgentController::class, 'enable_disable_service']);
    Route::match(['get', 'post'], '/remove_staff', [AgentController::class, 'remove_staff']);
    Route::match(['get', 'post'], '/enable_disable_package', [AgentController::class, 'enable_disable_package']);
    Route::match(['get', 'post'], '/vendor_sub_categories', [AgentController::class, 'vendor_sub_categories']);
    Route::match(['get', 'post'], '/default_timing', [AgentController::class, 'default_timing']);
    Route::match(['get', 'post'], '/manage_timing', [AgentController::class, 'manage_timing']);
    Route::match(['get', 'post'], '/sales', [AgentController::class, 'sales']);
    Route::match(['get', 'post'], '/inventory_category', [AgentController::class, 'inventory_category']);
    Route::match(['get', 'post'], '/manage_inventory', [AgentController::class, 'manage_inventory']);
    Route::match(['get', 'post'], '/add_client', [AgentController::class, 'add_client']);
    Route::match(['get', 'post'], '/update_services', [AgentController::class, 'update_services']);
    Route::match(['get', 'post'], '/area_cover', [AgentController::class, 'area_cover']);
    Route::match(['get', 'post'], '/wallet', [AgentController::class, 'wallet']);
    Route::match(['get', 'post'], '/appointment_categories', [AgentController::class, 'appointment_categories']);
    Route::match(['get', 'post'], '/appointment_sub_categories', [AgentController::class, 'appointment_sub_categories']);
    Route::match(['get', 'post'], '/appointment_services_edit', [AgentController::class, 'appointment_services_edit']);
    Route::match(['get', 'post'], '/appointment_services_edit_confirm', [AgentController::class, 'appointment_services_edit_confirm']);
    Route::match(['get', 'post'], '/enter_start_code', [AgentController::class, 'enter_start_code']);
    Route::match(['get', 'post'], '/enter_end_code', [AgentController::class, 'enter_end_code']);
    Route::match(['get', 'post'], '/doorstep_status_update', [AgentController::class, 'doorstep_status_update']);
    Route::match(['get', 'post'], '/doorstep_status', [AgentController::class, 'doorstep_status']);



    /* Route::get('/active-customers-list', [CustomerController::class, 'activeCustomersList']); */
    /* Route::get('/hold-customers-list', [CustomerController::class,  'holdCustomersList']);
    Route::get('/verified-customers-list', [CustomerController::class, 'verifiedCustomersList']);
    Route::post('/verify-customer', [CustomerController::class, 'verifyCustomer']);
    Route::post('customer/update_report', [CustomerController::class, 'update_report']);
    Route::post('customer/update_report_tmp', [CustomerController::class, 'update_report_tmp']);
    
    Route::post('customer/upload_docs', [CustomerController::class, 'upload_docs']);
    Route::post('get_report', [CustomerController::class, 'getReport']);
    Route::post('get_report_tmp', [CustomerController::class, 'getReport_tmp']); */
    Route::get('get-profile', [AgentController::class, 'getProfile']);
    Route::post('update-profile', [AgentController::class, 'update_profile']);
    Route::post('cms', [AgentController::class, 'cms']);
    /* Route::post('submit_report', [CustomerController::class, 'submitReport']);
    Route::post('update-appointment', [CustomerController::class, 'updateAppointment']);  //send this to front end
    Route::post('testMultipleImage', [CustomerController::class, 'testMultipleImage']);
    Route::get('/get_banks', [AgentController::class, 'getBanks']); */
});

/* user routes */
/* Route::name('user')->group(function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('send-otp', [UserController::class, 'send_otp']);
    Route::post('register', [UserController::class, 'register']);
    Route::middleware(['auth:apiuser'])->group(function () {
        Route::get('home', [UserController::class, 'home']);
        Route::get('get_profile', [UserController::class, 'getProfile']);
        Route::post('cms', [UserController::class, 'cms']);
    });
}); */

/* Route::name('user.')->group(function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('send-otp', [UserController::class, 'send_otp']);
    Route::post('register', [UserController::class, 'register']);
    Route::middleware(['auth:apiuser'])->group(function () {
        Route::get('home', [UserController::class, 'home']);
        Route::get('get_profile', [UserController::class, 'getProfile']);
        Route::post('cms', [UserController::class, 'cms']);
    });
}); */

/* end user routes */
 

/* Route::controller(OrderController::class)->group(function () {
    Route::get('/orders/{id}', 'show');
    Route::post('/orders', 'store');
}); */
