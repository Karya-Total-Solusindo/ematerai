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
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\BackupController;


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
    Route::group([ 'prefix' => 'manage'], function(){
        Route::resource('/users', App\Http\Controllers\Admin\UserManagementController::class);
        Route::post('/users/setpemungut', [App\Http\Controllers\Admin\UserManagementController::class,'setpemungut'])->name('setpemungut');
        Route::post('/users/check', [App\Http\Controllers\Admin\UserManagementController::class,'checkpemungut'])->name('checkpemungut');
        Route::post('/users/active', [App\Http\Controllers\Admin\UserManagementController::class,'active'])->name('users.active');
        Route::get('/test', [App\Http\Controllers\Admin\UserManagementController::class,'test'])->name('test');
        Route::get('/spesiment', [TestController::class,'spesiment'])->name('spesiment');
    });

    Route::get('/filemanager', [FileManagerController::class,'index'])->middleware('auth')->name('filemanager');
    Route::get('/server/php', [App\Http\Controllers\Admin\ServerController::class,'phpinfo'])->middleware('auth')->name('phpinfo');
    //backup
    Route::get('/backup',[BackupController::class,'index'])->middleware('auth')->name('backup');
    Route::get('/backup/create', [BackupController::class,'create'])->middleware('auth');
    Route::get('/backup/download/{file_name}', [BackupController::class,'download'])->middleware('auth');
    Route::get('/backup/delete/{file_name}', [BackupController::class,'delete'])->middleware('auth');
    /**
    * Configure
    */
    Route::get('/configure', [ConfigureConttroller::class, 'index'])->middleware('auth')->name('configure');
    Route::get('/configure/create', [ConfigureConttroller::class, 'create'])->middleware('auth')->name('configurecreate');
    Route::post('/configure/store', [ConfigureConttroller::class, 'store'])->middleware('auth')->name('configure-store');
    Route::resource('/configure/company', CompanyController::class);
    Route::resource('/configure/directory', DirectoryController::class);
    Route::post('/configure/directory/upload', [DirectoryController::class, 'upload'])->middleware('auth')->name('doc-upload');

    //Document 
    Route::resource('/document', DocumentController::class)->middleware('auth');
    Route::group(['/doicument'], function(){
        Route::get('/document/directory/{company}', [DocumentController::class, 'getDirectory'])->middleware('auth')->name('getDirectory');
        Route::get('/document/create/{directory}', [DocumentController::class, 'create'])->middleware('auth')->name('document.create');
    });
    Route::group([ 'prefix' => 'serialnumber'], function(){
        Route::get('/seriallist', [EmateraiController::class, 'index'])->middleware('auth')->name('seriallist');

        // Route::get('/getOne', [DocumentController::class, 'getSerialNumberBatch'])->middleware('auth')->name('getSerialNumberBatch');
        Route::post('/setInProgres', [DocumentController::class, 'setInProgres'])->middleware('auth')->name('setInProgres');
        Route::post('/exeStamp', [DocumentController::class, 'stampExecute'])->middleware('auth')->name('stampExecute');
        Route::post('/getOne', [DocumentController::class, 'getSerialNumber'])->middleware('auth')->name('getSerialNumber');
        // getSerialNumberBatch tidakdipakai
        // Route::post('/getBatch', [DocumentController::class, 'getSerialNumberBatch'])->middleware('auth')->name('getSerialNumberBatch');
        //reupload file
        Route::post('/updatefile/{document}', [DocumentController::class, 'updatefile'])->middleware('auth')->name('updatefile');
    });

    

    // STEMP 
    Route::get('/stemp/company', [StempController::class, 'company'])->middleware('auth')->name('company');
    Route::get('/stemp/company/{company}', [StempController::class, 'directory'])->middleware('auth')->name('directory');
    Route::get('/stemp/company/directory/{directory}', [StempController::class, 'document'])->middleware('auth')->name('document');

    Route::get('/stemp/company/directory/add/{directory}', [StempController::class, 'addfile'])->middleware('auth')->name('add.file');
    Route::get('/stemp/process/{document}', [StempController::class, 'process'])->middleware('auth')->name('process');
    Route::post('/stemp/stemp', [StempController::class, 'stemp'])->middleware('auth')->name('stemp.stemp');
    
    Route::get('/stemp/progress', [StempController::class, 'progress'])->middleware('auth')->name('progress');
    Route::get('/stemp/failed', [StempController::class, 'failed'])->middleware('auth')->name('failed');
    Route::get('/stemp/success', [StempController::class, 'success'])->middleware('auth')->name('success');
    Route::get('/stemp/history', [StempController::class, 'history'])->middleware('auth')->name('history');
    //qrematerai
    Route::get('/stemp/qrematerai/{qr}', [StempController::class, 'qrematerai'])->middleware('auth')->name('qrematerai');
    
    Route::get('/stemp/_modalProcess', [StempController::class, '_modalProcess'])->middleware('auth')->name('_modalProcess');
    //EXPORT EXCEL
    Route::get('/stemp/exportSuccess', [StempController::class, 'exportSuccecc'])->middleware('auth')->name('exportSuccecc');
    Route::post('/stemp/download', [StempController::class, 'download'])->middleware('auth')->name('stamp.download');
    Route::post('/stemp/trash', [StempController::class, 'trash'])->middleware('auth')->name('stamp.trash');
    Route::post('/stemp/deleteNewFile', [StempController::class, 'deleteNewFile'])->middleware('auth')->name('stamp.deleteNewFile');
    
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
    Route::post('/updatepassword', [UserProfileController::class, 'updatepassword'])->name('profile.password');
    Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
    Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
    Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
    Route::get('/{page}', [PageController::class, 'index'])->name('page');
    // Jangan ada lagi route dibawah page
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

});

Route::get('/stemp/detail/{SN}', [StempController::class, 'stampDetail'])->middleware('auth')->name('stamp.detail');
Route::get('/stemp/qrimage/{SN}', [StempController::class, 'qrImage'])->middleware('auth')->name('stamp.qrimage');







