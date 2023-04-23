<?php

use Bikaraan\BForm\Enums\FieldFillOut;
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
            $table->enum('fill_out', FieldFillOut::values())->nullable()->comment('This field fill-out this column')->after('reference_field_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(config('admin.extensions.bform.config.db-prefix') . 'field_pattern', function (Blueprint $table) {
            $table->dropColumn('fill_out');
        });
    }
};
