<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->primary();
            $table->string("title");
            $table->text("description");
            $table->string("slug");
            $table->string("path");
            $table->string("url");
            $table->string("canonical_url");
            $table->unsignedInteger("comments_count");
            $table->unsignedInteger("public_reactions_count");
            $table->unsignedInteger("positive_reactions_count");
            $table->json("tags");
            $table->longText("body_html");
            $table->timestamp("published_timestamp");

            $table->foreignId("user_id")->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
}
