<?php

use App\Http\Controllers\Backend\RolePermission\RolePermissionController;
use Illuminate\Support\Facades\Route;


Route::prefix('role')->name('role.')->group(function () {
    Route::get('/create', [RolePermissionController::class, 'create'])->name('create');
    Route::get('/get', [RolePermissionController::class, 'getRolesWithPermissions'])->name('get');
    
    Route::post('/store', [RolePermissionController::class, 'storeRole'])->name('store.role');
    Route::get('/delete/{id}', [RolePermissionController::class, 'deleteRole'])->name('delete.role');

});

