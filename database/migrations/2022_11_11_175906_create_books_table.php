<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            // $table->longtext('description');
            $table->string('author',50);
            $table->unsignedBigInteger('language');
            $table->unsignedBigInteger('category');
            $table->foreign('category')->references('id')->on('categories');
            $table->foreign('language')->references('id')->on('languages');
            $table->text('image_path')->nullable();
            $table->text('audio_path')->nullable();
            $table->longtext('about_book')->nullable();
            $table->longtext('about_audience')->nullable();
            $table->longtext('about_author')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
