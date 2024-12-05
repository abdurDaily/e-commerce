<?php

namespace App\Http\Controllers\Backend\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\Return_;

class CategoryController extends Controller
{
    //CREATE
    public function create(){
        $allCategorys = Category::get();
        return view('backend.category.category', compact('allCategorys'));
    }

    //STORE CATEGORY
    public function store(Request $request){
        
        $request->validate([
            'category_name' => 'required|unique:categories,category_name',
        ]);
        
        $storeCategory = new Category();
        $storeCategory->category_name = $request->category_name;
        $storeCategory->category_slug = $request->category_name .'-'. Str::slug($request->category_name).'-'. uniqid();
        $storeCategory->parent_name = $request->parent_name;
        $storeCategory->save();
        return response()->json(['message' => 'successfully new data created', 'status' => 'created!']);
    }
}
