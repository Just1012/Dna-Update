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
        Schema::create('contact_settings', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();

            $table->text('facebook')->nullable();
            $table->string('face_image')->nullable();

            $table->text('whatsapp')->nullable();
            $table->string('whats_image')->nullable();

            $table->text('twitter')->nullable();
            $table->string('twitter_image')->nullable();

            $table->text('instagram')->nullable();
            $table->string('instagram_image')->nullable();

            $table->text('snapchat')->nullable();
            $table->string('snapchat_image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_settings');
    }
};