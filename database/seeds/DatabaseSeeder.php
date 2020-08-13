<?php

use App\Models\Applicant;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Employee::class,50)->create();
        factory(Applicant::class,50)->create();
    }
}
