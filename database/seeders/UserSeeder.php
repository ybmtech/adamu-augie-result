<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $create_date=date('Y-m-d H:i:s');

        $admin_info= [
            'name'=>'Admin',
            'username'=>'admin',
            'email'=>'admin@gmail.com',
            'avatar'=>'',
            'password'=>Hash::make('password'),
        ];
     
    

         $admin= User::create($admin_info);

         $student=User::create(
            [
            'name'=>'Bala Musa',
            'username'=>'15104040',
            'email'=>'balamusa@mail.com',
            'avatar'=>'',
            'password'=>Hash::make('password'),
        ]
         );
         $student->profile()->create([
        'level_id'=>1,
        'department_id'=>1,
        'admission_no'=>'15104040',
        'phone'=>'08169677397'
    ]);

    
        //assign role to user as admin
        $admin->assignRole('examiner');

        $student->assignRole('student');
    }
}
