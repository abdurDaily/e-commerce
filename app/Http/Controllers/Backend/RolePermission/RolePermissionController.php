<?php

namespace App\Http\Controllers\Backend\RolePermission;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

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
    // Validate the incoming request
    $request->validate([
        'role_name' => 'required|string|max:255|unique:roles,name', // Ensure role_name is unique
    ]);

    // Create a new role
    $roleStore = new Role();
    $roleStore->name = $request->role_name;
    $roleStore->guard_name = 'web';
    $roleStore->save();

    // Return a JSON response
    return response()->json(['success' => true, 'message' => 'Role added successfully!', 'role' => $roleStore]);
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
