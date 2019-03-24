<?php

use Faker\Generator as Faker;

$factory->define(App\Foo::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
