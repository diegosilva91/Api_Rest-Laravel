<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(UsersTableSeeder::class);
        //Model::unguard();
        $this->call('ActionsTableSeeder');
        for ($i=0;$i<=20;$i++){
            $this->call('PricesTableSeeder');
        }
    }
}
