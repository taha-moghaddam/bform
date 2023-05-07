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
        Schema::table(config('admin.extensions.bform.config.db-prefix') . 'field_pattern', function (Blueprint $table) {
            $table->json('reference_fields_id')->nullable()->comment('Source of truth of this field in review-panel');
            $table->dropColumn('reference_field_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(config('admin.extensions.bform.config.db-prefix') . 'field_pattern', function (Blueprint $table) {
            $table->dropColumn('reference_fields_id');
            $table->foreignId('reference_field_id')->nullable()->comment('Source of truth of this field in review-panel');
        });
    }
};
