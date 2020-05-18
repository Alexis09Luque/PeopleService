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

$factory->define(App\Applicant::class, function (Faker\Generator $faker) {

    return [
        
        'dni'=> $dni = $faker->unique()->ean8,
        'names'=> $names = $faker->firstName(),
        'surname'=> $surname = $faker->lastName(),
        'gender'=> $gender = $faker->randomElement(['M','F']),
        'type'=> $type = $faker->randomElement(['Posgrado','Externo','Pregrado']),
        'institutional_email'=> $institutional_email = $faker->unique()->safeEmail,
        'photo'=> $photo = $faker->url,
        'code'=> $code = $faker->ean8 ,
        'school_id'=> $school_id = $faker->numberBetween(1,50),
        'phone'=> $phone= $faker->phoneNumber,
        'mobile'=> $phone= $faker->phoneNumber,
        'personal_email'=> $personal_email = $faker->unique()->email,
        'address'=> $address = $faker->address,
        'description'=> $description = $faker->text(200),
    ];
});
