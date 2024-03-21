<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\SubCategoryController;
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
    // return view('welcome');
    return view('frontend.index');
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
        Route::post('/category/delete/{id}',[CategoryController::class, 'delete'])->name('category.delete');

        // sub-category
        Route::prefix('sub-category')->group(function () {
            Route::get('/all',[SubCategoryController::class, 'index'])->name('sub-category.all');
            Route::get('/create',[SubCategoryController::class, 'create'])->name('sub-category.create');
            Route::post('/store',[SubCategoryController::class, 'store'])->name('sub-category.store');
            Route::get('/edit/{id}',[SubCategoryController::class, 'edit'])->name('sub-category.edit');
            Route::post('/update/{id}',[SubCategoryController::class, 'update'])->name('sub-category.update');
            Route::post('/delete/{id}',[SubCategoryController::class, 'delete'])->name('sub-category.delete');
        });

        // brands

        Route::prefix('brand')->group(function () {
            Route::get('/all',[BrandController::class, 'index'])->name('brand.all');
            Route::get('/create',[BrandController::class, 'create'])->name('brand.create');
            Route::post('/store',[BrandController::class, 'store'])->name('brand.store');
            Route::get('/edit/{id}',[BrandController::class, 'edit'])->name('brand.edit');
            Route::post('/update/{id}',[BrandController::class, 'update'])->name('brand.update');
            Route::post('/delete/{id}',[BrandController::class, 'delete'])->name('brand.delete');
        });

        // products
        Route::prefix('product')->group(function(){
            Route::get('/all',[ProductController::class, 'index'])->name('product.all');
            Route::get('/create',[ProductController::class, 'create'])->name('product.create');
            Route::post('/store',[ProductController::class, 'store'])->name('product.store');
            Route::get('/edit/{id}',[ProductController::class, 'edit'])->name('product.edit');
            Route::post('/update/{id}',[ProductController::class, 'update'])->name('product.update');
            Route::post('/delete/{id}',[ProductController::class, 'delete'])->name('product.delete');
        });
            

        // extras
        Route::post('/upload-temp-image',[TempImagesController::class, 'create'])->name('temp-image.create');

        Route::post('/product-image/update',[ProductImageController::class, 'update'])->name('product-image.update');

        Route::get('/product-image/delete',[ProductImageController::class, 'deleteImage'])->name('product-image.delete');

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

        Route::get('/product-sub-categories',[ProductSubCategoryController::class, 'fetchSubCategoryByCategoryId'])->name('fetchSubCategoryByCategoryId');
    });
});