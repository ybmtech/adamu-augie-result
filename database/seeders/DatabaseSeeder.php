<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SessionSeeder::class,
            LevelSeeder::class,
            DepartmentSeeder::class,
            SemesterSeeder::class,
            Roleseeder::class,
            UserSeeder::class,
            CourseSeeder::class,
         ]);
    }
}
