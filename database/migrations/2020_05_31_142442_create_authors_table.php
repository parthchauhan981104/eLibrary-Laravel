<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('name');
          // $table->string('books'); //stored together as separated by comma (implode)
          $table->integer('bookscount')->default(0);
          $table->string('categories')->default(""); //stored together as separated by comma (implode)
          $table->integer('readcount')->default(0);
          $table->timestamps(); //Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authors');
    }
}
