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
        Schema::table(config('admin.extensions.bform.config.db-prefix') . 'forms', function (Blueprint $table) {
            $table->boolean('active')->default(true);
            $table->unsignedSmallInteger('contribution_limit')->default(1)->comment('0 means unlimited');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(config('admin.extensions.bform.config.db-prefix') . 'forms', function (Blueprint $table) {
            $table->dropColumn('active');
            $table->dropColumn('contribution_limit');
        });
    }
};
