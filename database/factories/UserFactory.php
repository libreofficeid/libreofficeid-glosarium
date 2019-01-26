<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => "Rania Amina",
        'email' => "raniaamina@libreoffice.id",
        'password' => '$2y$10$x.KmiP0ASPgQ6pWnTKWv3uSBGRcEbBg9frEPQrayRCXifr5uIyzX6', // secret
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Glosarium::class, function (Faker $faker){
  return [
    'source' => "paste",
    'translated' => "rekat",
    'created_by' => 1
  ];
});
