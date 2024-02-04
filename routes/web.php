<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\TempImagesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome');
});

// admin
Route::group(['prefix'=>'admin'],function(){
    // Route::group(['middleware'=>'admin.guest'],function(){
        Route::get('/login',[AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');
    // });

    // Route::group(['middleware'=>'admin.auth'],function(){
    Route::group(['middleware'=>'customAuthAdminMiddleware'],function(){
        Route::get('/dashboard',[HomeController::class,'index'])->name('admin.dashboard');
        Route::get('/logout',[HomeController::class,'logout'])->name('admin.logout');

        // category
        Route::get('/category',[CategoryController::class,'index'])->name('category.all');
        Route::get('/category/create',[CategoryController::class,'create'])->name('category.create');
        Route::post('/category/store',[CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/edit/{id}',[CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/category/update/{id}',[CategoryController::class, 'update'])->name('category.update');

        Route::post('/upload-temp-image',[TempImagesController::class, 'create'])->name('temp-image.create');

        Route::get('/getSlug',function(Request $request){
            $slug = '';
            if(!empty($request->title)){
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status'=>true,
                'slug' => $slug
            ]);
        })->name('getSlug');
    });
});