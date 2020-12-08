<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('title');
            $table->text('description');
            $table->string('slug');
            $table->string('path');
            $table->string('url');
            $table->string('canonical_url');
            $table->unsignedBigInteger('comments_count');
            $table->unsignedBigInteger('public_reactions_count');
            $table->unsignedBigInteger('positive_reactions_count');
            $table->string('tags');
            $table->longText('body_html');
            $table->timestamp('published_timestamp');

            $table->foreignId('user_id')->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
}
