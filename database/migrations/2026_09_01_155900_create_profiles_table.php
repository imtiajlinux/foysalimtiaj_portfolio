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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            // Basic information
            $table->string('name');
            $table->string('title')->nullable();
            // Contact information
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            // Personal information
            $table->date('date_of_birth')->nullable();
            // Profile content
            $table->string('profile_photo')->nullable();
            $table->string('cv_file')->nullable();
            $table->string('website')->nullable();

            $table->text('short_bio')->nullable();
            $table->longText('about')->nullable();
            // Address
            $table->text('current_address')->nullable();
            $table->text('permanent_address')->nullable();
            // Status
            $table->char('status', 1)->default('a');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
