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
    public function create()
    {
        $allCategorys = Category::get();
        return view('backend.category.category', compact('allCategorys'));
    }

    function processList(Request $request)
    {
        $data = Category::query()->latest();
        $search = $request->search;

        if ($search) {
            $data->whereLike('category_name', "%$search%");
        }

        $res = $data->limit(3)->get();

        $categories = [];

        foreach ($res as $cat) {
            $categories[] =  [
                'id' => $cat->id,
                'text' => $cat->category_name,
            ];
        }
        // dd(json_encode($categories));
        return response()->json($categories);
    }

    //STORE CATEGORY
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name',
        ]);

            


        $storeCategory = new Category();
        $storeCategory->category_name = $request->category_name;
        $storeCategory->category_slug = $request->category_name . '-' . Str::slug($request->category_name) . '-' . uniqid();
        $storeCategory->parent_name = $request->parent_name;
        $storeCategory->save();
        return response()->json(['message' => 'successfully new data created', 'status' => 'created!']);
    }

    // LIST
    public function list()
    {
        $categories = Category::get();
        return view('backend.category.listCategory', compact('categories'));
    }
}
