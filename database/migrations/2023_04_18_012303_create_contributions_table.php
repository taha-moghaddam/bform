<?php

use Bikaraan\BForm\Enums\ReviewStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->enum('review_status', ReviewStatus::values())->default(ReviewStatus::PENDING->value);
            $table->timestamp('reviewed_at')->nullable();
            $table->text('review_comment')->nullable();
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
