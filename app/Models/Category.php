<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ["id", "created_at", "updated_at"];

    public function parentCategory():HasOne
    {
        return $this->hasOne(Category::class, "id", "parent_id");// burda Category modeldeki id ile benim bulunduğum bu model sayfası içindeki yani yine category parent_id ile bağlantı kur demek istiyorum
    }

    public function user():HasOne
    {
        return $this->hasOne(User::class,"id","user_id"); //burda User modelinin içindeki foreignkeyi olan id  ile  Category model içindeki user_id arasında bağlantı kur demek istedim
    }
}
