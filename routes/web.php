<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsR;
use App\Http\Controllers\TransactionsR;
use App\Http\Controllers\UsersR;
use App\Http\Controllers\LoginC;
use App\Http\Controllers\LogC;
use App\Http\Controllers\dashboardC;


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
    $subtittle = "Home Page";
    return view('dashboard', compact('subtittle'));
})->middleware('auth');

#Dashboard 
Route::get('dashboard', [dashboardC::class, 'index'])->name('dashboard.index')->middleware('auth');

#pdf
Route::get('products/pdf', [ProductsR::class, 'pdf'])->middleware('userAkses:kasir,admin,owner');  
Route::get('users/pdf', [UsersR::class, 'pdf'])->middleware('userAkses:admin');
Route::get('transactions/pdf', [TransactionsR::class, 'pdf'])->middleware('userAkses:owner,admin,kasir');
Route::get('transactions/pdf2/{id}', [TransactionsR::class, 'pdf2'])->middleware('userAkses:kasir');
Route::get('pertanggal', [TransactionsR::class, 'pertanggal'])->name('transactions.pertanggal')->middleware('userAkses:owner');
Route::get('transactions/tgl', [TransactionsR::class, 'tgl'])->name('transactions.tgl')->middleware('userAkses:owner');

#Products
Route::resource('products', ProductsR::class)->middleware('userAkses:kasir,admin,owner');

#Transactions
Route::resource('transactions', TransactionsR::class)->middleware('auth');
Route::get('transactions/create', [TransactionsR::class, 'create'])->name('transactions.create')->middleware('userAkses:kasir');
Route::post('transactions/store', [TransactionsR::class, 'store'])->name('transactions.store')->middleware('userAkses:kasir');
Route::get('transactions/edit/{id}', [TransactionsR::class, 'edit'])->name('transactions.edit')->middleware('userAkses:admin');
Route::put('transactions/update/{id}', [TransactionsR::class, 'update'])->name('transactions.update')->middleware('userAkses:admin');
Route::delete('transactions/destroy/{id}', [TransactionsR::class, 'destroy'])->name('transactions.destroy')->middleware('userAkses:admin');



#User
Route::resource('users', UsersR::class)->middleware('userAkses:admin');
Route::get('users/create', [UsersR::class, 'create'])->name('users.create')->middleware('userAkses:admin');
Route::get('users/changepassword/{id}', [UsersR::class, 'changepassword'])->name('users.changepassword')->middleware('userAkses:admin');
Route::put('users/change/{id}', [UsersR::class, 'change'])->name('users.change')->middleware('userAkses:admin');

#Login
Route::get('login', [LoginC::class, 'login'])->name('login')->middleware('guest');
Route::post('login', [LoginC::class, 'login_action'])->name('login.action')->middleware('guest');

// #logout
Route::get('logout', [LoginC::class, 'logout'])->name('logout')->middleware('auth');

#Log
Route::get('log', [LogC::class, 'index'])->name('log.index')->middleware('userAkses:owner');

#Statuspengambilan
Route::put('/transactions/{id}/updatestatus', [TransactionsR::class, 'updatestatus'])->name('transactions.updatestatus')->middleware('userAkses:kasir');




