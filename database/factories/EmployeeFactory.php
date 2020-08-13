<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\Employee::class, function (Faker\Generator $faker) {

    return [
        'dni'=> $dni = $faker->unique()->ean8,
        'code'=> $code = $faker->ean8 ,
        'names'=> $names = $faker->firstName(),
        'surname'=> $surname = $faker->lastName(),
        'profile_id'=> $profile_id = $faker->numberBetween(1,3),
        'date_of_birth'=> $date_of_birth = $faker->date('Y-m-d', 'now'),
        'gender'=> $gender = $faker->randomElement(['M','F']),
        'phone'=> $phone= $faker->numberBetween(300000000,799999999),
        'mobile'=>$mobile=$faker->numberBetween(900000000,999999999),
        'address'=> $address = $faker->address,
        'email' => $email = $faker->unique()->email, 
        'photo'=> $photo = $faker->text(10),

    ];
});
