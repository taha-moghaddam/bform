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
        Schema::create(config('admin.extensions.bform.config.db-prefix') . 'field_pattern', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pattern_id');
            $table->foreignId('field_id');
            $table->string('default_value')->nullable();
            $table->boolean('is_required');
            $table->unsignedSmallInteger('order')->default(10);
            $table->foreignId('reference_field_id')->nullable()->comment('Source of truth of this field in review-panel');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('admin.extensions.bform.config.db-prefix') . 'field_pattern');
    }
};
