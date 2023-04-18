<?php

use Bikaraan\BForm\Enums\ReviewStatus;
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
        Schema::create(config('admin.extensions.bform.config.db-prefix') . 'user_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('field_id');
            $table->string('value');
            $table->enum('review_status', ReviewStatus::values());
            $table->timestamp('reviewed_at')->nullable();
            $table->text('review_comment');
            $table->foreignId('review_admin_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('admin.extensions.bform.config.db-prefix') . 'user_data');
    }
};
