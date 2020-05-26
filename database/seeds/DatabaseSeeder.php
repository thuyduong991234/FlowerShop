<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
        {$this->call([
            AdminSeeder::class,
            CustomerSeeder::class,
            CatalogSeeder::class,
            FlowerSeeder::class,
            TransactionSeeder::class,
            Transaction_flowerSeeder::class
        ]);
    }
}
