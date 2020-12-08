<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterArticlesIntegerColumns extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('comments_count')->change();
            $table->unsignedBigInteger('public_reactions_count')->change();
            $table->unsignedBigInteger('positive_reactions_count')->change();
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedInteger('comments_count')->change();
            $table->unsignedInteger('public_reactions_count')->change();
            $table->unsignedInteger('positive_reactions_count')->change();
        });
    }
}
