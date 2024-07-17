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
        Schema::create('order_dayes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');

            $table->tinyInteger('mon')->default(1);
            $table->tinyInteger('tue')->default(1);
            $table->tinyInteger('wed')->default(1);
            $table->tinyInteger('thu')->default(1);
            $table->tinyInteger('sun')->default(1);
            $table->tinyInteger('sat')->default(1);
            $table->tinyInteger('fri')->default(1);
            $table->softDeletes();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('address_id');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_dayes');
    }
};
