<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->string("id_code")->primary();
            $table->text("body_html");
            $table->foreignId("user_id")->constrained();
            $table->foreignId("article_id")->constrained();
            $table->string("parent_id_code")->nullable();
            $table->timestamp("created_at");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
}
