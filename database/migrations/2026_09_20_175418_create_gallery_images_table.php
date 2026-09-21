<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_category_id')
                ->constrained('gallery_categories')
                ->cascadeOnDelete();

            $table->string('image');
            $table->string('title');
            $table->string('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->unsignedInteger('priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['gallery_category_id', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_images');
    }
};
