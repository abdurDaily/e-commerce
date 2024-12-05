<?php

namespace App\Http\Controllers\Backend\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //CREATE
    public function create(){
        $allCategorys = Category::get();
        return view('backend.category.category', compact('allCategorys'));
    }

    //STORE CATEGORY
    public function store(Request $request){
        $storeCategory = new Category();
        $storeCategory->category_name = $request->category_name;
        $storeCategory->category_slug = Str::slug($request->category_name);
        $storeCategory->parent_name = $request->parent_name;
        $storeCategory->save();
    }
}
