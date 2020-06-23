<?php

use Illuminate\Database\Seeder;

class TransactionFlowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Models\TransactionFlower::class, 5)->create();
    }
}
