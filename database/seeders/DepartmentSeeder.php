<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          $departments=[
  "Educational Management",
  "Human Kinetic Sports and Health Education",
  "Language Arts and Social Science Education",
  "Educational Foundation and Counseling Psychology",
  "Science and Technology Education",
  "Early Childhood Care and Education",
  "Curriculum and Instruction",
  "Special Education",
  "Library and Information Science",
  "Mathematics Education",
  "Guidance and Counselling",
  "Vocational and Technical Education",
  "Computer Science Education",
  "Business Studies Education"
];
        foreach($departments as $department){
            Department::create(['name'=>$department]);
        }
    }
}
