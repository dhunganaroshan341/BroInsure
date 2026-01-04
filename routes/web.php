<?php

use App\Http\Controllers\Admin\DashobardController;
use App\Http\Controllers\Admin\PremiumController;
use App\Http\Controllers\LoginController;
use App\Models\PremiumCalculation;
use Illuminate\Support\Facades\Route;

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

Route::resource('login', LoginController::class);
Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
// Route::get('premimum-calculation', function () {
//     return view('premium');
// })->name('premimumCal');

Route::get('premimum-calculation',[PremiumController::class,'index']);
Route::get('get-group-data/{id?}',[PremiumController::class,'getGroup']);
Route::get('get-insured-amount-data/{id?}',[PremiumController::class,'getInsuredAmount']);
