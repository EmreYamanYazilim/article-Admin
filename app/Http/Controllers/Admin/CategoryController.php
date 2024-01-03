<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view("admin.categories.list");
    }

    public function create()
    {
        return view("admin.categories.create-update");
    }




}
