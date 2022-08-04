<?php

namespace App\Http\Controllers;

use App\Helper\Datatable;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        $role = new Role;
        $role = Datatable::filter($role,['name']);
        return RoleResource::collection($role);
    }

    public function permissions(){
        $permissions = new Permission;
        $permissions = Datatable::filter($permissions,['name']);
        return PermissionResource::collection($permissions);
    }

    public function getAllPermissions(){
        $permissions = Permission::all();
        return response()->json($permissions);
    }
}
