<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
      'name' => $faker->name,
      'author_name' => Str::random(5),
      'categories' => Str::random(5),
      'author_id' => factory(App\Author::class)
    ];
});
