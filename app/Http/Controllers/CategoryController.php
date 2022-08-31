<?php

namespace App\Http\Controllers;

use App\Helper\Datatable;
use App\Helper\MediaHelper;
use App\Http\Resources\CategoryDetailResource;
use Illuminate\Support\Str;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(){
        $category = new Category();
        $category = Datatable::filter($category,['name']);
        return CategoryResource::collection($category);
    }

    public function store(Request $request){
        $id = $request->has('id')?$request->get('id'):null;
        if($id){
            $this->validate($request,[
                'category_image'=>'sometimes|image|mimes:png,jpg,jpeg,webp,gif|max:8000',
                'category_name'=>'required|max:100|unique:categories,name,'.$id,
                'has_package'=>'required',
                'package_names' => 'exclude_if:has_package,0,false|required',
            ]);
        }else{
            $this->validate($request,[
                'category_image'=>'required|image|mimes:png,jpg,jpeg,webp,gif|max:8000',
                'category_name'=>'required|max:100|unique:categories,name,'.$id,
                'has_package'=>'required',
                'package_names' => 'exclude_if:has_package,0,false|required',
            ]);
        }
        
        //return $request->has_package;
        $has_package = $request->has_package;     
        try{
            DB::beginTransaction();
            if($id){
                $category = Category::findOrFail($id);
                $category_image = $category->image;
                if($request->has('category_image')){
                    MediaHelper::deleteFile($category->image,'category');
                    $category_image = MediaHelper::storeMedia($request->category_image,'category', true);
                }
                $category->update([
                    'name'=>$request->category_name,
                    'image'=>$category_image,
                    'has_package'=>$has_package,
                    'package_names'=> $request->package_names
                ]);
                DB::commit();
                return response()->json([
                    'message'=>'category updated successfully.'
                ]);
                
            }else{
                $category = new Category();
    
                
                $category_image = MediaHelper::storeMedia($request->file('category_image'),'category', true);
                $category->create([
                    'name'=>$request->category_name,
                    'image'=>$category_image,
                    'has_package'=>$has_package,
                    'package_names'=> $request->package_names
                ]);
                DB::commit();
                
                return response()->json([
                    'message'=>'New category created successfully.'
                ]);

            }
            
        }catch(\Exception $e){
            
            DB::rollBack();
            //return $e;
            return response()->json([
              'message'=>$e->getMessage()
            ],500);
        }
        
        
    }

    public function show($id){
        $category = Category::findOrFail($id);
        return new CategoryDetailResource($category);
    }

    public function changeStatus($id){
        $category = Category::findOrFail($id);

            $category->status = !$category->status;
            $category->update();
            return response()->json([
                'message'=>'category status updated succefully.'
            ],200);
    
        return response()->json([
            'message'=>'unauthorized action'
        ],403);
    }

    public function getAllCategory(){
        $category = Category::select('id','name')->get();
        return response()->json($category);
    }

    public function delete($id){
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json([
            'message'=>'category deleted successfully.'
        ]);
    }
}
