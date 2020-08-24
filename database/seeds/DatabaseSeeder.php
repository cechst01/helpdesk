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
        $this->call(TicketTypesSeeder::class);
        $this->call(TicketStatesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(AllowedIpAddressesSeeder::class);
    }
}