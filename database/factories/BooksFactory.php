<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Books;
use Faker\Generator as Faker;

$factory->define(Books::class, function (Faker $faker) {
    return [
      'name' => $faker->name,
      'author_name' => Str::random(5),
      'categories' => Str::random(5),
      'author_id' => factory(App\Authors::class)
    ];
});
