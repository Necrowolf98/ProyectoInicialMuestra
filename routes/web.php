<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DigimonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;

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
    return redirect()->route('login');
})->name('/');

Route::middleware('verified')->group(function(){
    Route::get('home', [HomeController::class, 'index'])->middleware(['permission:dashboard.index'])->name('home');

    Route::get('profile', [ProfileController::class, 'index'])->middleware(['permission:profile.index'])->name('profile.index');
    Route::put('profile/{user}', [ProfileController::class, 'update'])->middleware(['permission:profile.edit'])->name('profile.update');
    
    Route::get('users', [UserController::class, 'index'])->middleware(['permission:users.index'])->name('users.index');
    Route::post('users', [UserController::class, 'store'])->middleware(['permission:users.create'])->name('users.store');
    Route::get('users/{user}', [UserController::class, 'show'])->middleware(['permission:users.show'])->name('users.show');
    Route::put('users/{user}', [UserController::class, 'update'])->middleware(['permission:users.edit'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->middleware(['permission:users.delete'])->name('users.destroy');
    Route::get('users/permissions/{user}', [UserController::class, 'user_permissions'])->middleware(['permission:users.permissions'])->name('users.permissions');
    Route::get('users/permissions/{user}', [UserController::class, 'user_permissions'])->middleware(['permission:users.permissions'])->name('users.permissions');
    Route::put('users/permissions/{user}', [UserController::class, 'update_permissions'])->middleware(['permission:users.permissions'])->name('users.update_permissions');
    
    
    Route::get('roles', [RoleController::class, 'index'])->middleware(['permission:roles.index'])->name('roles.index');
    Route::get('roles/create', [RoleController::class, 'create'])->middleware(['permission:roles.create'])->name('roles.create');
    Route::post('roles', [RoleController::class, 'store'])->middleware(['permission:roles.create'])->name('roles.store');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->middleware(['permission:roles.edit'])->name('roles.edit');
    Route::put('roles/{role}', [RoleController::class, 'update'])->middleware(['permission:roles.edit'])->name('roles.update');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->middleware(['permission:roles.delete'])->name('roles.destroy');
    
    Route::get('permissions', [PermissionController::class, 'index'])->middleware(['permission:permissions.index'])->name('permissions.index');
    Route::post('permissions', [PermissionController::class, 'store'])->middleware(['permission:permissions.create'])->name('permissions.store');
    Route::put('permissions/{permission}', [PermissionController::class, 'update'])->middleware(['permission:permissions.edit'])->name('permissions.update');
    Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->middleware(['permission:permissions.delete'])->name('permissions.destroy');

    Route::get('digimon', [DigimonController::class, 'index'])->name('digimon.index');
});
require __DIR__.'/auth.php';