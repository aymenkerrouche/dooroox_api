<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('content_type');
            $table->integer('price');
            $table->string('cover_picture')->nullable();
            $table->float('total_rate')->default(5.0);
            $table->integer('total_comment')->default(0);
            $table->string('tag')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('users');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
