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
    {
        $this->call(UserSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(RouteKnownTableSeeder::class);
        $this->call(CustomerGroupTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(StockBrokerTableSeeder::class);
    }
}
