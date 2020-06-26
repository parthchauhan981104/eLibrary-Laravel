<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
          $table->id('id');
          $table->string('name');
          $table->string('email')->unique();
          $table->timestamp('email_verified_at')->nullable();
          $table->string('password', 255);
          $table->rememberToken();
          $table->string('google_id')->nullable();
          $table->string('img_path')->default('images/users/user.png');
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
        Schema::dropIfExists('users');
    }
}
