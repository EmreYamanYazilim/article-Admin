<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $guarded = ["id","created_at","updated_at"];

    public function category()
    {
        return $this->hasOne(Category::class, "id", "category_id");
    }

    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }



    public function scopeStatus($query,$status)
    {
        if (!is_null($status)) {
            return $query->where("status", $status);
        }
    }

    public function scopeCategory($query,$category_id)
    {
        if (!is_null($category_id)) {
            return $query->where("category_id", $category_id);
        }
    }

    public function scopeUser($query,$user)
    {
        if (!is_null($user)) {
            return $query->where("user_id", $user);
        }
    }

    public function scopePublishDate($query,$publish_date)
    {
        if (!is_null($publish_date)) {
            $publish_date = Carbon::parse("publish_date")->format("Y-m-d H:i:s");
            return $query->where("publish_date", $publish_date);
        }
    }


}


