<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ConfigureConttroller;
use App\Http\Controllers\DirectoryController;

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
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\StempController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmateraiController;

// Route::resource('/test', TestController::class);
// Route::get('/test', [TestController::class, 'index'])->name('test');
// Route::get('/test/api', [TestController::class, 'api'])->name('test-api');
// Route::get('/test/login', [TestController::class, 'login']);
// Route::get('/test/sn', [TestController::class, 'sn']);

Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');

/** 
 * Guest
 */
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');



Route::group(['middleware' => ['auth'],], function () {
    /** 
     * Auth 
     */
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');
    /**
     * ADMIN CONTROLLER
     */
    // Route::get('/users', [UserManagementController::class, 'index'])->name('users');
    // Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    // Route::resource('/test', TestController::class);\
    
    Route::get('/roles/permissions', [App\Http\Controllers\Admin\RoleController::class,'permissions_create'])->middleware('auth')->name('permissions-create');
    Route::post('/roles/permissions', [App\Http\Controllers\Admin\RoleController::class,'permissions_store'])->middleware('auth')->name('permissions-store');
    Route::resource('/roles', RoleController::class);

    Route::resource('/users', UserManagementController::class);
    Route::get('/server/php', [App\Http\Controllers\Admin\ServerController::class,'phpinfo'])->middleware('auth')->name('phpinfo');

    /**
    * Configure
    */
    Route::get('/configure', [ConfigureConttroller::class, 'index'])->middleware('auth')->name('configure');
    Route::get('/configure/create', [ConfigureConttroller::class, 'create'])->middleware('auth')->name('configurecreate');
    Route::post('/configure/store', [ConfigureConttroller::class, 'store'])->middleware('auth')->name('configure-store');
    Route::resource('/configure/company', CompanyController::class);
    Route::resource('/configure/directory', DirectoryController::class);
    Route::post('/configure/directory/upload', [DirectoryController::class, 'upload'])->middleware('auth')->name('doc-upload');


    // STEMP 
    Route::get('/stemp/company', [StempController::class, 'company'])->middleware('auth')->name('company');
    Route::get('/stemp/company/{company}', [StempController::class, 'directory'])->middleware('auth')->name('directory');
    Route::get('/stemp/company/directory/{directory}', [StempController::class, 'document'])->middleware('auth')->name('document');
    Route::get('/stemp/company/directory/add/{directory}', [StempController::class, 'addfile'])->middleware('auth')->name('add.file');
    Route::get('/stemp/process/{document}', [StempController::class, 'process'])->middleware('auth')->name('process');
    Route::post('/stemp/stemp', [StempController::class, 'stemp'])->middleware('auth')->name('stemp.stemp');
    Route::get('/stemp/success', [StempController::class, 'success'])->middleware('auth')->name('success');
    Route::get('/stemp/_modalProcess', [StempController::class, '_modalProcess'])->middleware('auth')->name('_modalProcess');
    
    
    // Route::get('/stemp/{stemp}', [StempController::class, 'show'])->middleware('auth')->name('stemp.show');
    Route::resource('/stemp', StempController::class);
    Route::group([ 'prefix' => 'adapter', 'namespace' => 'EmateraiController' ], function () {
        Route::get('login', [EmateraiController::class, 'login']);
        Route::get('serialNumber', [EmateraiController::class, 'getSN']);
    });


    /**
     * GLOBAL
     */
    // Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
    // Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
    Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
    Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
    Route::get('/{page}', [PageController::class, 'index'])->name('page');
    // Jangan ada lagi route dibawah page
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

});




