<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\usercontroller;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('Admin', function () {
    return view('Admin.Login');
})->name('Admin');

Route::post('login', [adminController::class, 'login'])->name('login');


Route::middleware('admin.auth')->group(function () {


    Route::get('Admindashboard', function () {
        return view('Admin.Admindashboard');

    })->name('Admindashboard');
    Route::get('propertydetails', function () {
        return view('Admin.propertydetails');
    })->name('propertydetails');


    Route::get('Sells', function () {
        return view('Admin.Sells');
    })->name('Sells');
    Route::get('Rents', function () {
        return view('Admin.Rents');
    })->name('Rents');
    Route::get('counter', function () {
        return view('Admin.counter');
    })->name('counter');
    Route::get('reports', function () {
        return view('Admin.Reports');
    })->name('reports');
    Route::get('complaints', function () {
        return view('Admin.Complaints');
    })->name('complaints');
    Route::get('delete_property/{id}', [adminController::class, 'delete_property'])->name('delete_property');
    Route::get('getproperty', [adminController::class, 'property'])->name('getproperty');
    Route::get('getproperty/{id}', [adminController::class, 'getproperty'])->name('getpropertybyId');

    Route::get('sells_counter', [adminController::class, 'sells_counter'])->name('sells_counter');
    Route::get('rents_counter', [adminController::class, 'rents_counter'])->name('rents_counter');
    Route::get('sells', [adminController::class, 'sells'])->name('sells');
    Route::get('rents', [adminController::class, 'rents'])->name('rents');
    Route::get('getuser/{id}', [adminController::class, 'getuser'])->name('getuser');
    Route::get('getreports', [adminController::class, 'getreports'])->name('getreports');
    Route::get('getcomplaints', [adminController::class, 'getcomplaints'])->name('getcomplaints');
    Route::post('/logout', [adminController::class,'logout'])->name('logout');
    Route::post('addadmin',[adminController::class,'addadmin'])->name('addadmin');
    Route::get('add-admin',function (){
        return view('Admin.add-admin');
    })->name('add-admin');
    Route::post('suspend/{id}',[adminController::class,'suspend']);
    Route::post('unsuspend/{id}',[adminController::class,'unsuspend']);

});




//----------------------------------------------------------------------------------



Route::get('Bank', function () {
    return view('Bank.Login');
})->name('Bank');
Route::post('loginb', [BankController::class, 'loginb'])->name('loginb');



Route::middleware('user.auth')->group(function () { 

    Route::post('create-account', [BankController::class, 'createAccount'])->name('create-account');
    Route::post('/add-money', [BankController::class, 'addMoney'])->name('add-money');
    Route::get('/Bankdashboard', [BankController::class, 'banks'])->name('Bankdashboard');
    Route::get('create', function () {
        return view('Bank.create-account');
    })->name('create');
    Route::get('add', function () {
        return view('Bank.add-money');
    })->name('add');
    Route::get('/logoutb', [BankController::class, 'logoutb'])->name('logoutb');

    Route::view('/logout/success', 'Admin.logout-success')->name('logout.success');
    Route::post('addbank',[BankController::class,'addbank'])->name('addbank');
    Route::get('add-bank',function (){return view('Bank.add-bank');})->name('add-bank');
    Route::get('/show-balance', [BankController::class, 'showBalance'])->name('show-balance');

});


