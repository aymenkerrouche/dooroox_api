<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wallet_id');
            $table->unsignedBigInteger('course_id');
            $table->integer('amount');
            $table->enum('payment_type', ['online', 'cash']);
            $table->boolean('course_enrolled')->default(true);
            $table->boolean('course_completed')->default(false);
            $table->timestamps();

            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');


            $table->unique(['wallet_id', 'course_id']);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
