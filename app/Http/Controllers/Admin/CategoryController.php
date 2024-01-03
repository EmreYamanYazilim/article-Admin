<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with("parentCategory:id,name")->get();

        foreach ($categories as $category) {
            if ($category->parentCategory) {
                dd($category);
            }
        }

        return view("admin.categories.list");
    }

    public function create()
    {
        return view("admin.categories.create-update");
    }




}
