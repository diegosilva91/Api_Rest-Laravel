<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
        for($i = 0; $i<20; $i++) {
            $name = $faker->company();
            $unique_code =strtoupper(Str::limit($name,4,'')).$faker->randomNumber(3);
            $description = $faker->text(50);
            $logo=$faker->imageUrl();
            \DB::table('actions')->insert(array(
                'name' => $name,
                'unique_code'=>$unique_code,
                'description' => $description,
                'logo' => $logo,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));
        }

    }
}
