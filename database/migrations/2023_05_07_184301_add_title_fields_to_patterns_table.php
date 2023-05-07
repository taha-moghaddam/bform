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
        Schema::table(config('admin.extensions.bform.config.db-prefix') . 'patterns', function (Blueprint $table) {
            $table->json('title_fields_id')->nullable()->comment('Fields to show on contribution-title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(config('admin.extensions.bform.config.db-prefix') . 'patterns', function (Blueprint $table) {
            $table->dropColumn('title_fields_id');
        });
    }
};
