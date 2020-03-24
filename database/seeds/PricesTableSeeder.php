<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $fake = Faker::create();
        for($i = 1; $i<21; $i++) {
            $current_quantity = $fake->randomFloat(1,0,100);
            $action_id=$fake->numberBetween(1,20);
            \DB::table('prices')->insert(array(
                'current_quantity' => $current_quantity,
                'actions_id'=>$action_id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));
        }
    }
}
