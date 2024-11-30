<?php

namespace App\Http\Controllers\Backend\Product;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(){
      return view('test');
    }


    public function getUsers()
    {
        $users = User::query();
        return DataTables::of($users)->make(true);
    }
}
