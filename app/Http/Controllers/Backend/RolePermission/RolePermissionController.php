<?php

namespace App\Http\Controllers\Backend\RolePermission;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RolePermissionController extends Controller
{
    public function create()
    {
        return view('backend.rolePermissions.createRole');
    }


    public function getRolesWithPermissions()
    {
        // Fetch all roles with their permissions
        $roles = Role::with('permissions')->get(); // Eager load permissions for each role

        return DataTables::of($roles)->editColumn('permissions', function ($role) {
            return $role->permissions->pluck('name')->implode(', '); // Join permission names as a string
        })->make(true);
    }


    //**STORE A NEW ROLE */
    public function storeRole(Request $request)
    {

        $roleStore = new Role();
        $roleStore->name = $request->role_name;
        $roleStore->guard_name = 'web';
        $roleStore->save();
        return back();
    }



    //**DELETE ROLE */
    public function deleteRole($id)
    {
        Role::where('id', $id)->delete();
        return response()->json(
            [
                'success' => true, 
                'message' => 'Role deleted successfully.'
            ]);
    }
}
