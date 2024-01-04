<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with("parentCategory:id,name")->orderBy("order","desc")->get();

        return view("admin.categories.list",['list'=>$categories]);
    }

    public function create()
    {
        return view("admin.categories.create-update");
    }

    public function chanceStatus(Request $request)
    {
//        dd($request->all());

        $request->validate(['id'=>'required', 'integer']);  // id geleceği alanı zorunlu olarak belirttik ve bunun intager geliceğini belirttik
        $categoryID = $request->id; // id'sini yakalamak için değşkene verdik

        $category = Category::where('id', $categoryID)->first();   // değişken içinde model where yaparak id'si gelen categoryID olanı databasede varmı yokmu bak bul  getir
        $category->status = !$category->status; // 1 se 0  yap  0 sa 1 yap analamına geliyor
        $category->save();

        alert()->success("Değiştirme işlemi başarılı");
        return redirect()->route("category.index");


    }

    public function chanceFeatureStatus(Request $request)
    {

        $request->validate(['id'=>'required', 'integer']);
        $categoryID = $request->id;
        $category = Category::where('id', $categoryID)->first();
        $category->feature_status = !$category->feature_status;
        $category->save();

        alert()->success('Değiştirme işlemi başarılı !');
        return redirect()->route('category.index');


    }




}
