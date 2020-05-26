<?php

use Illuminate\Database\Seeder;

class Transaction_flowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Transaction_flower::class, 5)->create();
    }
}
