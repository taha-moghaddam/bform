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
        Schema::create(config('admin.extensions.bform.config.db-prefix') . 'contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('form_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('admin.extensions.bform.config.db-prefix') . 'contributions');
    }
};
