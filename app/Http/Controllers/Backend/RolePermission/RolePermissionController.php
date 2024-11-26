<?php

namespace App\Http\Controllers\Backend\RolePermission;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RolePermissionController extends Controller
{
    public function index(){
        $roles = Role::with('permissions')->latest()->get();
    }
}
