<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ["id", "created_at", "updated_at"];

    public function parentCategory(): HasOne
    {
        return $this->hasOne(Category::class, "id", "parent_id");// burda Category modeldeki id ile benim bulunduğum bu model sayfası içindeki yani yine category parent_id ile bağlantı kur demek istiyorum
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, "id", "user_id"); //burda User modelinin içindeki foreignkeyi olan id  ile  Category model içindeki user_id arasında bağlantı kur demek istedim
    }

    public function scopeName($query, $name)
    {
        if (!is_null($name)) {
            $query->where("name", "LIKE", "%" . $name . "%");
        }
    }

    public function scopeSlug($query, $slug)
    {
        if (!is_null($slug)) {
            $query->where("slug", "LIKE", "%" . $slug . "%");
        }
    }

    public function scopeDescription($query , $description)
    {
        if (!is_null($description)) {
            $query->where("description", "LIKE", "%" . $description . "%");
        }
    }

    public function scopeOrder($query, $order)
    {
        if (!is_null($order)) {
            $query->where("order",  $order);
        }
    }

    public function scopeStatus($query ,$status)
    {
        if (!is_null($status)) {
            $query->where("status", $status);
        }
    }

    public function scopefeatureStatus($query ,$featurestatus)
    {
        if (!is_null($featurestatus)) {
            $query->where("feature_status", $featurestatus);
        }
    }
}
