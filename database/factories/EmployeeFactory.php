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

$factory->define(App\Employee::class, function (Faker\Generator $faker) {

    return [
        'dni'=> $dni = $faker->unique()->ean8,
        'code'=> $code = $faker->ean8 ,
        'names'=> $names = $faker->firstName(),
        'surname'=> $surname = $faker->lastName(),
        'profile'=> $profile = $faker->randomElement(['Administrativo','Bolsista','Bibliotecario']) ,
        'date_of_birth'=> $date_of_birth = $faker->date('Y-m-d', 'now'),
        'phone'=> $phone= $faker->phoneNumber,
        'gender'=> $gender = $faker->randomElement(['M','F']),
        'address'=> $address = $faker->address,
        'email' => $email = $faker->email, 
    ];
});
