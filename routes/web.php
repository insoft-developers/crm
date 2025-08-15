<?php

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;




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

require __DIR__ . '/auth.php';

Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
  ->middleware('guest')
  ->name('password.reset');



Route::get('/email/verify', function () {
  return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
  $request->fulfill();

  return redirect('/home'); // ganti dengan route tujuanmu
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
  $request->user()->sendEmailVerificationNotification();

  return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



Route::group(['middleware' => ['auth', 'verified', 'is_active']], function () {


  Route::get('/', [DashboardController::class, 'index']);

  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('/home', [DashboardController::class, 'index']);

  Route::resource('branch', BranchController::class);
  Route::get('branch_table', [BranchController::class, 'branchTable'])->name('branch.table');


  Route::resource('customer', CustomerController::class);
  Route::get('customer_table', [CustomerController::class, 'customerTable'])->name('customer.table');
  Route::post('kota_get', [CustomerController::class, 'kotaGet'])->name('kota.get');
  Route::post('kecamtan_get', [CustomerController::class, 'kecamatanGet'])->name('kecamatan.get');


  Route::resource('supplier', SupplierController::class);
  Route::get('supplier_table', [SupplierController::class, 'supplierTable'])->name('supplier.table');

  Route::resource('karyawan', KaryawanController::class);
  Route::get('karyawan_table', [KaryawanController::class, 'karyawanTable'])->name('karyawan.table');
  Route::post('form-add-cabang', [KaryawanController::class, 'formAddKaryawan']);
  Route::post('form-add-jabatan', [KaryawanController::class, 'formAddJabatan']);
  Route::post('form-add-department', [KaryawanController::class, 'formAddDepartment']);



  

});


//App Details Pages Routs
Route::group(['prefix' => 'app'], function () {

  //Userdetail Page Routs
  Route::get('user/profile', [HomeController::class, 'userprofile'])->name('userdetail.userprofile');
  Route::get('user/add', [HomeController::class, 'useradd'])->name('userdetail.useradd');
  Route::get('user/userlist', [HomeController::class, 'userList'])->name('userdetail.userlist');
  Route::get('user/user-profile-edit', [HomeController::class, 'userProfileEdit'])->name('userdetail.userprofileedit');
});

//Policy Page Routs
Route::group(['prefix' => ''], function () {
  Route::get('privacy-policy', [HomeController::class, 'PrivacyPolicy'])->name('userdetail.privacyPolicy');
  Route::get('terms-of-service', [HomeController::class, 'TermsOfUse'])->name('userdetail.termsofuse');
});

//UI Pages Routs
Route::group(['prefix' => 'ui'], function () {
  Route::get('avatars', [HomeController::class, 'UiAvatars'])->name('ui.avatars');
  Route::get('alerts', [HomeController::class, 'UiAlerts'])->name('ui.alerts');
  Route::get('badges', [HomeController::class, 'UiBadges'])->name('ui.badges');
  Route::get('breadcrumb', [HomeController::class, 'UiBreadcrumb'])->name('ui.breadcrumb');
  Route::get('buttons', [HomeController::class, 'UiButtons'])->name('ui.buttons');
  Route::get('buttongroup', [HomeController::class, 'UiButtongroup'])->name('ui.buttongroup');
  Route::get('boxshadows', [HomeController::class, 'UiBoxshadows'])->name('ui.boxshadows');
  Route::get('colors', [HomeController::class, 'UiColors'])->name('ui.colors');
  Route::get('cards', [HomeController::class, 'UiCards'])->name('ui.cards');
  Route::get('carousel', [HomeController::class, 'UiCarousel'])->name('ui.carousel');
  Route::get('grid', [HomeController::class, 'UiGrid'])->name('ui.grid');
  Route::get('helperclass', [HomeController::class, 'UiHelperClass'])->name('ui.helperclass');
  Route::get('images', [HomeController::class, 'UiImages'])->name('ui.images');
  Route::get('listgroup', [HomeController::class, 'UiListgroup'])->name('ui.listgroup');
  Route::get('media', [HomeController::class, 'UiMedia'])->name('ui.media');
  Route::get('modal', [HomeController::class, 'UiModal'])->name('ui.modal');
  Route::get('notification', [HomeController::class, 'UiNotification'])->name('ui.notification');
  Route::get('pagination', [HomeController::class, 'UiPagination'])->name('ui.pagination');
  Route::get('popovers', [HomeController::class, 'UiPopovers'])->name('ui.popovers');
  Route::get('progressbars', [HomeController::class, 'UiProgressbars'])->name('ui.progressbars');
  Route::get('typography', [HomeController::class, 'UiTypography'])->name('ui.typography');
  Route::get('tabs', [HomeController::class, 'UiTabs'])->name('ui.tabs');
  Route::get('tooltips', [HomeController::class, 'UiTooltips'])->name('ui.tooltips');
  Route::get('video', [HomeController::class, 'UiVideo'])->name('ui.video');
});

//Forms Pages Routs
Route::group(['prefix' => 'forms'], function () {
  Route::get('layout', [HomeController::class, 'FormsLayout'])->name('forms.layout');
  Route::get('inputgroup', [HomeController::class, 'FormsInputgroup'])->name('forms.inputgroup');
  Route::get('validation', [HomeController::class, 'FormsValidation'])->name('forms.validation');
  Route::get('switch', [HomeController::class, 'FormsSwitch'])->name('forms.switch');
  Route::get('checkbox', [HomeController::class, 'FormsCheckbox'])->name('forms.checkbox');
  Route::get('radio', [HomeController::class, 'FormsRadio'])->name('forms.radio');
  Route::get('textarea', [HomeController::class, 'FormsTextarea'])->name('forms.textarea');
});

//Auth pages Routs
Route::group(['prefix' => 'auth'], function () {
  Route::get('login', [HomeController::class, 'authLogin'])->name('auth.login');
  Route::get('register', [HomeController::class, 'authRegister'])->name('auth.register');
  Route::get('recover-password', [HomeController::class, 'authRecoverPassword'])->name('auth.recover-password');
  Route::get('confirm-email', [HomeController::class, 'authConfirmEmail'])->name('auth.confirm-email');
  Route::get('lock-screen', [HomeController::class, 'authlockScreen'])->name('auth.lock-screen');
});
//Table Page Routs
Route::group(['prefix' => 'table'], function () {
  Route::get('basics', [HomeController::class, 'tableBasics'])->name('table.tablebasics');
  Route::get('data', [HomeController::class, 'tableData'])->name('table.tabledata');
  Route::get('tree', [HomeController::class, 'tableTree'])->name('table.tabletree');
});

//Pricing Page Routs
Route::group(['prefix' => 'pricing'], function () {
  Route::get('pricing1', [HomeController::class, 'Pricing1'])->name('pricing.pricing1');
  Route::get('pricing2', [HomeController::class, 'Pricing2'])->name('pricing.pricing2');
});

//Error Page Route
Route::group(['prefix' => 'error'], function () {
  Route::get('error404', [HomeController::class, 'Error404'])->name('pageError.error404');
  Route::get('error500', [HomeController::class, 'Error500'])->name('pageError.error500');
});

//Extra Page Routs
Route::group(['prefix' => 'pages'], function () {
  Route::get('timeline', [HomeController::class, 'TimeLine'])->name('timeline');
  Route::get('blankpage', [HomeController::class, 'BlankPages'])->name('blankpage');
  Route::get('maintenance', [HomeController::class, 'Maintenance'])->name('maintenance');
});
