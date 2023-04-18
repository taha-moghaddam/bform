<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Bikaraan\BForm\Enums\FieldType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('admin.extensions.bform.config.db-prefix') . 'fields', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->enum('type', FieldType::values());
            $table->smallInteger('lifetime');
            $table->string('default_value')->nullable();
            $table->string('rules')->nullable();
            $table->string('hint')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('admin.extensions.bform.config.db-prefix') . 'fields');
    }
};
