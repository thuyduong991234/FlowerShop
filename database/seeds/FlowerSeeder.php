<?php

use Illuminate\Database\Seeder;

class FlowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Flower::class, 5)->create();
    }
}
