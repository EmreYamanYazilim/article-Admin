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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("parent_id")->nullable(); // id miz bigIncrements  olduğu içinde bunuda big yapmamız gerek
            $table->unsignedBigInteger("user_id");
            $table->string("name");
            $table->string("slug");
            $table->boolean("status")->default(0);
            $table->boolean("feature_status")->default(0);
            $table->string("description")->nullable();
            $table->integer("order")->default(0);
            $table->string("seo_keywords")->nullable();
            $table->string("seo_description")->nullable();
            $table->timestamps();

            $table->foreign("parent_id")
                ->on("categories")
                ->references("id")
                ->onDelete("cascade");
            $table->foreign("user_id")
                ->on("users")
                ->references("id");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
