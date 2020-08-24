<?php

use Illuminate\Database\Seeder;

class AllowedIpAddressesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('allowed_ip_addresses')->insert([
            ['ip_address' => '88.208.94.187'],
        ]);
    }
}
