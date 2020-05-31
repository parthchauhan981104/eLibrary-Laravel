<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
          $table->string('name');
          $table->integer('author_id');
          $table->string('author_name');
          $table->string('categories'); //stored together as separated by comma (implode)
          $table->string('readers_email')->default(""); //stored together as separated by comma (implode)
          $table->integer('readerscount')->default(0);
          $table->string('img_path')->default('images/books/book1.jpg');
          $table->primary(['name', 'author_id']);
          //$table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
          // For use case when the author that wrote the book is deleted,
          //we can also use onDelete('set null') which will remove the
          //author_id from the book but still leave it in the database.

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
        Schema::dropIfExists('books');
    }
}
