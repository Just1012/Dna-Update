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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->double('total');
            $table->unsignedBigInteger('program_id');
            $table->longText('meals_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->longText('vulnerability')->nullable();
            $table->unsignedBigInteger('duration_id');
            $table->longText('unlike')->nullable();
            $table->longText('transaction_status')->nullable();
            $table->longText('transaction_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->foreign('duration_id')->references('id')->on('durations')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
