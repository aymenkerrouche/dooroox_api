<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('price');
            $table->dateTime('date');
            $table->enum('type', ['online', 'onsite']);
            $table->string('cover_picture')->nullable();
            $table->string('tag')->nullable();
            $table->string('zoom_link')->nullable();
            $table->string('location')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
