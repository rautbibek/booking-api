<?php

namespace App\Http\Controllers;
// use App\Models\Permission;
use App\Helper\Datatable;
use App\Http\Resources\PermissionResource;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(){
        $permissions = new Permission();
        $permissions = Datatable::filter($permissions,['name','module']);
        return PermissionResource::collection($permissions);
    }

    public function getAllPermissions(){
        $permissions = Permission::select('id','module','name')
                     ->get()
                     ->groupBy('module');
        return response()->json($permissions);
    }

    public function store(Request $request){
        $this->validate($request,[
            'module'=>'required|max:50',
            'permission'=> 'required|max:50|unique:permissions,name,'.$request->id
        ]);

        $message = "New permission added succefully";
        if(isset($request->id)){
            $this->validate($request,[
                'permission'=> 'required|unique:permissions,name,'.$request->id
            ]);
            $permission = Permission::where('id',$request->id)->firstOrFail();
            $message = "Permission updated succefully";
            
        }else{
            $permission = new Permission();
            // $permission->guard_name = 'api';
        }
        
        $permission->module= $request->module;
        $permission->name = $request->permission;
        
        $permission->save();
        return response()->json(['message'=>$message]);
    }

    public function delete($id){
        $permission = Permission::where('id',$id)->firstOrFail();
        $permission->delete();
        return response()->json([
            'message'=>'Permission Deleted Succefully'
        ]);
    }
}
