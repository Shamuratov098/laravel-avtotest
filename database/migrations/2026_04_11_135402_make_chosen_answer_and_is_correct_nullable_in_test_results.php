<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->tinyInteger('chosen_answer')->nullable()->change();
            $table->boolean('is_correct')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->tinyInteger('chosen_answer')->nullable(false)->change();
            $table->boolean('is_correct')->nullable(false)->change();
        });
    }
};
