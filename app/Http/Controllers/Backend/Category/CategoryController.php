<?php

namespace App\Http\Controllers\Backend\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    //CREATE
    public function create()
    {
        $allCategorys = Category::get();
        return view('backend.category.category', compact('allCategorys'));
    }

    // SELECT2 AJAX SEND
    function processList(Request $request)
    {
        $data = Category::query()->latest();
        $search = $request->search;

        if ($search) {
            $data->whereLike('category_name', "%$search%");
        }

        $res = $data->limit(5)->get();

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
            'category_img' => 'mimes:png,jpg,jpeg,gif,webp'
        ]);



        $storeCategory = new Category();
        $storeCategory->category_name = $request->category_name;
        $storeCategory->category_slug = $request->category_name . '-' . Str::slug($request->category_name) . '-' . uniqid();
        $storeCategory->parent_name = $request->parent_name;

        // Handle the image upload
        if ($request->hasFile('category_img')) {
            $image = $request->file('category_img');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Create a unique name for the image
            $image->move(public_path('images/categories'), $imageName); // Move the image to the public directory
            $storeCategory->category_img = env('APP_URL') . 'images/categories/' . $imageName; // Save the image name in the database
        }


        $storeCategory->save();

        // Return a JSON response with a success message
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully created new category!'
        ]);
    }

    // LIST
    public function list()
    {
        $categories = Category::latest()->get();
        return view('backend.category.listCategory', compact('categories'));
    }


    // CATEGORY STATUS
    public function categoryStatus(Request $request)
    {
        $statusCategory = Category::find($request->id);
        if ($statusCategory->status == 0) {
            $statusCategory->status = 1;
            $statusCategory->save();
        } else {
            $statusCategory->status = 0;
            $statusCategory->save();
        }
        return response()->json(['status' => $statusCategory->status]);
    }


    //DELETE CATEGORY 
    public function categoryDelete(Request $request)
    {
        Category::find($request->id)->delete();
        return response()->json(
            [
                'status' => 'error',
                'message' => 'category deleted!'
            ]
        );
    }


    //EDIT CATEGORY...
    public function editDelete(Request $request){
        $category = Category::find($request->id);
        return response()->json($category);
    }
}
