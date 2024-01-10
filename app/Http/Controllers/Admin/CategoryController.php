<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $parentCategories = Category::all();
        $users = User::all();

        $parentID = $request->parent_id;
        $userID = $request->user_id;

        $categories = Category::with("parentCategory:id,name")
            //scope'siz yöntem -> parent_id'lerimiz içinde  üst kategori olarak  null olduğu için bu bölümü  scopesiz  yapmak daha makul
            ->where(function ($query) use ($parentID, $userID) {
                if (!is_null($parentID)) {
                    $query->where("parent_id", $parentID);
                }
                if (!is_null($userID)) {
                    $query->where("user_id", $userID);
                }
            })
            // scope'li yöntemler altta model içine bağlandı
            ->name($request->name)
            ->slug($request->slug)
            ->description($request->description)
            ->order($request->order)
            ->status($request->status)
            ->featureStatus($request->feature_status)
            ->orderBy("order", "desc")
            ->paginate(10);

        return view("admin.categories.list", [
            'list' => $categories,
            'users' => $users,
            'parentCategories' => $parentCategories]);
    }

    public function create()
    {
        $categories = Category::all();
        return view("admin.categories.create-update", compact("categories"));
    }

    public function store(CategoryStoreRequest $request)
    {
        $slug = Str::slug($request->slug);

        try {
            $category = new Category();
            $category->name = $request->name;
            $category->slug = is_null($this->slugCheck($slug)) ? $slug : Str::slug($slug . time()); // slugCheck ile slug varmı yok mu baktı varsa aynısını getir yoksa time ile ekleyerek yeni slug yap
            $category->description = $request->description;
            $category->parent_id = $request->parent_id;
            $category->status = $request->status ? 1 : 0;
            $category->feature_status = $request->feature_status ? 1 : 0;
            $category->seo_keywords = $request->seo_keywords;
            $category->seo_description = $request->seo_description;
            $category->user_id = random_int(1, 10);
            $category->order = $request->order;

            $category->save();

        } catch (\Exception $exception) {
            abort(404, $exception->getMessage());
        }

        alert()->success("işlem başarı ile gerçekleşti ")->showConfirmButton("tamam")->autoClose(5000);
        return redirect()->back();
    }

//    slug kontrol et diye bir function oluşutrudm
    public function slugCheck(string $text)
    {
        return Category::where("slug", $text)->first();
    }

    public function chanceStatus(Request $request)
    {
//        dd($request->all());

        $request->validate(['id' => 'required', 'integer']);  // id geleceği alanı zorunlu olarak belirttik ve bunun intager geliceğini belirttik
        $categoryID = $request->id; // id'sini yakalamak için değşkene verdik

        $category = Category::where('id', $categoryID)->first();   // değişken içinde model where yaparak id'si gelen categoryID olanı databasede varmı yokmu bak bul  getir
        $category->status = !$category->status; // 1 se 0  yap  0 sa 1 yap analamına geliyor
        $category->save();

        alert()->success("Değiştirme işlemi başarılı")->autoClose(5000);
        return redirect()->route("category.index");


    }

    public function chanceFeatureStatus(Request $request)
    {
        $request->validate(['id' => 'required', 'integer']);

        $categoryID = $request->id;
        $category = Category::where('id', $categoryID)->first();
        $category->feature_status = !$category->feature_status;
        $category->save();

        alert()->success('Değiştirme işlemi başarılı')->autoClose(5000);
        return redirect()->route("category.index");

    }


    public function delete(Request $request)
    {
        $request->validate(['id' => 'required', 'integer']);
        $categoryID = $request->id;
        Category::where('id', $categoryID)->delete();
        alert()->success('Başarı ile silindir !');
        return redirect()->route("category.index");
    }

    // Edit bölümü validate  yolladığımızda  request->all çekersek   boş döndürüyor    ama request->id çekersek bize değeri veriyor  o yüzden  validateyi başka şekilde yapacağım
    public function edit(Request $request)
    {
        $categories = Category::all();

        $categoryID = $request->id;
        $category = Category::where("id", $categoryID)->first();
        if (is_null($category)) {
            alert()
                ->warning("içerik Bulunamadı !")
                ->showConfirmButton("tamam", "info")
                ->autoClose(5000);
            return redirect()->route('category.index');
        }
        return view("admin.categories.create-update", compact("category", "categories"));
    }

    public function update(Request $request)
    {
        $slug = Str::slug($request->slug);
        $slugcheck = $this->slugCheck($slug);

        $category = Category::find($request->id);
        $category->name = $request->name;
        if ((!is_null($slugcheck) && $slugcheck->id) || is_null($slugcheck)) {
            $category->slug = $slug;
        } elseif (is_null($slugcheck)) {
            $category->slug = Str::slug($slug . time());
        }
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;
        $category->status = $request->status ? 1 : 0;
        $category->feature_status = $request->feature_status ? 1 : 0;
        $category->seo_keywords = $request->seo_keywords;
        $category->seo_description = $request->seo_description;
//        $category->user_id = random_int(1, 10);
        $category->order = $request->order;

        $category->save();


        alert()->success("işlem başarı ile gerçekleşti ")->showConfirmButton("tamam")->autoClose(5000);
        return redirect()->route("category.index");
    }


}
