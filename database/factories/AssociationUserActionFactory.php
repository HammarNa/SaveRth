<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\AssociationUserAction;
use Faker\Generator as Faker;

$factory->define(AssociationUserAction::class, function (Faker $faker) {

    $users = App\User::pluck('id')->toArray();
    $actions = App\Action::pluck('id')->toArray();
       
        return [
            'user_id' => $faker->randomElement($users),
            'action_id' => $faker->randomElement($actions),
    ];
});
