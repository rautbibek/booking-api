<?php

namespace App\Http\Controllers;

use App\Helper\Datatable;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $category = new Category();
        $category = Datatable::filter($category,['name']);
        return CategoryResource::collection($category);
    }

    public function getAllCategory(){
        $category = Category::select('id','name')->get();
        return response()->json($category);
    }
}
