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
        for($i = 0; $i<20; $i++) {
            $current_quantity = $fake->randomFloat(1,0,100);
            $action_id=$i*10+1;
            $date=$fake->dateTimeBetween('-15 days','now');
            \DB::table('prices')->insert(array(
                'current_quantity' => $current_quantity,
                'actions_id'=>$action_id,
                'created_at' => $date,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ));
        }
    }
}
