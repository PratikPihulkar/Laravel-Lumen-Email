<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dept;
use App\Models\Emp;
use Faker\Factory as Faker;
use Carbon\Carbon;
class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker= Faker::create();
        for ($i=0; $i<10; $i++)
        {
            $empp= new Emp;
            $empp->employee_id='e'.Carbon::now().$faker->word;
            $empp->profile_pic='Img Not Filled';
            $empp->name=$faker->name;
            $empp->email=$faker->email;
            $empp->phone=9876543210;
            $empp->age=52;
            $empp->address = json_encode(['address' => $faker->address]);
            $empp->date_of_joining=$faker->date;
            $empp->code=121212;
        $empp->save();
        }
        
    }
}
