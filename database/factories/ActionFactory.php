<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Action;
use Faker\Generator as Faker;

$factory->define(Action::class, function (Faker $faker) {
    $users = App\User::pluck('id')->toArray();
    return [
        'name' => $faker->name,
        'description' => $faker->paragraph(),
        'address' => $faker->address,
        'user_id' => $faker->randomElement($users),
        'date' => new DateTime(),
    ];
});
