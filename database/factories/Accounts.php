<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Accounts;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Accounts::class, function (Faker $faker) {
    $fname = $faker->firstName() ;
    $lname = $faker->lastName();
    $fullname = $fname . ' '  . $lname;
    return [
        'name' => $fullname,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'first_name' => $fname,
        'last_name' => $lname,
        'country' => 'pk',
        'phone_number' => '3029258258',
    ];
});
