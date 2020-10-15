<?php

use App\Http\Controllers\apiresource;
use App\Http\Controllers\Categories;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */
/* Route::get('categories' , 'Categories@categories'); */

/* Route::get("/test", [TestController::class , 'all']);

Route::get("test/{id}" , [TestController::class , 'GetOne']);

Route::post("test" , [TestController::class , 'CreateTest']);

Route::put("test/{id}" ,  [TestController::class , 'updateTest']);

Route::delete("test/{id}" ,  [TestController::class , 'deleteTest']); */



//Route::get('cate', [Categories::class  , 'categories']);
 
/* Route::group(['middleware' => 'auth:api'] , function(){
    Route::apiResource('test' , apiresource::class);
    
}); */

Route::post('login' , [PassportController::class , 'login'] );

 
/* Route::middleware('auth:api')->group(function(){
    Route::get('user' ,[PassportController::class , 'details']);
    Route::apiResource('products' , ProductsController::class);
}); */


 
Route::group(['prefix' => 'admin' , 'middleware' => [ 'jwt.verify' ,'admin.verify']] , function(){
    // USERS
     Route::get('users' , [PassportController::class , 'Users']);
     Route::delete('users/{id}' , [PassportController::class , 'DeleteUser']);
     Route::put('users/{id}' , [PassportController::class , 'UpdateUser']);
    Route::post('register' , [PassportController::class , 'register'] );
    Route::apiResource('products' , ProductsController::class );

     // PRODUCTS
});

Route::group(['prefix' => 'reception', 'middleware' => ['jwt.verify', 'reception.verify']], function(){
     Route::get('products' , [ProductsController::class, 'index'] );

});

Route::group(['prefix' => 'warehouse', 'middleware' => ['jwt.verify', 'warehouse.verify']], function(){
    Route::get('products' , [ProductsController::class, 'index'] );
    Route::post('products' , [ProductsController::class , 'store']);

});
