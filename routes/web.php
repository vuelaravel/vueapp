<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChangePass;
use App\Http\Controllers\BrandController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
Route::get('email/verify',function(){
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');
Route::get('/', function () {
    return view('home');
});
Route::get('/home', function () {
    echo "This is home page";
});
Route::get('/about',function(){
    return view('about');
});

Route::get('/contact',[ContactController::class,'index'])->name('con');
Route::get('/user/logout',[BrandController::class,'Logout'])->name('user.logout');
Route::get('/category/all',[CategoryController::class,'Allcat'])->name('all.category');
Route::get('/category/edit/{id}',[CategoryController::class,'Edit']);
Route::get('/category/softdelete/{id}',[CategoryController::class,'softDelete']);
Route::get('/category/restore/{id}',[CategoryController::class,'Restore']);
Route::get('/category/forceDelete/{id}',[CategoryController::class,'ForceDelete']);
Route::post('/category/update/{id}',[CategoryController::class,'Update']);
Route::post('/category/add',[CategoryController::class,'Addcat'])->name('store.category');

Route::get('/brand/all',[BrandController::class,'Allbrand'])->name('all.brand');
Route::post('/brand/add',[BrandController::class,'StoreBrand'])->name('store.brand');
Route::get('/brand/softdelete/{id}',[BrandController::class,'softDelete']);
Route::get('/brand/edit/{id}',[BrandController::class,'edit']);
Route::post('/brand/update/{id}',[BrandController::class,'Update']);
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        //$users = DB::table('users')->get();
        return view('admin.index');
    })->name('dashboard');
});

///Change Password and user profile
Route::get('/user/password',[ChangePass::class,'ChangePassword'])->name('change.password');
Route::post('/password/update',[ChangePass::class,'UpdatePassword'])->name('update.password');

//update user profile

Route::get('/user/profile',[ChangePass::class,'editProfile'])->name('profile.update');
Route::post('/user/update',[ChangePass::class,'UpdateProfile'])->name('update.user');