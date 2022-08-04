<?php

namespace App\Http\Controllers;

use App\Helper\Datatable;

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

    public function roles(){
        $role = Role::select('id','name')->get();
        return response()->json($role);
    }
    
    public function view($id){
        $role = Role::findOrFail($id);
        $permissions = $role->permissions->pluck('name');
        return response()->json([
            'role'=>$role,
            'permissions'=>$permissions
        ]);
    }

    public function store(Request $request){
        //return $request->all();
        $id = $request->has('id')?$request->get('id'):null;
        $this->validate($request,[
            'role'=>'required|max:50|unique:roles,name,'.$id
        ]);
        $message = "New role created succefully.";
        if($id != null){
            $role = Role::where('id',$id)->first();
            $role->name = $request->role;
            $role->update();
            $role->syncPermissions($request->permissions);
            $message = "Role Updated succefully";
        }else{
            $role = new Role();
            $role->name = $request->role;
            $role->save();
            $role->syncPermissions($request->permissions);
        }
        return response()->json([
            'message'=>$message
        ]);
    }

    public function delete($id){
        $role = Role::where('id',$id)->firstOrFail();
        $role->delete();
        return response()->json([
            'messsage'=>'Role Deleted successfully.'
        ]);
    }
}
