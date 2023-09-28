<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Lcloss\SimplePermission\Http\Controllers',
], function() {
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
});
