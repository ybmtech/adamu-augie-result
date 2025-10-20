<?php

namespace Database\Seeders;

use App\Models\Session;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        for($i=2005; $i <= 2030; $i++) {
            $session = $i.'/'.($i+1);
            Session::create([
            'name'=>$session
            ]);
        }

    }
}
