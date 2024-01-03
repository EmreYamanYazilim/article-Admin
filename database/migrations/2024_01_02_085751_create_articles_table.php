<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("category_id")->nullable();
            $table->unsignedBigInteger("user_id");
            $table->string("image")->nullable();
            $table->string("title");
            $table->string("slug");
            $table->text("body");
            $table->boolean("status")->default(0);
            $table->string("tags")->nullable();
            $table->integer("view_count")->default(0);
            $table->integer("like_count")->default(0);
            $table->integer("read_time")->default(0);
            $table->dateTime("publish_date")->nullable();
            $table->string("seo_keywords")->nullable();
            $table->string("seo_description")->nullable();
            $table->timestamps();

            $table->foreign("category_id")
                ->references("id")
                ->on("categories")
                ->onDelete("cascade");
            $table->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
