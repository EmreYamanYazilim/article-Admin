<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\ArticleFilterRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(ArticleFilterRequest $request)
    {
        $categories = Category::all();
        $users = User::all();
        $list = Article::query()->with("category","user")
            ->where(function ($query) use ($request) {
                $query->orWhere("title", "LIKE", "%" . $request->title . "%")
                    ->orWhere("slug", "LIKE", "%" . $request->slug . "%")
                    ->orWhere("body", "LIKE", "%" . $request->body . "%")
                    ->orWhere("tags", "LIKE", "%" . $request->tags . "%");
            })
            ->status($request->status)
            ->category($request->category_id)
            ->user($request->user_id)
            ->publishDate($request->publish_date)


            ->paginate(1);

        return view("admin.articles.list" ,compact("categories","users","list"));
    }

    public function create()
    {
        $categories = Category::all();
        return view("admin.articles.create-update", compact("categories"));

    }

    public function store(ArticleCreateRequest $request)
    {
        $imageFile = $request->file("image");
        $originalName = $imageFile->getClientOriginalName();
        $originalExtension = $imageFile->getClientOriginalExtension();
        $explodeName = explode(".", $originalName)[0];
        $fileName = Str::slug($explodeName).time().".".$originalExtension;

        if (file_exists(public_path("storage/articles/" . $fileName))) {
            return redirect()->back()->withErrors(["image" => "ayni görsel daha önce yüklendi"]);
        }

        $data = $request->except("_token");
        $slug = $data["slug"] ?? $data["title"];
        $slug = Str::slug($slug);
        $slugTitle = Str::slug($data["title"]);
        $checkSlug = $this->slugCheck($slug);
        if (!is_null($checkSlug)) {
            $checkTitleSlug = $this->slugCheck($slugTitle);
            if (!is_null($checkTitleSlug)) {
                $slug = Str::slug($slug . time());
            }else{
                $slug = $slugTitle;
            }
        }
        $data["slug"] = $slug;
        $data["image"] = "storage/articles/".$fileName;
        $data["user_id"] = auth()->id();
        Article::create($data);
        $imageFile->storeAs("articles", $fileName,"public");


        alert()->success("başarı ile kaydedildi")->showConfirmButton("tamam")->autoClose(5000);
        return redirect()->back();
    }

    public function edit(Request $request, int $articleID)
    {
        $categories = Category::all();
        $users = User::all();
        $article = Article::query()
            ->where("id",$articleID)
            ->firstOrFail();
        return view("admin.articles.create-update", compact("article","users", "categories"));

    }

    public function update(ArticleUpdateRequest $request)
    {
// resim yüklemede kodumuzu daha temiz hele getirdik
        if (!is_null($request->image)) {
            $imageFile = $request->file("image");
            $originalName = $imageFile->getClientOriginalName();
            $originalExtension = $imageFile->getClientOriginalExtension();
            $explodeName = explode(".", $originalName)[0];
            $fileName = Str::slug($explodeName).time().".".$originalExtension;
        }
        $data = $request->except("_token");
        $slug = $data["slug"] ?? $data["title"];
        $slug = Str::slug($slug);
        $data["slug"] = $slug;
        if (!is_null($request->image)) {
            $data["image"] = "storage/articles/" . $fileName;
            $imageFile->move("storage/articles",$fileName);
            $data["user_id"] = auth()->id();
            $articleQuery = Article::query()
                ->where("id", $request->id);
            $articleFind = $articleQuery->first();
            $articleQuery->update($data);
            if (file_exists($articleFind->image)) {
                if (!empty($articleFind->image)) {
                    unlink($articleFind->image);
                }
                alert()->success("Başarı ile güncellendiz")->showConfirmButton("tamam")->autoClose(5000);
                return redirect()->back();
            }
        }else{
            $data["user_id"] = auth()->id();
             Article::query()
                ->where("id", $request->id)
                 ->update($data);
        }
        alert()->success("Başarı ile güncellendiz")->showConfirmButton("tamam")->autoClose(5000);
        return redirect()->back();
    }


    public function slugCheck(string $text)
    {
        return Article::where("slug", $text)->first();
    }
}
